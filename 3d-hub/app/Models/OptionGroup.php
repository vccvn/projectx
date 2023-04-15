<?php

namespace App\Models;

class OptionGroup extends Model
{
    public $table = 'option_groups';
    public $fillable = ['option_id', 'label', 'slug', "config"];

    public $timestamps = false;

    public $casts = [
        'config' => 'json'
    ];

    /**
     * lay du lieu form
     * @return array
     */
    public function toFormData()
    {
        $data = $this->toArray();
        return $data;
    }

    
    public function optionDatas()
    {
        return $this->hasMany('App\Models\OptionData', 'group_id', 'id');
    }

    public function datas()
    {
        return $this->optionDatas();
    }

    public function beforeDelete()
    {
        if(count($this->optionDatas)){
            foreach ($this->optionDatas as $data) {
                $data->delete();
            }
        }
    }
}
