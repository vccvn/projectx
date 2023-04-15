<?php

namespace App\Models;

class HtmlComponent extends Model
{
    public $table = 'html_components';
    public $fillable = ['component_id', 'area_id', 'priority', 'data'];

    public $casts = [
        'data' => 'json'
    ];

    public $timestamps = false;

}
