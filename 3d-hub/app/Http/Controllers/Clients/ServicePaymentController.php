<?php

namespace App\Http\Controllers\Clients;

use App\Engines\Helper;
use App\Engines\MailAlert;
use App\Http\Controllers\Clients\ClientController;
use App\Masks\Services\UserServiceMask;
use App\Models\Transaction;
use App\Models\UserService;
use App\Repositories\Emails\EmailTokenRepository;
use App\Repositories\Files\FileRepository;
use App\Repositories\Promos\ServicePromoRepository;
use App\Repositories\Services\UserServiceRepository;
use App\Repositories\Transactions\ServiceTransactionRepository;
use App\Repositories\Users\UserRepository;
use App\Validators\Payments\ServicePaymentValidator;
use Crazy\Apis\Api;
use Illuminate\Http\Request;
use Crazy\Helpers\Arr;
use Exception;

class ServicePaymentController extends ClientController
{
    protected $module = 'payments';

    protected $moduleName = 'Thanh toán';

    protected $flashMode = true;

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
     * @var ServiceTransactionRepository
     */
    public $repository = null;



    /**
     * str
     *
     * @var UserServiceRepository
     */
    public $userServiceRepository = null;



    /**
     * @var boolean $hasPromo Co khuyen mai hay ko
     */
    public $hasPromo = false;
    
    /**
     * @var string $promoCode Co khuyen mai hay ko
     */
    public $promoCode = false;
    

    /**
     * abv
     * @var ServicePromoRepository
     */
    public $servicePromoRepository = null;


    /**
     * user service
     *
     * @var \App\Models\UserService
     */
    protected $userService = null;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(
        ServiceTransactionRepository $serviceTransactionRepository,
        UserServiceRepository $userServiceRepository,
        ServicePromoRepository $servicePromoRepository,
        UserRepository $userRepository,
        EmailTokenRepository $emailTokenRepository,
        FileRepository $fileRepository
    ) {
        $this->repository = $serviceTransactionRepository;
        $this->userServiceRepository = $userServiceRepository;
        $this->userRepository = $userRepository->addDefaultCondition('deleted', 'deleted', 0);

        $this->emailTokenRepository = $emailTokenRepository;

        $this->repository->setValidatorClass('Transactions\ServicePaymentValidator');
        $this->servicePromoRepository = $servicePromoRepository->notTrashed();
        $this->fileRepository = $fileRepository;
        $this->setting = setting();
        $this->siteinfo = siteinfo();
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
        $userService = $this->userServiceRepository->mode('mask')->detail($request->user_service_id);
        $this->userService = $userService;
        $total = 0;
        $data->type = 'payment';
        if ($package = $userService->package) {
            $data->metadata = [

            ];
            if ($data->transaction_type == 'extension') {
                $data->type = 'extension';
                $total = $package->maintenance_fee;
            } else {
                $total = $package->getFirstPaidAmound();

                $promo_code = session('promo_code');
                if ($promo_code && ($d = $this->servicePromoRepository->checkPromoByPackage($package, $promo_code))) {
                    if ($d['status']) {
                        $label = $d['label'];
                        $data->metadata = array_merge($data->metadata, [
                            'has_promo' => true,
                            'promo_code' => $promo_code,
                            'origin_total' => $total,
                            'final_total' => $d['price']
                        ]);
                        $total = $d['price'];
                        
                        $data->note = "####### Start Promo #######\nCode: $promo_code\nValue: $label\n######## End Promo #######\n\nCustomer Note:\n" . $data->note;
                        $this->hasPromo = true;

                        $this->promoCode = $promo_code;
                        
                    }
                }
            }
        }
        // $data->ref_id = $userService->id;
        // $data->ref='user_service';
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
        $date_path = date('Y/m/d');
        if ($file = $this->uploadImage($request, 'image', null, 'static/files/' . $date_path)) {
            $upload_by = ($user = $request->user()) ? $user->id : 0;
            $this->fileRepository->create(array_merge($file->all(), [
                'upload_by' => $upload_by,
                'sid' => md5(microtime() . uniqid()),
                'original_filename' => $file->filename,
                'date_path' => $date_path,
                'privacy' => 'public',
                'ref' => 'transaction',
                'ref_id' => $result->id
            ]));
        }

        $rs = $this->createWebService($request, $this->userService, $result, null, false);
        if ($rs) {
            $this->redirectRoute = 'client.alert';
            $this->addRedirectData([
                'type' => 'success',
                'message' => 'Chúc mừng bạn đã gửi biên lai thanh toán thành công! Vui lòng chờ giây lát trong khi chúng tôi xác thực giao dịch',
                'link' => route('client.services.list'),
                'text' => 'Quãn lý dịch vụ'
            ]);

            // Forget a single key...
            $request->session()->forget('user_service_id');

            if ($this->setting->send_mail_notification && is_email($this->setting->mail_notification)) {
                $customer = $result->customer;
                MailAlert::send([
                    'subject' => "Thông báo: Có người vừa gửi thông tin thanh toán Dịch vụ",
                    'content' => ($customer ? $customer->name : 'Có người') . " vừa gửi thông tin thanh toán Dịch vụ.\n ID:" . $result->id
                ]);
            }
        } else {
            $this->redirectRoute = 'client.alert';
            $this->addRedirectData([
                'message' => 'Đã có lỗi xảy ra. vui lòng thử lại sau giây lát. ' . implode(', ', $this->errors),
                'link' => route('client.services.list'),
                'text' => 'Quãn lý dịch vụ'
            ]);
        }
        $request->session()->forget('promo_code');
    }





    /**
     * xem trang thanh toan chuyễn khoản
     *
     * @param Request $request
     * @return void
     */
    public function checkout(Request $request)
    {

        $page_title = 'Thanh toán';

        $userService = ($user_service_id = session('user_service_id')) ? $this->userServiceRepository->with(['service', 'package'])->mode('mask')->detail($user_service_id) : null;

        $this->breadcrumb->add($page_title);

        $transaction_type = $request->get('transaction_type', session('transaction_type', 'payment'));
        $promo_code = session('promo_code');

        $final_price = 0;
        $package_price = 0;
        $package = null;
        $promo_label = "Không";
        if ($userService && ($p = $userService->package)) {
            $package = $p;
            $final_price = $p->getFirstPaidAmound();
            $package_price = $final_price;
            if ($promo_code && ($d = $this->servicePromoRepository->checkPromoByPackage($p, $promo_code))) {
                if ($d['status']) {
                    $final_price = $d['price'];
                    $promo_label = $d['label'];
                }
            }
        }
        return $this->viewModule('checkout', compact(
            'page_title',
            'userService',
            'transaction_type',
            'promo_code',
            'promo_label',
            'package_price',
            'final_price',
            'package'

        ));
    }




    public function payment(Request $request)
    {

        $validator = $this->repository->validator($request, ServicePaymentValidator::class);
        if (!$validator->success()) {
            return redirect()->back()->with('error', 'Lỗi bất thường')->withErrors($validator->getErrorObject());
        }
        if ($request->payment_method == 'transfer') {
            return $this->transfer($request);
        } elseif ($request->payment_method == 'atm') {
            return $this->vnPayCreate($request);
        }
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


        $userService = ($user_service_id = session('user_service_id')) ? $this->userServiceRepository->mode('mask')->detail($user_service_id) : null;

        $this->breadcrumb->add($page_title);

        $transaction_type = $request->get('transaction_type', session('transaction_type', 'payment'));
        $promo_code = session('promo_code');

        $final_price = 0;
        $package_price = 0;
        $package = null;
        $promo_label = "Không";
        if ($userService && ($p = $userService->package)) {
            $package = $p;
            $final_price = $p->getFirstPaidAmound();
            $package_price = $final_price;
            if ($promo_code && ($d = $this->servicePromoRepository->checkPromoByPackage($p, $promo_code))) {
                if ($d['status']) {
                    $final_price = $d['price'];
                    $promo_label = $d['label'];
                }
            }
        }

        return $this->viewModule('transfer', compact('page_title', 'userService', 'transaction_type', 'final_price'));
    }

    /**
     * kiễm tra thông tin đơn hàng
     *
     * @param Request $request
     * @return void
     */
    public function checkServicePayment(Request $request)
    {
        if (!$request->user_service_id || !($userService = $this->userServiceRepository->findBy('id', $request->user_service_id))) {
            return redirect()->back()->with(['error' => 'Thông tin dịch vụ không hợp lệ'])->withInput($request->all());
        }
        session(['user_service_id' => $userService->id]);
        if ($request->transaction_type) {
            session(['transaction_type' => $request->transaction_type]);
        }
        return redirect()->route('client.services.checkout');
    }

    /**
     * tạo dịch vụ sau khi đã tiến hành thanh toán
     *
     * @param Request $request
     * @param UserServiceMask $userService
     * @param Transaction $transaction
     * @param string $transaction_code
     * @param boolean $accept
     * @return boolean
     */
    public function createWebService(Request $request, $userService, $transaction = null, $transaction_code = null, $accept = false)
    {
        // kích hoạt tất cả metadata
        $userService->applyMeta();

        $status = false;

        $data = new Arr();
        $total = 0;
        $data->type = 'payment';
        $service = $userService->service;
        $package = $userService->package;

        // nếu có package
        if ($package) {
            // hoa don
            if ($data->transaction_type == 'extension') {
                $data->type = 'extension';
                $total = $package->maintenance_fee;
            } else {
                $total = $package->getFirstPaidAmound();
            }

            $data->user_service_id = $userService->id;
            $data->amount = $total;
            $data->time = date('Y-m-d H:i:s');
            $data->customer_id = $userService->user_id;
            $data->created_id = $userService->user_id;


            $apiData = array_copy($userService->toArray(), [
                'name',
                'email',
                'password',
                'web_type',
                'subdomain',
                'alias_domain',
                'domain',
                'expired_at',
                'status',

            ]);
            if ($accept) {
                $apiData['expired_at'] = $data->transaction_type == 'extension' ? $package->getExtensionExpiredDate() : $package->getExpiredDate();
                $apiData['status'] = 1;

                $admin = $this->userRepository->detail(['type' => 'admin', 'status' => 1]);
                $data->approved_id = $admin ? $admin->id : 0;
            }
            $data->code = $transaction_code;

            // thông tin khơi tạo dịch vụ phía server

            // tạo và thiết lập đối tượng gọi api
            $api = new Api();
            $api->setResponseType('json');
            // tạo dữ liệu cho user
            $apiData['secret_key'] = web_setting()->secret_key;
            $apiData['client_key'] = web_setting()->client_key;


            $apiData['secret'] = bcrypt(env('APP_KEY'). ' - '. time());

            $res = $api->post('http://api.' . $apiData['domain'] . '/admin/accounts/create', $apiData);
            // nếu bịu lỗi

            if (!$res['status']) {
                $status = false;
                $this->errors = $res['errors'];
            } elseif (!$transaction && !($transaction = $this->repository->create($data->all()))) {
                $status = false;
                $this->errors = ['create'];
            } elseif (!($userServiceUpdate = $this->userServiceRepository->update($userService->id, [
                'account_id' => $res['data'] ? $res['data']['id'] : 0,
                'user_id' => $userService->user_id,
                'expired_at' => $apiData['expired_at']
            ]))) {
                $this->errors = ['update'];
                $status = false;
            } elseif ($accept && !$this->repository->updateStatusAndSendEmail($transaction->id, 1)) {
                $status = false;
                $this->errors = ['accept'];
            } else {
                $status = true;
            }
        }
        return $status;
    }

    /**
     * Undocumented function
     *
     * @param Request $request
     * @return void
     */
    public function vnPayCreate(Request $request)
    {
        $userService = ($user_service_id = session('user_service_id')) ? $this->userServiceRepository->with(['package', 'service'])->mode('mask')->detail($user_service_id) : null;
        if (!$userService) return $this->checkout($request);
        $methods = Helper::getPaymentMethodOptions();
        // dd($methods);
        if (!is_countable($methods) || !($vnpay = $methods->atm) || !($config = $vnpay->config) || !isset($config['TmnCode']) || !isset($config['HashSecret'])) abort(404);
        $user = $request->user();
        $package = $userService->package;
        $service = $userService->service;
        $total = $package->getFirstPaidAmound();
        $label = '';
        $promo_code = session('promo_code');
        if ($promo_code && ($d = $this->servicePromoRepository->checkPromoByPackage($package, $promo_code))) {
            if ($d['status']) {
                $total = $d['price'];
                $label = $d['label'];
                // $data->note = "############################# Start Promo #############################\nCode: $promo_code\nValue: $label\n############################## End Promo ##############################\n\nCustomer Note:\n" . $data->note;
            }
        }

        $startTime = date("YmdHis");
        $expire = date('YmdHis', strtotime('+15 minutes', strtotime($startTime)));

        $vnp_Url = "https://sandbox.vnpayment.vn/paymentv2/vpcpay.html";

        $vnp_Returnurl = route('client.services.vnpay-status');
        $transaction_type = $request->get('transaction_type', session('transaction_type', 'payment'));


        $vnp_TmnCode = $config['TmnCode']; //Mã website tại VNPAY
        $vnp_HashSecret = $config['HashSecret']; //Chuỗi bí mật

        $vnp_TxnRef = $user_service_id; // date('YmdHis'); //Mã đơn hàng. Trong thực tế Merchant cần insert đơn hàng vào DB và gửi mã này sang VNPAY
        $vnp_OrderInfo = "Thanh toan dich vu" . ($promo_code?' - promo code: '.$promo_code : '');
        $vnp_OrderType = '130005';
        $vnp_Amount = ($transaction_type == 'extension' ? $package->maintenance_fee : $total) * 100;
        $vnp_Locale = 'vn';
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
            "vnp_ExpireDate" => $vnp_ExpireDate,
            "vnp_Bill_Mobile" => $vnp_Bill_Mobile,
            "vnp_Bill_Email" => $vnp_Bill_Email,
            "vnp_Bill_FirstName" => $vnp_Bill_FirstName,
            "vnp_Bill_LastName" => $vnp_Bill_LastName,
        ]);
        $inputData['vnp_BankCode'] = $request->atm_bank;
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
        $user_service_id = $orderId ?? 0;
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
            else if (!$user_service_id || !($userService = $this->userServiceRepository->with(['package', 'service'])->mode('mask')->detail($user_service_id))) {
                $rspCode = '01';
            }
            // dịch vụ đã dược thanh toán trước đó
            else if ($userService->status != 0) {
                $rspCode = '02';
            }
            // nếu thanh công sẽ kiểm tra khởi tạo dịch vụ
            elseif (!$this->createWebService($request, $userService, null, $vnpTranId, true)) {
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

        $request->session()->forget('promo_code');
        if ($secureHash == $vnp_SecureHash) {
            if ($request->vnp_ResponseCode == '00') {
                return redirect()->route('client.alert')->with([
                    'type' => 'success',
                    'title' => 'Thanh toán thành công!',
                    'message' => 'Chúc mừng bạn đã thanh toán dịch vụ thành công!',
                    'link' => route('client.services.list')
                ]);
            } else {
                return redirect()->route('client.alert')->with([
                    'type' => 'error',
                    'title' => 'Thanh toán không thành công!',
                    'message' => 'Đã xảy ra lỗi trong quá trình thanh toán',
                    'link' => route('client.services.list')
                ]);
            }
        } else {
            return redirect()->route('client.alert')->with([
                'type' => 'error',
                'title' => 'Thanh toán không thành công!',
                'message' => 'Chữ ký không hợp lệ',
                'link' => route('client.services.list')
            ]);
        }
    }
}
