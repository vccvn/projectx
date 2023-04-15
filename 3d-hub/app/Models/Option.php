<?php

namespace App\Models;

class Option extends Model
{
    public $table = 'options';
    public $fillable = ['title', 'slug', 'ref', 'ref_id'];

    public $timestamps = false;
    /**
     * lay du lieu form
     * @return array
     */
    public function toFormData()
    {
        $data = $this->toArray();
        return $data;
    }

    public function optionGroups()
    {
        return $this->hasMany('App\Models\OptionGroup', 'option_id', 'id');
    }

    public function groups()
    {
        return $this->optionGroups();
    }

    public function beforeDelete()
    {
        if(count($this->optionGroups)){
            foreach ($this->optionGroups as $group) {
                $group->delete();
            }
        }
    }
}
