<?php

namespace App\Models;

class District extends Model
{
    public $table = 'districts';
    public $fillable = ['region_id', 'code', 'name', 'slug', 'type', 'path_with_type'];

    public $timestamps = false;

    public function wards()
    {
        return $this->hasMany('App\Models\Ward', 'district_id', 'id');
    }

    public function beforeDelete()
    {
        $this->wards()->delete();
    }
}
