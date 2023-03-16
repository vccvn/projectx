<?php

namespace App\Models;

class CategoryRef extends Model
{
    public $table = 'category_refs';
    public $fillable = ['category_id', 'ref', 'ref_id'];

    public $timestamps = false;
}
