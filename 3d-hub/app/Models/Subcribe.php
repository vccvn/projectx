<?php

namespace App\Models;

class Subcribe extends Model
{
    public $table = 'subcribes';
    public $fillable = ['email'];

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
