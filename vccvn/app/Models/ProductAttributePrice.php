<?php

namespace App\Models;

class ProductAttributePrice extends Model
{
    public $table = 'product_attribute_price';
    public $fillable = ['owner_id', 'product_id', 'attribute_key', 'attribute_price'];
    
    public $timestamps = false;

    
    /**
     * lấy sản phẩm
     * 
     */
    public function product()
    {
        return $this->belongsTo('App\Models\Product', 'product_id', 'id');
    }

    
}
