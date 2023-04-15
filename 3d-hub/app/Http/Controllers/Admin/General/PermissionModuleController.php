<?php

namespace App\Http\Controllers\Admin\General;

use Illuminate\Http\Request;
use App\Http\Controllers\Admin\AdminController;

use App\Repositories\Permissions\ModuleRepository;
use App\Repositories\Permissions\ModuleRoleRepository;

use App\Repositories\Permissions\RouteRepository;

use Crazy\Helpers\Arr;

class PermissionModuleController extends AdminController
{
    protected $module = 'permissions.modules';

    protected $moduleName = 'Module phân quyền';
    
    protected $data = [];


    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(ModuleRepository $ModuleRepository, RouteRepository $RouteRepository, ModuleRoleRepository $ModuleRoleRepository)
    {
        $this->repository = $ModuleRepository;
        $this->routes = $RouteRepository;
        $this->moduleRoles = $ModuleRoleRepository;
        $this->init();
        
    }

    /**
     * can thiep truoc khi sho form
     * @param Request $request
     * @param Arr $config
     * @param Arr $inputs
     * @param Arr $data
     * @param Arr $attrs ($form_attrs)
     * không dùng đến thì ko cần khai báo cho đỡ mệt
     * nhưng nếu dùng thì phải khai báo theo thứ tự
     * @return void
     */
    public function beforeGetCrudForm(Request $request, Arr $config, Arr $inputs, Arr $data, Arr $attrs)
    {
        
        admin_breadcrumbs([
            [
                'url' => $this->getModuleRoute('create'),
                'text' => 'Thêm module'
            ],
        ]);
        # gọi hàm them dường dẫn js
        add_js_src('static/manager/js/modules.js');

        add_js_data('crazymodule_data', 'get_options_url', $this->getModuleRoute('get-route-options'));

        // nếu cập nhật sẽ lây ra 
        if($request->id && $roles = $this->moduleRoles->getModuleRoleChecked($request->id)){
            $data->roles = $roles;
        }
    }
    /**
     * xử lý sau khi luu trữ
     * @param Request $request
     * @param App\Models\PermissionModule
     * 
     * @return void
     */
    public function afterSave(Request $request, $result)
    {
        $this->moduleRoles->updateModuleRoles(
            $result->id, 
            is_array($request->roles)?$request->roles:[]
        );
    }

    
    /**
     * lấy thông tin route
     * @param Request $request
     * @return json
     */
    public function getRouteOptions(Request $request)
    {
        extract($this->apiDefaultData);

        if(in_array($type = strtolower($request->type), ['uri', 'name', 'prefix']) && $routes = $this->routes->getRouteOptions($type)){
            $data = $routes;
            $status = true;
        }else{
            $message = 'Không có kết quả phù hợp';
        }

        return $this->json(compact(...$this->apiSystemVars));
    }

}
