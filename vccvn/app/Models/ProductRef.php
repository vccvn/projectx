<?php

namespace App\Models;

class ProductRef extends Model
{
    public $table = 'product_refs';
    public $fillable = ['owner_id', 'product_id', 'ref', 'ref_id'];

    public $timestamps = false;

}
