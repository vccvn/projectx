<?php

namespace App\Models;

class Form extends Model
{
    public $table = 'forms';
    public $fillable = ['owner_id', 'name', 'slug', 'inputs', 'deleted'];

    public $casts = [
        'inputs' => 'json'
    ];

    public function formDatas()
    {
        return $this->hasMany(FormData::class, 'form_id', 'id');
    }

    public function beforeDelete()
    {
        $this->deleteList('formDatas');
    }

    public function getInputText()
    {
        $arr = [];
        if($this->inputs){
            foreach ($this->inputs as $index => $input) {
                $arr[] = "<strong>$input[label]</strong> <span>($input[type])</span>";
            }
        }
        return implode('<br>', $arr);
    }

}
