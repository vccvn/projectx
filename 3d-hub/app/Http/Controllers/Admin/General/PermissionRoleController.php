<?php

namespace App\Http\Controllers\Admin\General;

use Illuminate\Http\Request;
use App\Http\Controllers\Admin\AdminController;

use App\Repositories\Permissions\RoleRepository;

use App\Repositories\Permissions\UserRoleRepository;

use Crazy\Helpers\Arr;

class PermissionRoleController extends AdminController
{
    protected $module = 'permissions.roles';

    protected $moduleName = 'Quyền truy cập';
    
    protected $data = [];


    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(RoleRepository $RoleRepository, UserRoleRepository $UserRoleRepository)
    {
        $this->repository = $RoleRepository;
        $this->userRoles = $UserRoleRepository;
        $this->init();
        admin_breadcrumbs([
            [
                'text' => 'Thêm quyền',
                'url' => route($this->routeNamePrefix.'permissions.roles.create')
            ]
        ]);
    }

    /**
     * cap nhat thong tin role user
     */
    public function saveUserRole(Request $request)
    {
        extract($this->apiDefaultData);

        $validator = $this->userRoles->validator($request);
        if(!$validator->success()){
            $message = "Đã có lỗi xảy ra. Vui lòng kiểm tra lại!";
            $errors = $validator->errors();
        }else{
            $this->userRoles->updateUserRole($request->role_id, is_array($request->users)?$request->users:[]);
            $status = true;
            $message = "Cập nhật thành công!";
        }
        return $this->json(compact(...$this->apiSystemVars));
    }
}
