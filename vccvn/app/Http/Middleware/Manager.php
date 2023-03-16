<?php
/**
 * middleware phân quyền
 * @author Doan Le
 * @copyright 2019
 * 
 * tác dụng Phân quyền cho các route
 */

namespace App\Http\Middleware;

use Closure;

use Crazy\Laravel\Router;
use App\Repositories\Permissions\ModuleRepository;
use App\Repositories\Permissions\RouteRepository;
use ReflectionClass;

class Manager
{
    protected static $checkedModules = [];
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        
        if(!($user = $request->user())) return $this->redirect($request);
        
        // lấy thông tin route hiện tại
        $routeinfo = Router::getRouteInfo($request->route());
        $moduleRep = new ModuleRepository();
        if(!in_array($user->type, ['admin', 'manager', 'content'])) return $this->redirect($request);
        
        if(!count($modules = $moduleRep->getModuleByRouteInfo($routeinfo))) return $next($request);
        
        $userRoles = [];
        $userRoles = $user->roleLevels();
        foreach($modules as $module){
            // nếu không vượt qua dc phân quyền thì chuyển đến trang 403
            if(!$this->checkModule($request, $module, $userRoles)) return $this->redirect($request);
        }
        return $next($request);
    }

    /**
     * kiểm tra user
     * @param App\Models\User
     * @return boolean
     */
    public function checkUser($user)
    {
        if(!$user) return false;
        if($owner_id = get_owner_id()){
            if($user->id != $owner_id && $user->owner_id != $owner_id) return false;
        }
        return true;
        
    }

    /**
     * kiểm tra module
     * @param Request $request
     * @param App\Models\PermissionModule $module
     * @param array $userRoles
     * @return boolean
     */
    public function checkModule($request, $module, $userRoles)
    {
        $moduleRoles = $module->roleLevels();
        if(in_array($module->id, self::$checkedModules)) return true;
        self::$checkedModules[] = $module->id;
        $checkParent = true;
        if($parent = $module->getParent()){
            // nếu kiểm tra quyền của module cha ko qua dc
            if(!$this->checkModule($request, $parent, $userRoles)) return false;
        }
        
        // nếu không yêu cầu kiểm tra quyền thì cho qua
        if(!count($moduleRoles['list'])) return true;
        // nếu người dùng không được cấp quyền
        if(!count($userRoles['list'])) return false;

        // nếu user có quyền admin
        if($userRoles['admin']){
            // nếu module không yêu cầu
            if(!$moduleRoles['admin']) return true;
            // nếu có yêu cầu quyền thì chạy qua hàm kiềm tra quyền
            return $this->checkRole($request, $moduleRoles['roles'][$moduleRoles['admin'][0]]);
        }
        elseif($moduleRoles['admin']) return false;
        


        // nếu user có quyền mod
        if($userRoles['mod']){
            // nếu module không yêu cầu
            if(!$moduleRoles['mod']) return true;
            // nếu số quyền của user ít hơn của module thì false luôn
            if(count($userRoles['mod'])<count($moduleRoles['mod'])){
                return false;
            }
            foreach($moduleRoles['mod'] as $role_id){
                // nếu một quyền nào  đó có trong danh sách của module nhưng user lại không có thì dừng luôn
                if(!in_array($role_id, $userRoles['mod'])) return false;

                // kiểm tra xem quyền này có cần xử lý gì ko? nếu có xử lý và trả về false thì dừng luôn
                if(!$this->checkRole($request, $moduleRoles['roles'][$role_id])) return false;
            }
            // nếu có yêu cầu quyền thì chạy qua hàm kiềm tra quyền
            return true;
        }elseif($moduleRoles['mod']) return false;
        

        // giống logic phần mod
        if(count($userRoles['access'])<count($moduleRoles['access'])){
            return false;
        }
        foreach($moduleRoles['access'] as $role_id){
            if(!in_array($role_id, $userRoles['access'])) return false;
            if(!$this->checkRole($request, $moduleRoles['roles'][$role_id])) return false;
        }
        
        return true;
        
    }

    /**
     * kiểm tra quyền
     * @param Request $request
     * @param App\Models\PermissionRole $role
     * @return boolean
     */
    public function checkRole($request, $role)
    {
        // nếu ko có handle thì return true
        if(!$role->handle) return true;
        $handle = $role->handle;
        // kiểm tra xem có phải là đối tượng cần khời tạo từ class hay ko
        if(count($d = explode('->', $handle))==2){
            // nếu tồn tại class
            if($d[0] && $d[1] && class_exists($d[0])){
                $rc = new ReflectionClass($d[0]);
                $object = $rc->newInstanceArgs( [] );
                // tạo đối tượng
                if(method_exists($object, $d[1])){
                    // kiểm tra phuong thuc và gọi
                    return call_user_func_array([$object, $d[1]], [$request]);
                }
            }
            return false;
        }
        // nếu handle hà hàm hay phuong thuc static
        // trả về kết quả gọi hàm
        if(is_callable($handle)) return $handle($request);

        return false;
    }

    // chuyển hướng trang
    public function redirect($request)
    {
        if (0 === strpos($request->headers->get('Accept'), 'application/json'))
        {
            return response()->json(['status' => false, 'message'=>'Bạn không thể thực hiện hành động này!'], 403);
        }
        return abort(403, "Truy cập bị từ chối");;
    }
}
