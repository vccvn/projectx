<?php

namespace App\Models;

class Skill extends Model
{
    public $table = 'skills';
    public $fillable = ['work_id', 'type', 'name', 'description'];

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
}
