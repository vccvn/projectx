<?php

namespace App\Models;

class Customer extends Model
{
    public $table = 'customers';
    public $fillable = ['owner_id', 'user_id', 'name', 'email', 'phone_number', 'address', 'region_id', 'district_id', 'ward_id', 'balance', 'remember_token', 'deleted'];

    
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

    /**
     * rewviews
     */
    public function reviews()
    {
        return $this->hasMany('App\Models\ProductReview', 'customer_id', 'id');
    }

    /**
     * feedback
     */
    public function feedback()
    {
        return $this->hasMany('App\Models\OrderFeedback', 'customer_id', 'id');
    }

    /**
     * lay du lieu form
     * @return array
     */
    public function toFormData()
    {
        $data = $this->toArray();
        return $data;
    }

    public function beforeDelete()
    {
        $this->reviews()->delete();
        $this->feedback()->delete();

    }

}
