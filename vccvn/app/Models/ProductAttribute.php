<?php

namespace App\Models;

class ProductAttribute extends Model
{
    public $table = 'product_attributes';
    public $fillable = ['owner_id', 'product_id', 'attribute_value_id', 'advance_value', 'price', 'is_default'];

    public $timestamps = false;


    public function attributeValue()
    {
        return $this->belongsTo('App\Models\AttributeValue', 'attribute_value_id', 'id');
    }

    /**
     * lấy thuộc tính
     *
     */
    public function attribute()
    {
        return $this->attributeValue->belongsTo('App\Models\Attribute', 'attribute_id', 'id');
    }

    /**
     * lấy sản phẩm
     *
     */
    public function product()
    {
        return $this->belongsTo('App\Models\Product', 'product_id', 'id');
    }

    public function beforeDelete()
    {
        if($this->attribute->advance_value_type == 'image' && $this->Advance_value && file_exists($p = asset($this->getSecretPath() . '/products/variants/'.$this->advance_value))){
            unlink($p);
        }
    }


}
