<?php

namespace App\Models;

class FileRef extends Model
{
    public $table = 'file_refs';
    public $fillable = ['owner_id', 'file_id', 'ref_id', 'ref'];

    
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

    public function file()
    {
        return $this->belongsTo(Fiie::class, 'file_id', 'id');
    }
}
