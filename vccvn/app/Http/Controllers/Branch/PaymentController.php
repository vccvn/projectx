<?php

namespace App\Http\Controllers\Branch;

use App\Engines\Helper;
use App\Engines\MailAlert;
use App\Engines\SystemMailAlert;
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

class PaymentController extends ManagerController
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



    /**
     * can thiệp thêm data trước khi lưu
     *
     * @param Request $request
     * @param Arr $data
     * @return void
     */
    public function beforeCreate(Request $request, Arr $data)
    {
        $payment = $this->paymentRepository->with('package')->detail($request->package_payment_id);
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
        $data->customer_id = $request->user()->id;
        $data->created_id = $request->user()->id;
    }

    /**
     * can thiệp sau khi lưu
     *
     * @param Request $request
     * @param \App\Models\Transaction $result
     * @return void
     */
    public function afterSave(Request $request, $result)
    {
        $user = $request->user();
        $date_path = date('Y/m/d');
        if ($file = $this->uploadImage($request, 'image', null, 'static/users/0/files/' . $date_path)) {
            $upload_by = $user ? $user->id : 0;
            $f = $this->fileRepository->create(array_merge($file->all(), [
                'upload_by' => $upload_by,
                'sid' => md5(microtime() . uniqid()),
                'original_filename' => $file->filename,
                'date_path' => $date_path,
                'privacy' => 'public',
                'ref' => 'transaction',
                'ref_id' => $result->id
            ]));
        }
        $this->redirectRoute = 'packages.index';
        $this->addRedirectData([
            'success' => 'Chúc mừng bạn đã gửi biên lai thanh toán thành công! [nl] Vui lòng chờ giây lát trong khi chúng tôi xác thực giao dịch'
        ]);

        SystemMailAlert::send([
            'subject' => "Thông báo: Có người vừa gửi thông tin thanh toán Dịch vụ",
            'content' => ($user ? $user->name : 'Có người') . " vừa gửi thông tin thanh toán Dịch vụ.\n ID:" . $result->id
        ]);
    }




    /**
     * xem trang thanh toan chuyễn khoản
     *
     * @param Request $request
     * @return void
     */
    public function checkout(Request $request)
    {
        $packagePayment = ($package_payment_id = session('package_payment_id')) ? $this->paymentRepository->mode('mask')->with('package')->detail($package_payment_id) : null;

        $package = $packagePayment ? $packagePayment->package : null;

        $transaction_type = $request->get('transaction_type', session('transaction_type', 'payment'));

        return $this->viewModule('checkout', compact('packagePayment', 'package', 'transaction_type'));
    }




    public function payment(Request $request)
    {

        $validator = $this->repository->validator($request, PackagePaymentValidator::class);
        if (!$validator->success()) {
            return redirect()->back()->with('error', 'Lỗi bất thường')->withErrors($validator->getErrorObject());
        }
        if ($request->payment_method == 'transfer') {
            return $this->transfer($request);
        } elseif ($request->payment_method == 'vnpay') {
            return $this->vnPayCreate($request);
        }
    }




    /**
     * kiễm tra thông tin đơn hàng
     *
     * @param Request $request
     * @return void
     */
    public function checkPackagePayment(Request $request)
    {
        if (!$request->package_payment_id || !($packagePayment = $this->paymentRepository->with('package')->findBy('id', $request->package_payment_id))) {
            return redirect()->back()->withErrors(['package_payment_id' => 'Mã thanh toán không hợp lệ'])->with(['error' => 'Thông tin thanh toán không hợp lệ'])->withInput($request->all());
        }
        session(['package_payment_id' => $packagePayment->id]);
        if ($request->transaction_type) {
            session(['transaction_type' => $request->transaction_type]);
        }
        return redirect()->route('payments.checkout');
    }


    /**
     * xem trang thanh toan chuyễn khoản
     *
     * @param Request $request
     * @return void
     */
    public function transfer(Request $request)
    {
        $page_title = 'Thanh toán chuyển khoản';

        $user = $request->user();
        $packagePayment = ($package_payment_id = session('package_payment_id')) ? $this->paymentRepository->mode('mask')->detail($package_payment_id) : null;

        // $this->breadcrumb->add($page_title);

        $transaction_type = $request->get('transaction_type', session('transaction_type', 'payment'));

        return $this->viewModule('transfer', compact('user', 'page_title', 'packagePayment', 'transaction_type'));
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

        $transaction_type = $request->get('transaction_type', session('transaction_type', 'payment'));

        $startTime = date("YmdHis");
        $expire = date('YmdHis',strtotime('+15 minutes',strtotime($startTime)));

        $vnp_Url = "https://sandbox.vnpayment.vn/paymentv2/vpcpay.html";
        // $vnp_Returnurl = "http://localhost/vnpay_php/vnpay_return.php";
        $vnp_apiUrl = "http://sandbox.vnpayment.vn/merchant_webapi/merchant.html";

        // $vnp_Url = "http://sandbox.vnpayment.vn/paymentv2/vpcpay.html";
        $vnp_Returnurl = 'http://payments.fpoly.vn/vnpay-status';



        $vnp_TmnCode = $config['TmnCode']; //Mã website tại VNPAY
        $vnp_HashSecret = $config['HashSecret']; //Chuỗi bí mật



        $vnp_TxnRef = $package_payment_id; // date('YmdHis'); //Mã đơn hàng. Trong thực tế Merchant cần insert đơn hàng vào DB và gửi mã này sang VNPAY
        $vnp_OrderInfo = "Thanh toán dịch vụ";
        $vnp_OrderType = '130005';
        $vnp_Amount = $package->price * 100;
        $vnp_Locale = 'vn';
        // $vnp_IpAddr = env('APP_IP_ADDRESS', $_SERVER['REMOTE_ADDR']);

        
        $vnp_BankCode = session('vnpay_bank', $request->vnpay_bank);
        $vnp_IpAddr = $_SERVER['REMOTE_ADDR'];
        
        //Add Params of 2.0.1 Version
        $vnp_ExpireDate = $expire;
        //Billing
        $vnp_Bill_Mobile = $user->phone_number;
        $vnp_Bill_Email = $user->email;
        $fullName = trim($user->name);
        if (isset($fullName) && trim($fullName) != '') {
            $name = explode(' ', $fullName);
            $vnp_Bill_FirstName = array_shift($name);
            $vnp_Bill_LastName = array_pop($name);
        }

        // $vnp_Bill_Address=$user->address;
        // $vnp_Bill_City=$_POST['txt_bill_city'];
        // $vnp_Bill_Country=$_POST['txt_bill_country'];
        // $vnp_Bill_State=$_POST['txt_bill_state'];
        // Invoice
        // $vnp_Inv_Phone=$_POST['txt_inv_mobile'];
        // $vnp_Inv_Email=$_POST['txt_inv_email'];
        // $vnp_Inv_Customer=$_POST['txt_inv_customer'];
        // $vnp_Inv_Address=$_POST['txt_inv_addr1'];
        // $vnp_Inv_Company=$_POST['txt_inv_company'];
        // $vnp_Inv_Taxcode=$_POST['txt_inv_taxcode'];
        // $vnp_Inv_Type=$_POST['cbo_inv_type'];

        $inputData = array_merge($vnpay->defaultValues, [
            "vnp_Version" => "2.1.0",
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
            "vnp_ExpireDate"=>$vnp_ExpireDate,
            "vnp_Bill_Mobile"=>$vnp_Bill_Mobile,
            "vnp_Bill_Email"=>$vnp_Bill_Email,
            "vnp_Bill_FirstName"=>$vnp_Bill_FirstName,
            "vnp_Bill_LastName"=>$vnp_Bill_LastName,
            'vnp_BankCode' => $vnp_BankCode,
            // "vnp_Bill_Address"=>$vnp_Bill_Address,
            // "vnp_Bill_City"=>$vnp_Bill_City,
            // "vnp_Bill_Country"=>$vnp_Bill_Country,
            // "vnp_Inv_Phone"=>$vnp_Inv_Phone,
            // "vnp_Inv_Email"=>$vnp_Inv_Email,
            // "vnp_Inv_Customer"=>$vnp_Inv_Customer,
            // "vnp_Inv_Address"=>$vnp_Inv_Address,
            // "vnp_Inv_Company"=>$vnp_Inv_Company,
            // "vnp_Inv_Taxcode"=>$vnp_Inv_Taxcode,
            // "vnp_Inv_Type"=>$vnp_Inv_Type
        ]);

        ksort($inputData);
        // return $inputData;
        $query = "";
        $i = 0;
        $hashdata = "";
        foreach ($inputData as $key => $value) {
            if ($i == 1) {
                $hashdata .= '&' . urlencode($key) . "=" . urlencode($value);
            } else {
                $hashdata .= urlencode($key) . "=" . urlencode($value);
                $i = 1;
            }
            $query .= urlencode($key) . "=" . urlencode($value) . '&';
        }
        
        $vnp_Url = $vnp_Url . "?" . $query;
        if (isset($vnp_HashSecret)) {
            $vnpSecureHash =   hash_hmac('sha512', $hashdata, $vnp_HashSecret); //  
            $vnp_Url .= 'vnp_SecureHash=' . $vnpSecureHash;
        }


        return redirect($vnp_Url);
    }

}
