<?php

namespace App\Models;

class Subcribe extends Model
{
    public $table = 'subcribes';
    public $fillable = ['owner_id', 'name', 'email', 'phone_number'];

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

    public function getSubcribeInfo()
    {
        $a = [];
        if($this->name){
            $a[] = 'Hõ tên: '.$this->name;
        }
        if($this->email){
            $a[] = 'Email: '.$this->email;
        }
        if($this->phone_number){
            $a[] = 'SĐT: '.$this->phone_number;
        }
        return implode('<br>', $a);
    }
}
