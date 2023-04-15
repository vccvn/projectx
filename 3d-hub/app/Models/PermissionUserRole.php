<?php

namespace App\Models;



class PermissionUserRole extends Model
{
    public $table = 'permission_user_roles';

    public $fillable = ['user_id', 'role_id'];

    public $timestamps = false;

    public function role()
    {
        return $this->belongsTo('App\Models\PermissionRole','role_id','id');
    }

    public function user()
    {
        return $this->belongsTo('App\Models\PermissionUser','user_id','id');
    }

}
