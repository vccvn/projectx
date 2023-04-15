<?php
namespace App\Models;

use Crazy\Laravel\Router;

class PermissionModule extends Model
{
    public $table = 'permission_modules';
    public $fillable = ['name','ref','type','parent_id','description','status'];

    public function roles()
    {
        return $this->hasMany('App\Models\PermissionModuleRole','module_id','id');
    }

    public function getParent()
    {
        if($this->parent_id > 0){
            return $this->getParentByID();
        }
        return $this->getParentByPrefix();
    }

    public function getParentByID()
    {
        return self::find($this->parent_id);
    }

    public function getParentByPrefix()
    {
        if($this->type!='default'){
            $r = null;
            if($this->type=='name' && $route = Router::getByName($this->ref)){
                $r = $route;
            }
            elseif($this->type=='uri' && $route = Router::getByUri($this->ref)){
                $r = $route;
            }
            
            if($r){
                if($r['prefix']){
                    return self::where('type','prefix')->where('ref',$r['prefix'])->first();
                }
            }
        }
        return null;
    }

    public function getChildren()
    {
        if($this->type=='default'){
            return self::where('parent_id',$this->id)->get();
        }
        return null;
    }

    
    /**
     * lấy ra danh sách role
     */
    public function roleList()
    {
        return $this->roles()
                    ->join('permission_roles', 'permission_roles.id', '=', 'permission_module_roles.role_id')
                    ->select('permission_roles.id', 'permission_roles.name', 'permission_roles.level', 'permission_roles.description')
                    ->orderBy('permission_roles.level', 'DESC');
    }

    public function roleLevels()
    {
        $data = ['admin' => [], 'mod' => [], 'access' => [], 'list' => [], 'roles' => []];
        $level = [3 => 'admin', 2 => 'mod', 1 => 'access'];
        if(count($this->roleList)){
            foreach($this->roleList as $role){
                $data[$level[$role->level]][] = $role->id;
                $data['list'][] = $role->id;
                $data['roles'][$role->id] = $role;
            }
        }
        return $data;
    }

    public function beforeDelete()
    {
        $this->roles()->delete();
    }
}
