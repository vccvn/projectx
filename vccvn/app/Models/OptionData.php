<?php

namespace App\Models;

class OptionData extends Model
{
    public $table = 'option_datas';
    public $fillable = ['owner_id', 'group_id', 'name', 'label', 'type', 'value_type', 'value', 'priority', 'props', 'can_delete'];

    public $casts = [
        'props' => 'json'
    ];
    public $timestamps = false;

    /**
     * lay du lieu form
     * @return array
     */
    public function toFormData()
    {
        $data = $this->toArray();
        if($this->props && is_array($this->props)){
            foreach($this->props as $key => $value){
                $data[$key] = $value;
            }
        }
        return $data;
    }

    public function canDelete()
    {
        return $this->can_delete;
    }
}
