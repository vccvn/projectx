<?php

namespace App\Models;

class Component extends Model
{
    public $table = 'components';
    public $fillable = ['type', 'ref', 'ref_id', 'name', 'path', 'inputs', 'data'];

    public $timestamps = false;

    public $casts = [
        'inputs' => 'json',
        'data' => 'json'
    ];

    public function htmlComponents()
    {
        return $this->hasMany('App\Models\HtmlComponent', 'component_id', 'id');
    }

    public function beforeDelete()
    {
        $this->deleteList('htmlComponents');
    }
}
