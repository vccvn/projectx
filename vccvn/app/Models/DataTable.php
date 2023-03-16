<?php

namespace App\Models;

class DataTable extends Model
{
    public $table = 'data_tables';
    public $fillable = ['owner_id', 'name', 'title', 'description', 'config', 'data', 'ai'];
    protected $casts = [
        'config' => 'array',
        'data' => 'array',
    ];

}
