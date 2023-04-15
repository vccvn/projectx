<?php

namespace App\Models;

class ContactReply extends Model
{
    public $table = 'contact_replies';
    public $fillable = ['contact_id', 'user_id', 'message'];

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
