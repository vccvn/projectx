<?php

namespace App\Models;

class Ward extends Model
{
    public $table = 'wards';
    public $fillable = ['district_id', 'name', 'slug'];

    public $timestamps = false;
}
