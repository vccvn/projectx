<?php

namespace App\Models;

class Notice extends Model
{
    public $table = 'notices';
    public $fillable = ['created_by', 'to_id', 'to_group', 'type', 'title', 'message', 'ref', 'ref_id', 'seen'];

    
    
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
