<?php

namespace App\Models;

class Province extends Model
{
    public $table = 'provinces';
    public $fillable = ['name', 'slug', 'position'];

    public $timestamps = false;
}
