<?php

namespace App\Models;

class WebAccountPackage extends Model
{
    public $table = 'web_account_packages';
    public $fillable = ['name', 'description', 'user_limited', 'price', 'deleted'];

}
