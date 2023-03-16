<?php

namespace App\Models;

class Region extends Model
{
    public $table = 'regions';
    public $fillable = ['name', 'slug', 'code', 'position'];

    public $timestamps = false;

    public function districts()
    {
        return $this->hasMany('App\Models\District', 'region_id', 'id');
    }

    public function beforeDelete()
    {
        $this->districts()->delete();
    }
}
