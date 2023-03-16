<?php

namespace App\Models;

class Service extends Model
{
    public $table = 'services';
    public $fillable = ['owner_id', 'name', 'description', 'detail', 'price'];

}
