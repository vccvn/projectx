<?php

namespace App\Http\Controllers\Clients;

use App\Engines\MailAlert;
use App\Http\Controllers\Clients\ClientController;
use App\Repositories\Customers\CustomerRepository;
use App\Repositories\Emails\EmailTokenRepository;
use App\Repositories\Orders\OrderAddressRepository;
use App\Repositories\Orders\OrderRepository;
use App\Repositories\Users\UserRepository;

use Illuminate\Http\Request;
use Crazy\Helpers\Arr;
use Crazy\Mailer\Email;

class VnPayController extends ClientController
{
    protected $module = 'orders';

    protected $moduleName = 'Order';

    protected $flashMode = true;

    /**
     * customer
     *
     * @var \App\Repositories\Customers\CustomerRepository $customerRepository
     */
    protected $customerRepository = null;
    /**
     * customer
     *
     * @var \App\Repositories\Users\UserRepository $userRepository
     */
    protected $userRepository = null;

    /**
     * email token
     *
     * @var \App\Repositories\Emails\EmailTokenRepository
     */
    protected $emailTokenRepository = null;

    /**
     * order repository
     *
     * @var \App\Repositories\Orders\OrderRepository
     */
    public $repository = null;

    /**
     * quản lý địa chỉ của order
     *
     * @var \App\Repositories\Orders\OrderAddressRepository
     */
    protected $orderAddressRepository = null;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(
        OrderRepository $orderRepository,
        UserRepository $userRepository,
        CustomerRepository $customerRepository,
        EmailTokenRepository $emailTokenRepository,
        OrderAddressRepository $orderAddressRepository
    ) {
        $this->repository = $orderRepository;
        $this->customerRepository = $customerRepository;
        $this->userRepository = $userRepository->notTrashed();
        $this->emailTokenRepository = $emailTokenRepository;
        $this->orderAddressRepository = $orderAddressRepository;
        $this->init();
    }

    public function VnPayCreate(Request $request)
    {
        session(['cost_id' => $request->id]);
        session(['url_prev' => url()->previous()]);
        $vnp_TmnCode = "UDOPNWS1"; //Mã website tại VNPAY 
        $vnp_HashSecret = "EBAHADUGCOEWYXCMYZRMTMLSHGKNRPBN"; //Chuỗi bí mật
        $vnp_Url = "http://sandbox.vnpayment.vn/paymentv2/vpcpay.html";
        $vnp_Returnurl = "http://localhost:8000/return-vnpay";
        $vnp_TxnRef = date("YmdHis"); //Mã đơn hàng. Trong thực tế Merchant cần insert đơn hàng vào DB và gửi mã này sang VNPAY
        $vnp_OrderInfo = "Thanh toán hóa đơn phí dich vụ";
        $vnp_OrderType = 'billpayment';
        $vnp_Amount = $request->input('amount') * 100;
        $vnp_Locale = 'vn';
        $vnp_IpAddr = request()->ip();

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

        if (isset($vnp_BankCode) && $vnp_BankCode != "") {
            $inputData['vnp_BankCode'] = $vnp_BankCode;
        }
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
            // $vnpSecureHash = md5($vnp_HashSecret . $hashdata);
            $vnpSecureHash = hash('sha256', $vnp_HashSecret . $hashdata);
            $vnp_Url .= 'vnp_SecureHashType=SHA256&vnp_SecureHash=' . $vnpSecureHash;
        }
        return redirect($vnp_Url);
    }

    public function VnPayReturn(Request $request)
    {
        $url = session('url_prev', '/');
        if ($request->vnp_ResponseCode == "00") {
            $this->apSer->thanhtoanonline(session('cost_id'));
            return redirect($url)->with('success', 'Đã thanh toán phí dịch vụ');
        }
        session()->forget('url_prev');
        return redirect($url)->with('errors', 'Lỗi trong quá trình thanh toán phí dịch vụ');
    }
}
