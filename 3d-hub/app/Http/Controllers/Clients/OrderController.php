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

class OrderController extends ClientController
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
    )
    {
        $this->repository = $orderRepository;
        $this->customerRepository = $customerRepository;
        $this->userRepository = $userRepository->addDefaultCondition('deleted', 'deleted', 0);
        $this->emailTokenRepository = $emailTokenRepository;
        $this->orderAddressRepository = $orderAddressRepository;
        $this->init();
    }

    public function viewDetail(Request $request)
    {
        $user = $request->user();
        $customer = $this->customerRepository->getCurrentCustomer();
        // nếu không có thông tin người dùng và thông tin khách hàng hiện tại thì diều hướng đến trang đăng nhập khách hàng
        if(!$customer && $user){
            $customer = $this->customerRepository->findBy('user_id', $user->id);
        }
        if(!$user && !$customer){
            return redirect()->route('client.orders.customer.login');
        }

        $order = $this->repository->getCustomerOrderDetail($customer?$customer->id:0, $user?$user->id:0, ['id' => $request->id]);
        $page_title = 'Chi tiết đơn hàng';
        $this->breadcrumb->add($page_title);
        return $this->viewModule('detail', compact('order', 'page_title'));

        
    }

    /**
     * xem trang quản lý đơn hàng
     *
     * @param Request $request
     * @return View
     */
    public function manager(Request $request)
    {
        $user = $request->user();
        $customer = $this->customerRepository->getCurrentCustomer();
        // nếu không có thông tin người dùng và thông tin khách hàng hiện tại thì diều hướng đến trang đăng nhập khách hàng
        if(!$customer && $user){
            $customer = $this->customerRepository->findBy('user_id', $user->id);
        }
        if(!$user && !$customer){
            return redirect()->route('client.customers.login');
        }


        // lấy danh sách các tang thai cua don hang
        $statusList = get_order_status_list();
        
        $keys = get_order_status_keys();
        $key = strtolower($request->status_key);
        $allows = get_customer_access_alow_status_list();
        $args = [];
        $list_title = "Tất cả đơn hàng";
        if($key){
            if(array_key_exists($key, $keys)){
                $key = $keys[$key];
            }elseif (!in_array($key, $keys)) {
                return $this->view('errors.404');
            }
            if(!in_array($key, $allows) || !($status = $statusList[$key]??null)){
                return $this->view('errors.404');
            }
            $args['status'] = $status['code'];
            $list_title = $status['label'];
        }
        

        $orders = $this->repository->paginate(10)->getCustomerOrders(
            $customer?$customer->id:0, 
            $user?$user->id:0, 
            $args
        );
        
        $page_title = 'Quản lý đơn hàng';
        $this->breadcrumb->add($page_title);
        $data = [
            'key' => $key,
            'status_list' => $statusList->copy($allows),
            'orders' => $orders,
            'payment_methods' => get_order_payment_methods(),
            'status_keys' => array_flip($keys),
            'page_title' => $page_title,
            'list_title' => $list_title
        ];
        
        return $this->viewModule('list', $data);
    }

    /**
     * hủy đơn hàng
     *
     * @param Request $request
     * @return json
     */
    public function cancel(Request $request)
    {
        extract($this->apiDefaultData);
        
        if(!$request->id || !($order = $this->repository->detail($request->id))){
            $message = "Đơn hàng không hợp lệ hoặc không được tìm thấy!";
        }elseif (!$order->canCancel() || !($cancelOrder = $this->repository->cancel($order->id))) {
            $message = "Đơn hàng này đang được vận chuyển nên không thể hủy được nữa!";
        }
        else{
            $data = $cancelOrder;
            $status = true;
            MailAlert::send([
                'subject' => "Thông báo: Có người hủy đặt hàng", 
                'content' => $order->billing->name." vừa hủy đơn hàng.\n Mã đơn hàng:".$order->id
            ]);
        }

        return $this->json(compact($this->apiSystemVars));
    }

    /**
     * Xác thực đơn hàng
     *
     * @param Request $request
     * @param string $token
     * @return void
     */
    public function confirmOrder(Request $request, $token = null)
    {
        if (!$token) $token = $request->token;
        if (!($emailToken = $this->emailTokenRepository->checkRoken($token, 'confirm')) || $emailToken->ref !='order' || !$emailToken->ref_id || !($order = $this->repository->verify($emailToken->ref_id))) {
            return redirect()->route('client.alert')->with([
                'type' => 'warning',
                'message' => 'Token không hợp lệ'
            ]);
        }
        
        MailAlert::send([
            'subject' => "Thông báo: Có người đặt hàng", 
            'content' => $order->billing->name." vừa đặt hàng trên trang của bạn.\n Mã đơn hàng:".$order->id
        ]);
        session(['customer_id' => $order->customer_id]);
        return redirect()->route('client.orders.manager');
        // 
    }

}
