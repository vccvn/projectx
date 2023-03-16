<?php

namespace App\Models;

class ProductVariantAttribute extends Model
{
    public $table = 'product_variant_attributes';
    public $fillable = ['product_variant_id', 'attribute_value_id', 'variant_advance_value'];

    public $timestamps = false;

}
