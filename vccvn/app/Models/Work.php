<?php

namespace App\Models;

class Work extends Model
{
    public $table = 'works';
    public $fillable = ['title', 'work_group', 'description'];

    public $timestamps = false;
    
}
