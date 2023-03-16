<?php

namespace App\Http\Controllers\Traits;

use Crazy\Helpers\Arr;
use Illuminate\Http\Request;
// use Crazy\Html\HTML;


use Crazy\Laravel\Router;


/**
 * các thuộc tính và phương thức của form sẽ được triển trong ManagerController
 * @method mixed ajaxSaveSuccess(Request $request, \App\Models\Model $model) can thiệp sau khi lưu ajax thành công
 * @method mixed ajaxSaveError(Request $request, array $errors) can thiệp Khi có lỗi xảy ra
 * 
 */
trait BaseCrud
{
    public $createMessage = null;
    public $updateMessage = null;

    /**
     * @var \App\Validators\BaseValidator
     */
    public $validator;

    protected $rederectData = [];
    /**
     * cập nhật form
     * @param Request $request
     * 
     * @return redirect
     */

    public function save(Request $request, $action = null)
    {
        $this->repository->resetTrashed();
        // gan id de sac minh la update hay them moi
        $id = strtolower($action) != 'create' ? $request->id : null;
        // is update

        if ($id && $record = $this->repository->find($id)) {
            $result = $record;
            $action = 'Update';
            $is_update = true;
        } elseif ($id) {
            return redirect()->back()->with('error', 'Lỗi không xác định')->withInput();
        } else {
            $result = $this->repository->model();
            $action = 'Create';
            $is_update = false;
        }

        $this->crudAction = strtolower($action);

        // gọi phuong thuc bat su kien
        $this->callCrudEvent('before' . $action . 'Validate', $request, $id);
        $this->callCrudEvent('beforeSaveValidate', $request, $id);
        $this->fire('before' . $action . 'Validate', $this, $request, $id);
        $this->fire('beforeSaveValidate', $this, $request, $id);
        // validate
        $validator = $this->repository->validator($request);
        if (!$validator->success()) {
            // $errors = new Arr($validator->errors());
            $errors = $validator->errors();
            if ($rs = $this->callCrudEvent('onError', $request, $errors)) {
                return $rs;
            }
            if ($rs = $this->fire('saveFailed', $this, $request, $errors)) {
                foreach ($rs as $r) {
                    if ($r) return $r;
                }
            }
            return redirect()->back()->withErrors($validator->getErrorObject())->withInput();
        }
        $this->validator = $validator;
        // tao doi tuong data de de truy cap phan tu
        $data = new Arr($validator->inputs());
        // goi cac ham su kien truoc khi luu
        $this->callCrudEvent('before' . $action, $request, $data, $result);
        $this->callCrudEvent('beforeSave', $request, $data);
        $this->fire($action.'ing', $this, $request, $data, $result);
        $this->fire('saving', $this, $request, $data);

        // lấy thông tin bản ghi mới tạo
        $model = $this->repository->save($data->all(), $id);
        if (!$model) {
            return redirect()->back()->with('error', 'Lỗi không xác định');
        }
        // gọi các hàm sau khi luu bản ghi thành công
        $this->callCrudEvent('after' . $action, $request, $model, $data);
        $this->callCrudEvent('afterSave', $request, $model, $data);

        $this->fire($action . 'd', $this, $request, $model, $data);
        $this->fire('saved', $this, $request, $model, $data);


        if ($is_update) {
            $message = $this->updateMessage ? $this->updateMessage : "Đã cập nhật " . $this->moduleName . ' thành công!';
        } else {
            $message = $this->createMessage ? $this->createMessage : "Đã thêm " . $this->moduleName . ' thành công!';
        }
        $redirect = redirect();
        $r = null;
        if ($this->redirectRoute && Router::getByName($route = $this->redirectRoute)) {
            if (is_array($this->redirectRouteParams) && count($this->redirectRouteParams)) {
                $r = $redirect->route($route, $this->redirectRouteParams);
            } else {
                $r = $redirect->route($route);
            }
        } elseif ($this->redirectRoute && Router::getByName($route = $this->routeNamePrefix . $this->redirectRoute)) {
            if (is_array($this->redirectRouteParams) && count($this->redirectRouteParams)) {
                $r = $redirect->route($route, $this->redirectRouteParams);
            } else {
                $r = $redirect->route($route);
            }
        } elseif ($is_update) {
            $r = $redirect->back();
        } else {
            $r = $redirect->route($this->routeNamePrefix . $this->module . '.update', ['id' => $model->id]);
        }
        if ($this->rederectData) {
            return $r->with($this->rederectData);
        }
        return $r->with('success', $message);
    }

    /**
     * xử lý dữ liệu
     * @param Request $request
     * 
     * @return mixed
     */
    public function handle(Request $request)
    {
        $this->callCrudEvent('beforeHandleValidate', $request);
        // validate
        $this->fire('beforeHandleValidate', $this, $request);

        $validator = $this->repository->validator($request);

        if (!$validator->success()) {
            $errors = $validator->errors();
            if ($rs = $this->callCrudEvent('onError', $request, $errors, $validator)) {
                return $rs;
            }
            if ($rs = $this->fire('handleFailed', $this, $request, $errors)) {
                foreach ($rs as $r) {
                    if ($r) return $r;
                }
            }
            return redirect()->back()->withErrors($validator->getErrorObject())->withInput();
        }

        // tao doi tuong data de de truy cap phan tu
        $data = new Arr($validator->inputs());

        if ($res = $this->callCrudEvent('done', $request, $data)) {
            return $res;
        }
        if ($rs = $this->fire('done', $this, $request, $data)) {
            foreach ($rs as $r) {
                if ($r) return $r;
            }
        }

        $redirect = $this->redirectAfterHandle();

        return $redirect->with('success', "Thao tác thành công");
    }


    public function redirectAfterHandle()
    {
        if ($this->redirectRoute && Router::getByName($route = $this->routeNamePrefix . $this->redirectRoute)) {
            if (is_array($this->redirectRouteParams) && count($this->redirectRouteParams)) {
                $redirect = redirect()->route($route, $this->redirectRouteParams);
            } else {
                $redirect = redirect()->route($route);
            }
        } else {
            $redirect = redirect()->back()->withInput();
        }
        return $redirect;
    }



    /**
     * lưu thông tin bằng ajax
     *
     * @param Request $request
     * @param string $action chỉ định tạo mới hoặc update
     * @return void
     */
    public function ajaxSave(Request $request, $action = null)
    {
        extract($this->apiDefaultData);
        $id = strtolower($action) != 'create' ? $request->id : null;
        // kiểm tra sự tồn tại của bản ghi qua id
        if ($id && !$this->repository->find($id)) {
            $message = 'Thiếu thông tin';
        } else {
            $action = $id ? 'Update' : 'Create';
            // gọi phuong thuc bat su kien
            $this->callCrudEvent('beforeAjax' . $action . 'Validate', $request, $id);
            $this->callCrudEvent('beforeAjaxValidate', $request, $id);
            $this->fire('beforeAjax' . $action . 'Validate', $this, $request, $id);
            $this->fire('beforeAjaxSaveValidate', $this, $request, $id);

            $validator = $this->repository->validator($request);

            if (!$validator->success()) {
                $errors = $validator->errors();
                if ($rs = $this->callCrudEvent('ajaxSaveError', $request, $errors)) {
                    return $rs;
                }
                if ($rs = $this->fire('ajaxSaveFailed', $this, $request, $errors)) {
                    foreach ($rs as $r) {
                        if ($r) return $r;
                    }
                }
                $message = 'Thông tin không hợp lệ';
            } else {
                // lấy dữ liệu sau khi dược xử lý và validate
                $arrInput = new Arr($validator->inputs());

                // xử lý dữ liệu

                $this->callCrudEvent('beforeAjax' . $action, $request, $arrInput);
                $this->callCrudEvent('beforeAjaxSave', $request, $arrInput);
                $this->fire('ajax' . $action .'ing', $this, $request, $arrInput);
                $this->fire('ajaxSaving', $this, $request, $arrInput);
    
                // lấy dữ liệu đã qua xử lý
                $inputs = $arrInput->all();

                // nếu có data và lưu thành công
                if ($inputs && $model = $this->repository->save($inputs, $id)) {
                    // thao tac sau khi luu tru
                    $this->callCrudEvent('afterAjax' . $action, $request, $model);
                    $this->callCrudEvent('afterAjaxSave', $request, $model);
                    // du lieu tra ve sau cung
                    
                    $this->fire('ajax' . $action . 'd', $this, $request, $model);
                    $this->fire('ajaxSaved', $this, $request, $model);
                    $data = $this->repository->detail($model->id);
                    if ($rss = $this->callCrudEvent('ajaxSaveSuccess', $request, $data)) {
                        return $rss;
                    }
                    if ($rs = $this->fire('ajaxSaveSuccess', $this, $request, $errors)) {
                        foreach ($rs as $r) {
                            if ($r) return $r;
                        }
                    }
                    

                    $status = true;
                } else {
                    $message = 'Lỗi không xác định!';
                }
            }
        }

        return $this->json(compact(...$this->apiSystemVars));
    }

    /**
     * set data khi redirect
     *
     * @param array|string $key
     * @param mixed $value
     * @return void
     */
    public function addRedirectData($key, $value = null)
    {
        if (is_array($key)) $this->rederectData = $key;
        if (is_string($key)) $this->rederectData[$key] = $value;
    }
}
