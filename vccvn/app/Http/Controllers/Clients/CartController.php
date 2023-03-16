<?php

namespace App\Http\Controllers\Clients;

use App\Http\Controllers\Clients\ClientController;
use App\Repositories\Customers\CustomerRepository;
use App\Repositories\Emails\EmailTokenRepository;
use App\Repositories\Orders\CartRepository;
use App\Repositories\Orders\OrderAddressRepository;
use App\Repositories\Orders\OrderRepository;
use App\Repositories\Payments\MethodRepository;
use App\Repositories\Products\ProductRepository;
use App\Repositories\Users\UserRepository;
use Illuminate\Http\Request;
use Crazy\Helpers\Arr;
use Crazy\Mailer\Email;


class CartController extends ClientController
{
    protected $module = 'orders';

    protected $moduleName = 'Giỏ hàng';

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
     * quản lý địa chỉ của order
     *
     * @var \App\Repositories\Orders\OrderAddressRepository
     */
    protected $orderAddressRepository = null;

    /**
     * Cart Repository
     *
     * @var CartRepository
     */
    public $repository = null;

    /**
     * payment method
     *
     * @var MethodRepository
     */
    public $paymentMethodRepository = null;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(
        CartRepository $CartRepository,
        ProductRepository $productRepository,
        UserRepository $userRepository,
        CustomerRepository $customerRepository,
        EmailTokenRepository $emailTokenRepository,
        OrderAddressRepository $orderAddressRepository,
        MethodRepository $paymentMethodRepository
    ) {
        $this->repository = $CartRepository;
        $this->productRepository = $productRepository->notTrashed();
        $this->customerRepository = $customerRepository;
        $this->userRepository = $userRepository->notTrashed();
        $this->emailTokenRepository = $emailTokenRepository;
        $this->orderAddressRepository = $orderAddressRepository;
        $this->paymentMethodRepository = $paymentMethodRepository->addDefaultCondition('status', 'status', 1)->notTrashed();
        $this->setting = setting();
        $this->siteinfo = siteinfo();
        $this->init();
    }

    /**
     * xem giỏ hàng
     *
     * @param Request $request
     * @return View
     */
    public function viewCart(Request $request)
    {
        $cart = $this->repository->getCartWidthDetails();
        $page_title = "Giỏ hàng";
        $this->breadcrumb->add($page_title);
        return $this->viewModule('cart', compact('cart', "page_title"));
    }

    /**
     * xem trang thanh toán
     *
     * @param Request $request
     * @return View
     */
    public function checkout(Request $request)
    {
        $cart = $this->repository->getCartWidthDetails();
        $page_title = "Đặt hàng và thanh toán";
        $customer = $this->customerRepository->getCurrentCustomerOrUser($request);
        $this->breadcrumb->add($page_title);
        set_web_data('__cart__form__config', $this->getJsonInputs('orders.checkout'));
        set_web_data('__cart__form__data', $customer ? $customer->toArray() : []);
        return $this->viewModule('checkout', compact('cart', "page_title", 'customer'));
    }


    /**
     * đặt hàng
     *
     * @param Request $request
     * @return Redirect
     */
    public function placeOrder(Request $request)
    {

        // kiểm tra cart
        $cart = $this->repository->getCartWidthDetails();
        if (!$cart || count($cart->details) == 0) return redirect()->back()->withInput();
        // validate
        $validator = $this->repository->validator($request, 'Orders\PlaceValidator');
        if (!$validator->success() || !($payment = $this->paymentMethodRepository->detail(['method' => $request->payment_method]))) {
            return redirect()->back()->withErrors($validator->errors())->withInput($request->all())->with('warning_message', 'Một vài thông tin đặt hàng có vẻ không hợp lệ');
        }
        // xóa điều kiện where cart
        $this->repository->removeDefaultConditions();
        // lấy data
        $data = new Arr($validator->inputs());
        // hóa đơn
        $billingData = $data->prefix('billing_', true, null, true);
        // thông tin giao hàng
        $shippingData = $data->ship_to_different_address ? $data->prefix('shipping_', true, null, true) : $billingData;

        $billing = new Arr($billingData);
        $shipping = new Arr($shippingData);

        $data->type = 'order';
        $data->status = 0;
        $data->ordered_at = date('Y-m-d H:i:s');
        $data->payment_method_id = $payment->id;
        $user = $request->user();
        $orderConfirm = false;
        $customerFields = ['name', 'email', 'phone_number', 'address'];
        $confirmName = null;
        $confirmEmail = null;
        // lấy khách hàng hiện tại
        $customer = $this->customerRepository->getCurrentCustomer();
        $createCustomer = false;
        $userConfirm = false;
        $customerData = $billingData;
        $confirmShipping = $data->ship_to_different_address && ($billing->email != $shipping->email || $billing->phone_number != $shipping->phone_number);
        $confirmODR = ecommerce_setting()->confirm_order;
        if (!$user) {
            if ($payment->method == "cod") {
                $orderConfirm = $confirmODR;

                $confirmName = $confirmShipping ? $shipping->name : $billing->name;
                $confirmEmail = $confirmShipping ? $shipping->email : $billing->email;
            }
            // $createCustomer = true;
            // nếu có yêu cầu tạo tài khoản
            if ($data->create_account && !$this->userRepository->countBy('email', $billing->email)) {
                $userData = $billingData;
                $userData['username'] = $this->userRepository->getUsernameByEmail($billing->email);
                $userData['password'] = $data->password;
                $user = $this->userRepository->create($userData);
                $userConfirm = true;
            }
            $customer = $this->customerRepository->createDataIfNotExists($customerData);
        } else {
            // nếu đã có tài khoản khách hàng thì nên liên kết
            $data->user_id = $user->id;
            if ($userCustomer = $this->customerRepository->findBy('user_id', $user->id)) {
                $customer = $userCustomer;
            }
            // nếu (không) có một tài khoản khách hàng trùng vs email người dùng
            elseif (!($cus = $this->customerRepository->findBy('email', $user->email))) {
                $customerData['user_id'] = $user->id;
                $customerData['email'] = $user->email;
                $customerData['name'] = $user->name;

                $customer = $this->customerRepository->createDataIfNotExists($customerData);
            }
            // nếu có và chưa có user id
            elseif (!$cus->user_id) {
                $customer = $this->customerRepository->update($cus->id, ['user_id' => $user->id]);
            }

            if (!$orderConfirm && $payment->method == "cod" && $confirmShipping && $confirmODR) {
                $orderConfirm = true;
                $confirmName = $shipping->name;
                $confirmEmail = $shipping->email;
            }
        }


        if ($customer) $data->customer_id = $customer->id;

        // nếu ko phải xác thực đơn hàng thì sẽ chuyển trạng thái đơn hàng tùy thuộc phương thúc thanh toán
        if (!$orderConfirm && $payment->method != 'cod') {
            $data->status = OrderRepository::PENDING_PAYMENT;
        }

        // lưu thông tin hóa đơn và thông tin giao hàng
        $billing = $this->orderAddressRepository->updateAddress($cart->id, 'billing', $billingData);
        $shipping = $this->orderAddressRepository->updateAddress($cart->id, 'shipping', $shippingData);
        // dd($this->repository->getCartDetail($cart->id));
        // chuyển giỏ hàng thành đơn hàng
        $order = $this->repository->getCartDetail(
            $this->repository->update($cart->id, $data->all())->id
        );




        $mailFrom = $this->siteinfo->email('no-reply@' . get_non_www_domain());
        $company = $this->siteinfo->company($this->siteinfo->site_name('Crazy Support'));

        // // chỉ gửi yêu cầu xác thực khi sử dụng phương thức thanh toán khi nhận hàng
        if ($orderConfirm) {
            // tạo token
            $emailToken = $this->emailTokenRepository->createToken($confirmEmail, 'confirm', 'order', $order->id);
            $data = [
                'url' => route('client.orders.confirm', [
                    'token' => $emailToken->token
                ]),
                'code' => $emailToken->code,
                'email' => $confirmEmail,
                'name' => $confirmName,
                'order' => $order
            ];


            Email::from($mailFrom, $company)
                ->to($confirmEmail, $confirmName)
                ->replyTo($mailFrom, $company)
                ->subject("Xác thực đơn hàng")
                ->body('mails.order-confirm')
                ->data($data)
                ->send();
            // ->sendAfter(1);

        }
        // nếu không phải gửi email xác thực và phương thức thanh toán là thanh toán khi giao hàng
        elseif ($payment->method == 'cod') {
            Email::from($mailFrom, $company)
                ->to($billing->email, $billing->name)
                ->replyTo($mailFrom, $company)
                ->subject("Thông báo: Đặt hàng thành công")
                ->body('mails.order-place-success')
                ->data([
                    'order' => $order,
                    'name' => $billing->name,
                    'email' => $billing->email,
                    'phone_number' => $billing->phone_number
                ])
                ->sendAfter(1);

            if ($this->setting->send_mail_notification) {
                $maillist = array_filter(explode(',', is_email($this->setting->mail_notification)), function ($e) {
                    return is_email($e);
                });
                if ($maillist) {
                    Email::from($mailFrom, $company)
                        ->to($maillist)
                        ->replyTo($mailFrom, $company)
                        ->subject("Thông báo: Có người đặt hàng")
                        ->body('mails.simple-alert')
                        ->data(['content' => $billing->name . " vừa đặt hàng trên trang của bạn.\n Mã đơn hàng:" . $order->id])
                        ->sendAfter(1);
                }
            }
        } elseif ($payment->method == 'transfer') {
            // gửi mail hướng dan thanh toan
            Email::from($mailFrom, $company)
                ->to($billing->email, $billing->name)
                ->replyTo($mailFrom, $company)
                ->subject("Hướng dẫn thanh toán đơn hàng")
                ->body('mails.order-transfer-payment-guide')
                ->data([
                    'order' => $order,
                    'name' => $billing->name,
                    'email' => $billing->email,
                    'phone_number' => $billing->phone_number
                ])
                ->sendAfter(1);
        }

        // xác thực người dùng
        if ($user && $userConfirm) {
            $emailToken = $this->emailTokenRepository->createToken($user->email, 'verify', 'user', $user->id);
            $data = [
                'url' => route('client.account.verify-email', [
                    'token' => $emailToken->token
                ]),
                'code' => $emailToken->code,
                'email' => $user->email,
                'user' => $user
            ];

            Email::from($mailFrom, $company)
                ->to($user->email, $user->name)
                ->replyTo($mailFrom, $company)
                ->subject("Xác minh email")
                ->body('mails.verify-email')
                ->data($data)
                ->sendAfter(1);
        }

        $alert = [];



        if ($orderConfirm) {
            $alert = [
                'type' => 'success',
                'message' => 'Bạn đã đặt hàng thành công! tuy nhiên chúng tôi cần xác minh thông tin của bạn. Vui lòng kiểm tra hộp thư đến để xác minh và hoàn tất quá trình dặt hàng'
            ];
        } elseif ($payment->method == 'cod') {
            $alert = [
                'type' => 'success',
                'message' => 'Chúc mừng bạn đã đặt hàng thành công! Bạn có thể kiểm tra đơn hàng theo dường dẫn bên dưới',
                'link' => route('client.orders.manager'),
                'text' => 'Quản lý đơn hàng'
            ];
        } else {

            if ($payment->method == 'vnpay') {
                $session = [
                    'vnpay_bank' => $data->vnpay_bank
                ];
            } else {
                $session = [];
            }
            $session['order_id'] = $order->id;
            session($session);
            return redirect()->route('client.payments.' . $payment->method)->with($session);
        }

        return redirect()->route('client.alert')->with($alert)->withCookie(cookie('cart_id', null, -1));
    }


    /**
     * kiểm tra giá sản phẩm theo thuộc tính nếu có
     *
     * @param Request $request
     * @return void
     */
    public function checkPrice(Request $request)
    {
        // return $request->all();
        extract($this->apiDefaultData);
        if ($productData = $this->productRepository->checkPrice($request->product_id, is_array($request->attrs) ? $request->attrs : [])) {
            $status = true;
            $price = $productData['price'];
            $data = [
                'product' => $productData['product'],
                'price' => $price,
                'price_format' => get_currency_format($price)
            ];
        }

        return $this->json(compact($this->apiSystemVars));
    }

    /**
     * tinhn1 năng này sẻ làm sau
     *
     * @param Request $request
     * @return void
     */
    public function addToCart(Request $request)
    {
        return redirect()->back()->withInput($request->all());
    }

    /**
     * thêm giỏ hàng bằng ajax
     * @param Request $request
     */
    public function addItem(Request $request)
    {
        extract($this->apiDefaultData);
        if ($cart = $this->repository->addItem($request->product_id, $request->quantity, $request->attrs ?? [])) {
            $status = true;
            $data = $cart;
            return $this->json(compact($this->apiSystemVars))->withCookie(cookie('cart_id', $cart->id, 365 * 24 * 60));
        }

        $message = 'Lỗi không xác định';
        return $this->json(compact($this->apiSystemVars));
    }

    /**
     * thêm giỏ hàng bằng ajax
     * @param Request $request
     */
    public function applyCoupon(Request $request)
    {
        extract($this->apiDefaultData);
        if ($cart = $this->repository->applyCoupon($request)) {
            $status = true;
            $data = $cart;
            return $this->json(compact($this->apiSystemVars))->withCookie(cookie('cart_id', $cart->id, 365 * 24 * 60));
        }

        $message = $this->repository->actionMessage;
        return $this->json(compact($this->apiSystemVars));
    }
    /**
     * xóa item trong giỏ hàng
     *
     * @param Request $request
     */
    public function removeItem(Request $request)
    {
        extract($this->apiDefaultData);
        if ($cart = $this->repository->removeItem($request->id)) {
            $status = true;
            $data = $cart;
            return $this->json(compact($this->apiSystemVars))->withCookie(cookie('cart_id', $cart->id, 365 * 24 * 60));
        }
        $message = 'Lỗi không xác định';
        return $this->json(compact($this->apiSystemVars));
    }
    /**
     * thêm giỏ hàng bằng ajax
     * @param Request $request
     */
    public function checkData(Request $request)
    {
        extract($this->apiDefaultData);
        if ($cart = $this->repository->getCartWidthDetails()) {
            $status = true;
            $data = $cart;
        } else {
            $message = 'Không có gì trong giỏ';
        }

        return $this->json(compact($this->apiSystemVars));
    }


    /**
     * làm trống giỏ hàng
     *
     * @param Request $request
     */
    public function empty(Request $request)
    {
        extract($this->apiDefaultData);
        $status = true;
        if ($cart = $this->repository->empty()) {
            $data = $cart;
            return $this->json(compact($this->apiSystemVars))->withCookie(cookie('cart_id', $cart->id, 365 * 24 * 60));
        } else {
            $data = null;
            $message = 'Lỗi không xác định';
            return $this->json(compact($this->apiSystemVars));
        }
    }


    /**
     * cap nhat quan tity
     *
     * @param Request $request
     */
    public function updateCartQuantity(Request $request)
    {
        extract($this->apiDefaultData);

        if ($request->quantity && $cart = $this->repository->updateCartQuantity($request->quantity)) {
            $status = true;

            $data = $cart;
            return $this->json(compact($this->apiSystemVars))->withCookie(cookie('cart_id', $cart->id, 365 * 24 * 60));
        } else {
            $data = null;
            $message = 'Lỗi không xác định';
            return $this->json(compact($this->apiSystemVars));
        }
    }
}
