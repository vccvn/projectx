<?php

namespace App\Http\Controllers\Apis\Payments;

use App\Http\Controllers\Apis\ApiController;


use App\Engines\Helper;
use App\Engines\MailAlert;
use App\Engines\SystemMailAlert;
use App\Exceptions\NotReportException;
use App\Models\WebAccountLimitedUpgradePayment;
use App\Repositories\Emails\EmailTokenRepository;
use App\Repositories\Files\FileRepository;
use App\Repositories\Packages\WebAccountLimitedUpgradePaymentRepository;
use Illuminate\Http\Request;
use Crazy\Helpers\Arr;

use App\Repositories\Transactions\AccountUpgradePaymentTransactionRepository;
use App\Repositories\Users\UserRepository;
use App\Validators\Payments\PackagePaymentValidator;
use App\Validators\Transactions\TransferPackagePaymentValidator;
use Crazy\Mailer\Email;
use Exception;


class VNPayController extends ApiController
{
    protected $module = 'payments';

    protected $moduleName = 'Thông tin thanh toán';

    protected $flashMode = false;


    /**
     * customer
     *
     * @var UserRepository $userRepository
     */
    protected $userRepository = null;
    /**
     * email token
     *
     * @var EmailTokenRepository
     */
    protected $emailTokenRepository = null;

    protected $errors = [];

    /**
     * file
     *
     * @var FileRepository
     */
    protected $fileRepository = null;


    /**
     * str
     *
     * @var AccountUpgradePaymentTransactionRepository
     */
    public $repository = null;


    /**
     * @var WebAccountLimitedUpgradePaymentRepository
     */
    public $paymentRepository;

    /**
     * @var WebAccountLimitedUpgradePayment
     */
    public $packagePayment = null;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(
        AccountUpgradePaymentTransactionRepository $repository,
        WebAccountLimitedUpgradePaymentRepository $paymentRepository,
        UserRepository $userRepository,
        EmailTokenRepository $emailTokenRepository,
        FileRepository $fileRepository
    ) {
        $this->repository = $repository;
        // $this->userServiceRepository = $userServiceRepository;
        $this->userRepository = $userRepository->notTrashed();

        $this->paymentRepository = $paymentRepository->notTrashed();

        $this->emailTokenRepository = $emailTokenRepository;

        $this->repository->setValidatorClass(TransferPackagePaymentValidator::class);
        $this->fileRepository = $fileRepository;
        $this->init();
    }

    public function approveTransaction(Request $request, $payment, $transactionCode = null)
    {
        $data = new Arr();
        $total = 0;
        $data->type = 'payment';
        if ($package = $payment->package) {
            $total = $package->price;
            if ($data->transaction_type == 'upgrade') {
                $data->type = 'upgrade';
            }
        }

        $data->amount = $total;
        $data->time = date('Y-m-d H:i:s');
        $user = $payment->user;
        $data->customer_id = $payment->user->id;
        $data->created_id = $payment->user->id;
        $data->ref_id = $payment->id;
        $data->status = 1;
        $data->code = $transactionCode;
        $stt = false;
        if ($d = $this->repository->create($data->all())) {
            if ($setting = $user->userWebSetting) {
                // $userWebSetting = $user->userWebSetting;

                $setting->account_limited += $package->user_limited;
                $setting->save();
                $payment->status = 1;
                $payment->save();
                $stt = $d;
                try {
                    $this->repository->sendMailAlertStatus($d->id);
                } catch (NotReportException $th) {
                    //throw $th;
                }
            } else {
                $d->delete();
            }
        }
        return $stt;
    }

    /**
     * Undocumented function
     *
     * @param Request $request
     * @return void
     */
    public function vnPayCreate(Request $request)
    {
        $user = $request->user();
        $packagePayment = ($package_payment_id = session('package_payment_id')) ? $this->paymentRepository->with('package')->mode('mask')->detail($package_payment_id) : null;
        if (!$packagePayment) return $this->checkout($request);
        $methods = Helper::getPaymentMethodOptions();
        // dd($methods);
        if (!is_countable($methods) || !($vnpay = $methods->vnpay) || !($config = $vnpay->config) || !isset($config['TmnCode']) || !isset($config['HashSecret'])) abort(404);
        $package = $packagePayment->package;


        $vnp_Url = "http://sandbox.vnpayment.vn/paymentv2/vpcpay.html";
        $vnp_Returnurl = 'https://vnpay.fpoly.vn/check';
        $transaction_type = $request->get('transaction_type', session('transaction_type', 'payment'));


        $vnp_TmnCode = $config['TmnCode']; //Mã website tại VNPAY
        $vnp_HashSecret = $config['HashSecret']; //Chuỗi bí mật

        $vnp_TxnRef = $package_payment_id; // date('YmdHis'); //Mã đơn hàng. Trong thực tế Merchant cần insert đơn hàng vào DB và gửi mã này sang VNPAY
        $vnp_OrderInfo = null;
        $vnp_OrderType = '130005';
        $vnp_Amount = $package->price * 100;
        $vnp_Locale = 'vi-VN';
        $vnp_IpAddr = env('APP_IP_ADDRESS', $_SERVER['REMOTE_ADDR']);
        $inputData = array(
            "vnp_Version" => "2.0.0",
            "vnp_TmnCode" => $vnp_TmnCode,
            "vnp_Amount" => $vnp_Amount,
            "vnp_Command" => "pay",
            "vnp_CreateDate" => date('YmdHis'),
            "vnp_CurrCode" => "VND",
            "vnp_IpAddr" => $vnp_IpAddr,
            "vnp_Locale" => $vnp_Locale,
            "vnp_OrderInfo" => $vnp_OrderInfo,
            "vnp_OrderType" => $vnp_OrderType,
            "vnp_ReturnUrl" => $vnp_Returnurl,
            "vnp_TxnRef" => $vnp_TxnRef,
        );
        $inputData['vnp_BankCode'] = session('vnpay_bank', $request->vnpay_bank);
        // dd($inputData);
        ksort($inputData);
        $query = "";
        $i = 0;
        $hashdata = "";
        foreach ($inputData as $key => $value) {
            if ($i == 1) {
                $hashdata .= '&' . $key . "=" . $value;
            } else {
                $hashdata .= $key . "=" . $value;
                $i = 1;
            }
            $query .= urlencode($key) . "=" . urlencode($value) . '&';
        }

        $vnp_Url = $vnp_Url . "?" . $query;
        if (isset($vnp_HashSecret)) {
            $vnpSecureHash = hash('sha256', $vnp_HashSecret . $hashdata);
            $vnp_Url .= 'vnp_SecureHashType=SHA256&vnp_SecureHash=' . $vnpSecureHash;
        }

        // die($vnp_Url);
        return redirect($vnp_Url);
    }

    /**
     * kiểm tra thanh toán
     *
     * @param Request $request
     * @return JSON
     */
    public function vnPayCheck(Request $request)
    {
        // kiểm tra phuong thuc thanh toan
        $methods = Helper::getPaymentMethodOptions();
        if (!is_countable($methods) || !($vnpay = $methods->vnpay) || !($config = $vnpay->config) || !isset($config['TmnCode']) || !isset($config['HashSecret'])) abort(404);
        // code của vnpay


        $inputData = array();
        $returnData = array();
        foreach ($_GET as $key => $value) {
            if (substr($key, 0, 4) == "vnp_") {
                $inputData[$key] = $value;
            }
        }

        $vnp_SecureHash = $inputData['vnp_SecureHash'];
        
        unset($inputData['vnp_SecureHash']);
        ksort($inputData);
        $i = 0;
        $hashData = "";
        foreach ($inputData as $key => $value) {
            if ($i == 1) {
                $hashData = $hashData . '&' . urlencode($key) . "=" . urlencode($value);
            } else {
                $hashData = $hashData . urlencode($key) . "=" . urlencode($value);
                $i = 1;
            }
        }

        $secureHash = hash_hmac('sha512', $hashData, $config['HashSecret']);
        $vnpTranId = $inputData['vnp_TransactionNo']; //Mã giao dịch tại VNPAY
        $vnp_BankCode = $inputData['vnp_BankCode']; //Ngân hàng thanh toán
        $vnp_Amount = $inputData['vnp_Amount'] / 100; // Số tiền thanh toán VNPAY phản hồi

        $Status = 0; // Là trạng thái thanh toán của giao dịch chưa có IPN lưu tại hệ thống của merchant chiều khởi tạo URL thanh toán.
        $orderId = $inputData['vnp_TxnRef'];













        // bắt đầu logic
        $payment_id = $orderId ?? 0;
        $rspCode = '99';
        $vnMessage = [
            '00' => 'Success',
            '97' => 'Chu ky khong hop le',
            '01' => 'Order not found',
            '02' => 'Order already confirmed',
            '99' => 'Loi khong xac dinh'
        ];

        try {
            //Check Orderid
            //Kiểm tra checksum của dữ liệu
            if ($secureHash != $vnp_SecureHash) {
                $rspCode = '97';
            }
            // dịch vụ không tồn tại
            else if (!$payment_id || !($payment = $this->paymentRepository->with(['package', 'user'])->mode('mask')->detail($payment_id))) {
                $rspCode = '01';
            }
            // dịch vụ đã dược thanh toán trước đó
            else if ($payment->status != 0) {
                $rspCode = '02';
            }
            // nếu thanh công sẽ kiểm tra khởi tạo dịch vụ
            elseif (!$this->approveTransaction($request, $payment, $vnpTranId)) {
                $rspCode = '99';
            }
            // thanh toan thanh công
            else {

                // code
                $rspCode = '00';
            }
            $returnData['RspCode'] = $rspCode;
            $returnData['Message'] = $vnMessage[$rspCode];
        } catch (Exception $e) {
            $returnData['RspCode'] = '99';
            $returnData['Message'] = 'Unknow error';
        }
        //Trả lại VNPAY theo định dạng JSON
        return $returnData;
    }

    public function vnPayStatus(Request $request)
    {
        $methods = Helper::getPaymentMethodOptions();
        if (!is_countable($methods) || !($vnpay = $methods->vnpay) || !($config = $vnpay->config) || !isset($config['TmnCode']) || !isset($config['HashSecret'])) abort(404);
        $vnp_SecureHash = $request->vnp_SecureHash;
        $inputData = array();
        foreach ($_GET as $key => $value) {
            if (substr($key, 0, 4) == "vnp_") {
                $inputData[$key] = $value;
            }
        }

        unset($inputData['vnp_SecureHash']);
        ksort($inputData);
        $i = 0;
        $hashData = "";
        foreach ($inputData as $key => $value) {
            if ($i == 1) {
                $hashData = $hashData . '&' . urlencode($key) . "=" . urlencode($value);
            } else {
                $hashData = $hashData . urlencode($key) . "=" . urlencode($value);
                $i = 1;
            }
        }

        $secureHash = hash_hmac('sha512', $hashData, $config['HashSecret']);

        $package_payment_id = $inputData['vnp_TxnRef'] ?? 0;
        if ($secureHash == $vnp_SecureHash) {
            if ($request->vnp_ResponseCode == '00') {

                if ($package_payment_id && $payment = $this->paymentRepository->with(['user' => function ($q) {
                    $q->with('userWebSetting');
                }])->detail($package_payment_id)) {
                    $s = $payment->user->userWebSetting;
                    $domain = $s->alias_domain ? $s->alias_domain : $s->subdomain . '.' . $s->base_domain;
                    session(['success' => 'Chúc mừng bạn đã thanh toán dịch vụ thành công!']);
                    return redirect('http://' . $domain);
                }
            } else {
                abort(403,  'Đã xảy ra lỗi trong quá trình thanh toán');
            }
        } else {
            abort(403, 'Chữ ký không hợp lệ');
        }
    }
}
