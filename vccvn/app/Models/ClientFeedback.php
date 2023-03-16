<?php

namespace App\Models;

class ClientFeedback extends Model
{
    public $table = 'client_feedback';
    public $fillable = ['owner_id', 'client_id', 'subject', 'message'];

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
