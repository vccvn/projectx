<?php

namespace App\Models;

class Academic extends Model
{
    public $table = 'academics';
    public $fillable = ['title', 'keywords'];

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
