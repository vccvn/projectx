<?php

namespace App\Models;
use Crazy\Helpers\Arr;

class PermissionRole extends Model
{
    protected $table = 'permission_roles';

    protected $fillable = ['name', 'level', 'description', 'handle'];

    public $labels = [
        1 => 'access',
        2 => 'mod',
        3 => 'admin',
    ];

    public function roleModules()
    {
        return $this->hasMany('App\Models\PermissionModuleRole', 'role_id', 'id');
    }

    public function roleUsers()
    {
        return $this->hasMany('App\Models\PermissionUserRole', 'role_id', 'id');
    }

    public function modules()
    {
        return $this->roleModules()->join('permission_modules', 'permission_modules.id', '=', 'permission_module_roles.module_id')->select('permission_modules.*');
    }

    public function users()
    {
        return $this->roleUsers()->join('users', 'users.id', '=', 'permission_user_roles.user_id')->select('users.id', 'users.name', 'users.email', 'users.username', 'users.avatar');
    }

    
    public function label()
    {
        return $this->labels[$this->level];
    }


    /**
     * bắt sự kiện xóa
     */
    public function beforeDelete()
    {
        $this->roleModules()->delete();
        $this->roleUsers()->delete();
    }

    /**
     * user optiobs
     * @return array
     */
    public function getUserOptions()
    {
        $options = [];
        if($this->users){
            foreach ($this->users as $user) {
                $options[] = [
                    'name' => $user->name,
                    'id' => $user->id
                ];
            }
        }
        return $options;
    }

}
