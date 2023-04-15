<?php

namespace App\Http\Controllers\Clients;

use App\Engines\MailAlert;
use App\Http\Controllers\Clients\ClientController;
use App\Repositories\Customers\CustomerRepository;
use App\Repositories\Emails\EmailTokenRepository;
use App\Repositories\Files\FileRepository;
use App\Repositories\Orders\OrderRepository;
use App\Repositories\Products\ProductRepository;
use App\Repositories\Transactions\OrderTransactionRepository;
use App\Repositories\Users\UserRepository;

use Illuminate\Http\Request;
use Crazy\Helpers\Arr;

class PaymentController extends ClientController
{
    protected $module = 'payments';

    protected $moduleName = 'Thanh toán';

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
     * orderRepository
     *
     * @var \App\Repositories\Orders\OrderRepository
     */
    protected $orderRepository = null;

    /**
     * email token
     *
     * @var \App\Repositories\Emails\EmailTokenRepository
     */
    protected $emailTokenRepository = null;


    /**
     * file
     *
     * @var \App\Repositories\Files\FileRepository
     */
    protected $fileRepository = null;


    /**
     * email token
     *
     * @var \App\Repositories\Transactions\OrderTransactionRepository
     */
    public $repository = null;


    /**
     * order
     *
     * @var \App\Models\Order
     */
    protected $order = null;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(
        OrderTransactionRepository $orderTransactionRepository,
        OrderRepository $orderRepository,
        ProductRepository $productRepository,
        UserRepository $userRepository,
        CustomerRepository $customerRepository,
        EmailTokenRepository $emailTokenRepository,
        FileRepository $fileRepository
    ) {
        $this->repository = $orderTransactionRepository;
        $this->orderRepository = $orderRepository;
        $this->productRepository = $productRepository->addDefaultCondition('deleted', 'deleted', 0);
        $this->customerRepository = $customerRepository;
        $this->userRepository = $userRepository->addDefaultCondition('deleted', 'deleted', 0);
        $this->emailTokenRepository = $emailTokenRepository;
        $this->repository->setValidatorClass('Transactions\TransferPaymentValidator');
        $this->fileRepository = $fileRepository;
        $this->setting = setting();
        $this->siteinfo = siteinfo();
        $this->init();
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
        $order = ($order_id = session('order_id'))? $this->orderRepository->mode('mask')->withFullData()->detail($order_id) : null;
        $this->breadcrumb->add($page_title);
        return $this->viewModule('transfer', compact('page_title', 'order'));
    }

    /**
     * kiễm tra thông tin đơn hàng
     *
     * @param Request $request
     * @return void
     */
    public function checkOrderTransfer(Request $request)
    {
        if (!$request->contact || !$request->order_id || !($order = $this->orderRepository->checkOrderByContact($request->contact, $request->order_id))) {
            return redirect()->back()->with(['error' => 'Thông tin đơn hàng không hợp lệ'])->withInput($request->all());
        }
        session(['order_id' => $order->id]);
        return redirect()->route('client.payments.transfer');
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
        $order = $this->orderRepository->detail($request->order_id);
        $data->amount = $order->total_money;
        $data->time = date('Y-m-d H:i:s');
        $data->customer_id = $order->customer_id;
        $data->type = 'payment';
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
        $this->redirectRoute = 'client.alert';
        $this->addRedirectData([
            'type' => 'success',
            'message' => 'Chúc mừng bạn đã gửi biên lai thanh toán thành công! Vui lòng chờ giây lát trong khi chúng tôi xác thực giao dịch',
            'link' => route('client.orders.manager'),
            'text' => 'Quãn lý đơn hàng'
        ]);
        // Forget a single key...
        $request->session()->forget('order_id');
        
        if($this->setting->send_mail_notification && is_email($this->setting->mail_notification)){
            $customer = $result->customer;
            MailAlert::send([
                'subject' => "Thông báo: Có người vừa gửi thông tin thanh toán đơn hàng", 
                'content' => ($customer?$customer->name:'Có người')." vừa gửi thông tin thanh toán đơn hàng.\n ID:".$result->id
            ]);
        }
    }
}
