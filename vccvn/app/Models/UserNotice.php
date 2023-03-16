<?php

namespace App\Models;

class UserNotice extends Model
{
    public $table = 'user_notices';
    public $fillable = ['user_id', 'notice_id', 'seen', 'seen_at'];

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
