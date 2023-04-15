<?php

namespace App\Http\Controllers\Traits;

use Crazy\Helpers\Arr;
use Illuminate\Http\Request;

trait ApiFilter{
    
    /**
     * thực hiện các thao tác với dữ liệu truoc khi trả về trình duyệt
     * @param mixed $data           Dữ liệu trả về
     * @param integer $code         Http code
     * 
     * @return Response
     */
    public function json($data, $code=200, array $headers = [])
    {
        $args = [$data, $code];
        if(is_array($headers) && count($headers)) $args[] = $headers;
        $resp = response()->json(...$args);
        return $resp;
    }


    /**
     * trả vệ output theo mẫu
     */

    public function output($data, $status = false, string $messages = '', array $errors = [])
    {
        return $this->json(compact(...$this->apiSystemVars));
    }


    /**
     * lấy danh sách 
     * @param Iluminate\Http\Request
     * @param array $args Tham số tùy chỉnh
     * @param App\Repositories\Repository $repository (option)
     * 
     * @return response
     */
    protected function getData(Request $request, array $args = [], $repository = null)
    {
        if(!$repository) $repository = $this->repository;
        extract($this->apiDefaultData);
        // dd($args);
        if($list = $repository->filter($request, $args)){
            $data = $list;
            $status = true;
        }else{
            $message = 'Danh sách trống';
        }

        $count = $repository->totalCount;

        // noi mang du lieu voi mang du lieu phan trang
        $data = array_merge(
            compact('status','message','data','count'),
            $repository->getPaginateData($request, $count)
        );
        
        return $this->json($data);
    }


    /**
     * lấy danh sách 
     * @param Iluminate\Http\Request
     * 
     * @return response
     */
    public function index(Request $request)
    {
        return $this->getData($request);
    }

    /**
     * lấy danh sách 
     * @param Iluminate\Http\Request
     * 
     * @return response
     */
    public function search(Request $request)
    {
        return $this->getData($request);
    }

    /**
     * lấy danh sách dã xóa
     * @param Iluminate\Http\Request
     * 
     * @return response
     */
    public function trash(Request $request)
    {
        $this->repository->resetDefaultParams('deleted');
        return $this->getData($request, ['deleted' => 1]);
    }

    /**
     * lay thong tin bản ghi thông qua id
     * @param int $id
     * 
     * @return response
     */
    public function detail($id=null)
    {
        extract($this->apiDefaultData);

        if($id && $detail = $this->repository->detail($id)){
            $data = $detail;
            $status = true;
        }
        else{
            $message = 'mục Không tồn tại';
        }
        return $this->json(compact('status','message','data'));
    }

}