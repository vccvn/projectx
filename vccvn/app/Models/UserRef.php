<?php

namespace App\Models;

class UserRef extends Model
{
    public $table = 'user_refs';
    public $fillable = ['user_id', 'ref_id', 'ref'];


    public $timestamps = false;


}
