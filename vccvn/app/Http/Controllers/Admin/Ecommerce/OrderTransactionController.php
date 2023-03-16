<?php

namespace App\Http\Controllers\Admin\Ecommerce;

use Illuminate\Http\Request;
use App\Http\Controllers\Admin\AdminController;
use Crazy\Helpers\Arr;
use App\Repositories\Transactions\OrderTransactionRepository;
use App\Repositories\Files\FileRepository;
use App\Repositories\Orders\OrderRepository;
use App\Repositories\Customers\CustomerRepository;

class OrderTransactionController extends AdminController
{
    protected $module = 'transactions.orders';

    protected $moduleName = 'Giao dịch';

    protected $flashMode = true;

    protected $statusValues = [
        'approve' => 1,
        'unapprove' => 0,
        'decline' => -1,
        'restore' => 0
    ];

    /**
     * @var FileRepository $fileRepository
     * Quản lý file upload
     */
    protected $fileRepository;

    /**
     * order transaction
     *
     * @var OrderTransactionRepository $repository
     */
    public $repository = null;

    /**
     * Create a new controller instance.
     *
     * @param OrderTransactionRepository $orderTransactionRepository
     * @param OrderRepository $orderRepository
     * @param FileRepository $fileRepository
     * @param CustomerRepository $customerRepository
     *
     * @return void
     */
    public function __construct(OrderTransactionRepository $orderTransactionRepository, OrderRepository $orderRepository, FileRepository $fileRepository, CustomerRepository $customerRepository)
    {
        $this->repository = $orderTransactionRepository;
        $this->fileRepository = $fileRepository;
        $this->orderRepository = $orderRepository;
        $this->customerRepository = $customerRepository;
        $this->init();
        $this->activeMenu('transactions');
    }

    /**
     * on start
     *
     * @return void
     */
    public function start()
    {
        add_js_data('transaction_order',[
            'urls' => [
                'get_order_options' => route($this->routeNamePrefix.'orders.select-options'),
                'get_detail' => $this->getModuleRoute('resource-detail'),
                'approve' => $this->getModuleRoute('status', ['slug' => 'approve']),
                'unapprove' => $this->getModuleRoute('status', ['slug' => 'unapprove']),
                'decline' => $this->getModuleRoute('status', ['slug' => 'decline']),
                'restore' => $this->getModuleRoute('status', ['slug' => 'restore']),
                'delete' => $this->getModuleRoute('move-to-trash')
            ]
        ]);
        add_js_src('static/manager/js/transaction.order.js');
    }


    /**
     * xử lý data trước khi lưu
     *
     * @param Request $request
     * @param Arr $data
     * @return void
     */
    public function beforeSave(Request $request, Arr $data)
    {
        if(!$request->time){
            $data->time = date('Y-m-d H:i:s');
        }
    }

    /**
     * lưu biên lai sau khi lưu giao dịch
     *
     * @param Request $request
     * @param \App\Models\Transaction $transaction
     * @param Arr $data
     * @return void
     */
    public function afterSave(Request $request, $transaction, Arr $data)
    {
        if($request->id == $transaction->id){
            $this->fileRepository->deleteRefFileIgnoreList('transaction', $transaction->id, is_array($request->bills_ids)?$request->bills_ids:[]);
        }
        if($request->bills_data){
            $this->fileRepository->saveBase64List($data->bills_data, 'transaction', $transaction->id, $request->user()->id);
        }
    }

    /**
     * thay doi trang thnai giao dich
     *
     * @param Request $request
     * @param string $statusSlug
     * @return JSON
     */
    public function changeStatus(Request $request, $statusSlug)
    {
        extract($this->apiDefaultData);
        $sttKeys = array_flip($this->statusValues);
        $stt = array_key_exists($statusSlug, $sttKeys) ? ((int) $statusSlug) : (
            array_key_exists($k = strtolower($statusSlug), $this->statusValues) ? $this->statusValues[$k] : null
        );
        if(!is_null($stt) && $detail = $this->repository->updateStatusAndSendEmail($request->id, $stt)){

            $data = $detail;
            $status = true;
        }
        return $this->json(compact(...$this->apiSystemVars));
    }

    public function beforeGetResourceDetail($request)
    {
        $this->repository->mode('mask');
    }



    /**
     * thay đổi trạng thái đơn hàng
     * @param Request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getTransactionDetail(Request $request)
    {
        extract($this->apiDefaultData);
        if($request->id && $detail = $this->repository->mode('mask')->detail($request->id)){
            $data = $detail;
            $status = true;
        }else{
            $message = "Không tìm thấy mục yêu càu";

        }
        return $this->json(compact(...$this->apiSystemVars));
    }

}
