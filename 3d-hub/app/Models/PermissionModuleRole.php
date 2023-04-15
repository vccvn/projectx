<?php

namespace App\Models;

class PermissionModuleRole extends Model
{
    public $table = 'permission_module_roles';

    public $fillable = ['module_id', 'role_id'];

    public $timestamps = false;

    public function role()
    {
        return $this->belongsTo('App\\Models\\PermissionRole','role_id','id');
    }

    public function module()
    {
        return $this->belongsTo('App\\Models\\PermissionModule','module_id','id');
    }

}
