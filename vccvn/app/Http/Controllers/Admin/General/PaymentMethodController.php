<?php

namespace App\Http\Controllers\Admin\General;

use App\Http\Controllers\Admin\AdminController;

use Illuminate\Http\Request;
use Crazy\Helpers\Arr;

use App\Repositories\Payments\MethodRepository;

class PaymentMethodController extends AdminController
{
    protected $module = 'payments.methods';

    protected $moduleName = 'Phương thức thanh toán';

    // protected $flashMode = true;

    /**
     * repository chinh
     *
     * @var MethodRepository
     */
    public $repository;
    
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(MethodRepository $repository)
    {
        $this->repository = $repository;
        $this->init();
    }

    // public function getList(Request $request)
    // {
    //     return $this->viewModule('index', [
    //         'results' => $this->repository->getResults($request),
    //         'method_options' => get_payment_select_options()
    //     ]);
    // }

    public function getIndex(Request $request)
    {
        return $this->getList($request);
    }


    public function getMethodDetail(Request $request)
    {
        extract($this->apiDefaultData);
        if(!$request->id){
            $message = 'Không có thông tin phương thức';
        }
        elseif(!($method = $this->repository->detail($request->id))){
            $message = 'Phương thức không tồn tại';
        }else{
            $status = true;
            $data = $method;
        }
        return $this->json(compact(...$this->apiSystemVars));
    }

    public function updateStatus(Request $request)
    {
        extract($this->apiDefaultData);
        if(!$request->id){
            $message = 'Không có thông tin phương thức';
        }
        elseif(!($method = $this->repository->detail($request->id))){
            $message = 'Phương thức không tồn tại';
        }
        elseif(!($m = $this->repository->update($request->id, ['status' => $request->status?1:0]))){
            $message = 'Cập nhật trạng thái không thành công!';
        }
        else{
            $status = true;
            $data = $m;
        }
        return $this->json(compact(...$this->apiSystemVars));
    }

    public function updatePriority(Request $request)
    {
        extract($this->apiDefaultData);
        if(!$request->data || !is_array($request->data)){
            $message = 'Không có thông tin phương thức';
        }
        elseif(
            count( // dêm số lượng bàn ghi cập nhật thành công
                $rs = array_filter( // lọc ra các kết quả cập nhật thành công
                    $errors = array_map( // map qua mang du lieu de cap nhat
                        function($mt){
                            return (
                                (!is_array($mt) || !isset($mt['id']) || !isset($mt['priority']))? [
                                    'status' => false,
                                    'data' => $mt
                                ] : (
                                    ($ud = $this->repository->update($mt['id'], ['priority' => $mt['priority']]))? [
                                        'status' => true,
                                        'data' => $ud
                                    ]:[
                                        'status' => true,
                                        'data' => null
                                    ]
                                )
                            );
                        },
                        $request->data
                    ), 
                    function($el){return $el['status']?true:false;}
                )
            ) != count($request->data) // so sánh với bản ghi dược cung cấp
        ){
            $message = 'Một hoặc nhiều phương thức có thể chưa được cập nhật';
        }
        else{
            $status = true;
            $data = $rs;
        }
        return $this->json(compact(...$this->apiSystemVars));
    }

    /**
     * can thiệp data truốc khi lưu
     *
     * @param Request $request
     * @param Arr $data
     * @return void
     */
    public function beforeAjaxSave($request, $data)
    {
        // $data->config = $data->cutWithout(['name', 'descriprion', '_token']);
    }

    public function getMethodInputs(Request $request)
    {
        extract($this->apiDefaultData);
        $data = get_payment_method_inputs($request->method);
        $status = true;
        return $this->json(compact(...$this->apiSystemVars));
    }
}
