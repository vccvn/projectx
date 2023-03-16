<?php

namespace App\Http\Controllers\Traits;

use Crazy\Helpers\Arr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

/**
 * các thuộc tính và phương thức của form sẽ được triển trong ManagerController
 * @method void beforeAjaxSearch(\Illuminate\Http\Request $request)
 * @method void beforeGetResourceDetail(\Illuminate\Http\Request $request)
 * 
 */

trait ResponseMethods
{
    
    /**
     * thực hiện các thao tác với dữ liệu truoc khi trả về trình duyệt
     * @param mixed $data           Dữ liệu trả về
     * @param integer $code         Http code
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function json($data, $code=200, array $headers = [])
    {
        $args = [$data, $code];
        if(is_array($headers) && count($headers)) $args[] = $headers;
        $resp = response()->json(...$args);
        return $resp;
    }

    
    /**
     * thay đổi trạng thái đơn hàng
     * @param Request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getResourceDetail(Request $request)
    {
        extract($this->apiDefaultData);
        if(method_exists($this, 'beforeGetResourceDetail')){
            $this->beforeGetResourceDetail($request);
        }
        if($request->id && $detail = $this->repository->detail($request->id)){
            $data = $detail;
            $status = true;
        }else{
            $message = "Không tìm thấy mục yêu càu";
        }
        return $this->json(compact(...$this->apiSystemVars));
    }

    /**
     * lấy danh sách 
     * @param Iluminate\Http\Request
     * @param array $args Tham số tùy chỉnh
     * @param \App\Repositories\BaseRepository $repository (option)
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    protected function getAjaxData(Request $request, array $args = [], $repository = null)
    {
        if(!$repository) $repository = $this->repository;
        extract($this->apiDefaultData);
        $status = true;
        if($list = $repository->filter($request, $args)){
            $data = $list;
        }else{
            $message = 'Danh sách trống';
        }

        $count = $repository->totalCount;

        // noi mang du lieu voi mang du lieu phan trang
        $data = array_merge(
            compact('status','message','data','count'),
            $repository->getPaginateData($request, $count)
        );
        // return $this->json(compact(...$this->apiSystemVars));
        return $this->json($data);
    }

    /**
     * tim kiếm ajax
     * @param Request $request
     * 
     */
    public function ajaxSearch(Request $request)
    {
        $data = [];
        if(method_exists($this, 'beforeAjaxSearch')){
            $d = new Arr($data);
            $this->beforeAjaxSearch($request, $d);
            $data = $d->all();
        }
        return $this->getAjaxData($request, $data);
    }

    /**
     * lấy thong tin slug
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getSlug(Request $request)
    {
        extract($this->apiDefaultData);

        $data = $this->repository->getSlug($request->slug, $request->id);
        $status = true;
        return $this->json(compact(...$this->apiSystemVars));
    }

    /**
     * kiem tra thong tin slug
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function checkSlug(Request $request)
    {
        extract($this->apiDefaultData);

        $code = $this->repository->checkSlug($request->slug, $request->id);
        if($code == 1){
            $status = true;
        }
        $msg = [
            -2 => "Đường dẫn chứa ký tự không hợp lệ",
            -1 => 'Bạn chưa nhập thông tin',
            0 => "Bạn không thể sử dụng đường dẫn này",
            1 => "Bạn có thể sử dụng đường dẫn này",

        ];
        $message = $msg[$code];
            
        return $this->json(compact(...$this->apiSystemVars));
    }

    
    /**
     * Thêm bản ghi mới
     * @param Request $request
     */
    public function add(Request $request)
    {
        return $this->ajaxSave($request);
    }


    /**
     * cập nhật thông tin bản ghi
     * @param Request $request
     * @param int $id
     */
    public function edit(Request $request, $id=null)
    {
        return $this->ajaxSave($request, $id);
    }

}