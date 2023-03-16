<?php

namespace App\Models;

class FormData extends Model
{
    public $table = 'form_datas';
    public $fillable = ['owner_id', 'form_id', 'data'];
    
    public $casts = [
        'data' => 'json'
    ];

    public function form()
    {
        return $this->belongsTo(Form::class, 'form_id', 'id');
    }
}
