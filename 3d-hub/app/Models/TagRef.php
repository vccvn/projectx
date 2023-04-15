<?php

namespace App\Models;

class TagRef extends Model
{
    public $table = 'tag_refs';
    public $fillable = ['tag_id', 'ref', 'ref_id'];

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
