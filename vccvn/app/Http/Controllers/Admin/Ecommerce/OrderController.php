<?php

namespace App\Http\Controllers\Admin\Ecommerce;

use Illuminate\Http\Request;
use App\Http\Controllers\Admin\AdminController;
use Crazy\Helpers\Arr;

use App\Repositories\Orders\OrderRepository;
use App\Repositories\Products\ProductRepository;
use App\Repositories\Orders\OrderItemRepository;
use App\Repositories\Customers\CustomerRepository;

use App\Repositories\Orders\OrderAddressRepository;

class OrderController extends AdminController
{
    protected $module = 'orders';

    protected $moduleName = 'Đơn hàng';

    protected $flashMode = true;


    protected $statusList = [
        "0" => "pending-verify", 
        "100" => "verified", 
        "200" => "pending-payment", 
        "300" => "paid", 
        "400" => "pending", 
        "500" => "processing", 
        "1000"=> "completed", 
        "-1" => "canceled"
    ];
    
    /**
     * @var array $items 
     */
    public $items = [];

    
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
        OrderItemRepository $orderItemRepository, 
        ProductRepository $productRepository, 
        CustomerRepository $customerRepository,
        OrderAddressRepository $orderAddressRepository)
    {
        $this->repository = $orderRepository;
        $this->productRepository = $productRepository;
        $this->orderItemRepository = $orderItemRepository;
        $this->customerRepository = $customerRepository;
        $this->orderAddressRepository = $orderAddressRepository;
        $this->init();
    }

    /**
     * khơi chạy controller
     */
    public function start()
    {
        /* them data cho js xư ly */
        add_js_data('order_data', [
            'urls' => [
                'change_status' => $this->getModuleRoute('change-status'),
                'get_detail' => $this->getModuleRoute('resource-detail'),
                'region_options' => route("client.location.regions.options"),
                'district_options' => route("client.location.districts.options"),
                'ward_options' => route("client.location.wards.options"),
            ]
        ]);
    }


    
    /**
     * can thiệp xử lý trước khi lưu
     * @param Illuminate\Http\Request $request
     * @param App\Models\Order $Order
     * @param Crazy\Helpers\Arr $data
     * 
     * @return void
     */
    public function beforeSave(Request $request, Arr $data)
    {
        $orderDetail = $this->orderItemRepository->parseItems(is_array($data->items)?$data->items:[]);
        $this->items = $orderDetail['items'];
        $data->total_money = $orderDetail['total_money'];
        if(!$data->customer_id){
            $customer = $this->customerRepository->createDataIfNotExists($data->prefix('billing_',null,null,true));
            $data->customer_id = $customer->id;
        }
        
    }


    /**
     * lưu các dữ liệu liên quan
     * @param Illuminate\Http\Request $request
     * @param App\Models\Order $order
     * @param Crazy\Helpers\Arr $data
     * 
     * @return void
     */
    public function afterSave(Request $request, $order, Arr $data)
    {
        $this->orderItemRepository->saveOrderItems($order->id, $this->items);
        // dd($this->items);
        // lưu thông tin hóa đơn và thông tin giao hàng
        $this->orderAddressRepository->updateAddress($order->id, 'billing', $data->prefix('billing_',null,null,true));
        $this->orderAddressRepository->updateAddress($order->id, 'shipping', $data->prefix('shipping_',null,null,true));
    }


    /**
     * lấy thông tin sản phẩm và thuộc tính
     * @param Request $request
     * 
     * @return json
     */
    public function getProductInput(Request $request)
    {
        extract($this->apiDefaultData);
        if($itemData = $this->productRepository->getOrderInputData($request->product_id)){
            $status = true;
            $data = $this->view(
                'forms.templates.order-item', 
                array_merge($itemData, [
                    'name' => $request->name,
                    'index' => $request->index,
                    'quantity' => 1
                ])
            )->render();
        }
        
        return $this->json(compact(...$this->apiSystemVars));
    }


    /**
     * lấy danh sach đơn hàng theo trạng thái
     * @param Request $request
     * @return view
     */
    public function getListByStatus(Request $request)
    {
        if($stt = get_array_element($request->list, $this->statusList)){
            $this->activeMenu('list-', $stt['value']);
            return $this->getFlashModeListData($request, ['status' => $stt['key']], ['list_group' => $stt['value']]);
        }else{
            return $this->getList($request);
        }
    }

    /**
     * thay đổi trạng thái đơn hàng
     * @param Request
     * @return json
     */
    public function changeStatus(Request $request)
    {
        extract($this->apiDefaultData);
        if($request->id && array_key_exists($request->status, $this->statusList) && $this->repository->find($request->id)){
            $updateData = ['status' => $request->status];
            if($request->status == 500) $updateData['completed_at'] = date('Y-m-d H:i:s');
            if($updated = $this->repository->update($request->id, $updateData)){
                $status = true;
                $message = 'Cập nhật trạng thái đơn hàng thành công!';
                $data = $updated;
                $this->repository->sendMailAlertOrderStatus($updated->id);
            }
        }
        return $this->json(compact(...$this->apiSystemVars));
    }

    /**
     * thay đổi trạng thái đơn hàng
     * @param Request
     * @return json
     */
    public function getOrderDetail(Request $request)
    {
        extract($this->apiDefaultData);
        if($request->id && $detail = $this->repository->mode('mask')->withFullData()->detail($request->id)){
            $data = $detail;
            $status = true;
        }
        return $this->json(compact(...$this->apiSystemVars));
    }


    /**
     * tim kiếm thông 
     * @param Request $request
     * @return json
     */
    public function getSelectOptions(Request $request)
    {
        extract($this->apiDefaultData);

        if($options = $this->repository->getSelectOptions($request, ['@limit'=>10])){
            $data = $options;
            $status = true;
        }else{
            $message = 'Không có kết quả phù hợp';
        }

        return $this->json(compact(...$this->apiSystemVars));
    }
    
}
