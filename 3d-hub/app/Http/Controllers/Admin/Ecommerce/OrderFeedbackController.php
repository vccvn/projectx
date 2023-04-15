<?php

namespace App\Http\Controllers\Admin\Ecommerce;

use Illuminate\Http\Request;
use App\Http\Controllers\Admin\AdminController;

use App\Repositories\Orders\FeedbackRepository;

use Crazy\Helpers\Arr;

class OrderFeedbackController extends AdminController
{
    protected $module = 'orders.feedback';

    protected $moduleName = 'Feedback Đơn hàng';

    protected $flashMode = true;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(FeedbackRepository $feedbackRepository)
    {
        $this->repository = $feedbackRepository;
        $this->init();
    }

    public function start()
    {
        add_js_data('order_feedback',[
            'urls' => [
                'get_order_options' => route($this->routeNamePrefix.'orders.select-options'),
                'resolve' => $this->getModuleRoute('resolve'),
                'unresolve' => $this->getModuleRoute('unresolve')
                
            ]
        ]);
        /* them data cho js xư ly */
        add_js_data('order_data', [
            'urls' => [
                'change_status' => route($this->routeNamePrefix.'orders.change-status'),
                'get_detail' => route($this->routeNamePrefix.'orders.resource-detail')
            ]
        ]);
        add_js_src('static/manager/js/order.feedback.js', 'manager/js/order.list.js');
    }

    
    /**
     * thay đổi trạng thái đơn hàng
     * @param Request
     * @return json
     */
    public function getFeedbackDetail(Request $request)
    {
        extract($this->apiDefaultData);
        if($request->id && $detail = $this->repository->detail($request->id)){
            $data = $detail;
            $status = true;
        }
        return $this->json(compact(...$this->apiSystemVars));
    }

    /**
     * thay đổi tỉnh trạng xử lý
     * @param Request
     * @return json
     */
    public function resolve(Request $request)
    {
        extract($this->apiDefaultData);
        if($request->id){
            $updateData = ['solved' => 1, 'solved_at' => date('Y-m-d H:i:s')];
            if($updated = $this->repository->update($request->id, $updateData)){
                $status = true;
                $message = 'Cập nhật trạng thái feedback thành công!';
                $data = $updated;
            }
        }
        return $this->json(compact(...$this->apiSystemVars));
    }


    /**
     * thay đổi tỉnh trạng xử lý
     * @param Request
     * @return json
     */
    public function unresolve(Request $request)
    {
        extract($this->apiDefaultData);
        if($request->id){
            $updateData = ['solved' => 0, 'solved_at' => null];
            if($updated = $this->repository->update($request->id, $updateData)){
                $status = true;
                $message = 'Cập nhật trạng thái feedback thành công!';
                $data = $updated;
            }
        }
        return $this->json(compact(...$this->apiSystemVars));
    }

}
