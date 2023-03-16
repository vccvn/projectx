<?php

namespace App\Http\Controllers\Traits;

use Crazy\Helpers\Arr;
use Illuminate\Http\Request;

trait ApiCrud
{

    /**
     * @var App\Validators\BaseValidator
     */
    public $validator;

    /**
     * cập nhật form
     * @param Request $request
     *
     * @return json
     */

    public function save(Request $request)
    {
        extract($this->apiDefaultData);
        $this->repository->resetDefaultParams('delwted');
        // gan id de sac minh la update hay them moi
        $id = $request->id;
        // is update
        if($id){
            if($record = $this->repository->find($id)){
                $result = $record;
                $action = 'Update';
                $is_update = true;
            }else{
                $message = 'Đã có lỗi xảy ra. Cập nhật không hợp lệ';
                return $this->json(compact(...$this->apiSystemVars), 404);
            }
        }
        else{
            $result = $this->repository->model();
            $action = 'Create';
            $is_update = false;
        }

        $this->crudAction = strtolower($action);
        // gọi phuong thuc bat su kien
        $event = 'before'.$action.'Validate';
        $this->callCrudEvent($event,$request, $id);
        $this->callCrudEvent('beforeValidate', $request, $id);

        $this->fire($action.'Validating', $this, $request, $id);
        $this->fire('validating', $this, $request, $id);

        // validate
        $validator = $this->repository->validator($request);
        if(!$validator->success()){
            $message = 'Đã có lỗi xảy ra. Vui lòng kiểm tra lại';
            $errors = $validator->errors();

        }else{
            $this->validator = $validator;
            // tao doi tuong data de de truy cap phan tu
            $d = new Arr($validator->inputs());
            // goi cac ham su kien truoc khi luu
            $this->callCrudEvent('before'.$action,$request, $d, $result);
            $this->callCrudEvent('beforeSave', $request, $d);

            $this->fire(($action == 'update')?'updating': 'creating', $this, $request, $result);
            $this->fire('saving', $this, $request, $d);

            // lấy thông tin bản ghi mới tạo
            if($model = $this->repository->save($d->all(), $id)){
                // gọi các hàm sau khi luu bản ghi thành công
                // $this->callCrudEvent('after'.$action, $request, $model, $d);
                // $this->callCrudEvent('afterSave', $request, $model, $d);
                $this->fire($action.'d', $this, $request, $model, $d);
                $this->fire('saved', $this, $request, $model, $d);
                $boolA = is_bool($afa = $this->callCrudEvent('after'.$action, $request, $model, $d));
                $boolS = is_bool($afs = $this->callCrudEvent('afterSave', $request, $model, $d));
                if($afa && !$boolA){
                    return $afa;
                }
                elseif($afs && !$boolS){
                    return $afs;
                }
                elseif(($boolA && $afa === false) || ($boolS && $afs === false)){
                    $message = 'Lỗi không xác định';
                }else{
                    $status = true;
                    $data = $model;
                }

            }else{
                $message = 'Lỗi không xác định';
            }

        }
        return $this->json(compact(...$this->apiSystemVars));
    }
    /**
     * xử lý dữ liệu
     * @param Request $request
     *
     * @return mixed
     */
    public function handle(Request $request)
    {
        extract($this->apiDefaultData);

        $this->callCrudEvent('beforeValidate', $request);
        $this->fire('beforeHandeValidate', $this, $request);

        // validate
        $validator = $this->repository->validator($request);
        if(!$validator->success()){
            $message = 'Đã có lỗi xảy ra. Vui lòng kiểm tra lại';
            $errors = $validator->errors();
        }else{
            // tao doi tuong data de de truy cap phan tu
            $data = new Arr($validator->inputs());
            // goi cac ham su kien truoc khi luu
            $res = $this->callCrudEvent('done', $request, $data);
            $res2 = $this->fire('done', $this, $request, $data);
            $status = true;
            $data = $res;
        }
        return $this->json(compact(...$this->apiSystemVars));
    }


    /**
     * luu data tao moi
     * @param Request $request
     */
    public function store(Request $request)
    {
        return $this->save($request);
    }
}
