<?php

namespace App\Models;

class OrderAddress extends Model
{
    public $table = 'order_address';
    public $fillable = ['owner_id', 'order_id', 'type', 'name', 'phone_number', 'email', 'address', 'region_id', 'district_id', 'ward_id'];

    public $timestamps = false;

    public function region()
    {
        return $this->belongsTo('App\Models\Region', 'region_id', 'id');
    }
    public function district()
    {
        return $this->belongsTo('App\Models\District', 'district_id', 'id');
    }
    public function ward()
    {
        return $this->belongsTo('App\Models\Ward', 'ward_id', 'id');
    }

    public function getFullAddressText()
    {
        return $this->address . ($this->ward?', '.$this->ward->name: '')
                              . ($this->district?', '.$this->district->name: '')
                              . ($this->region?', '.$this->region->name: '');
    }

}
