<?php

namespace App\Models;

class Contact extends Model
{
    public $table = 'contacts';
    public $fillable = ['owner_id', 'name', 'email', 'phone_number', 'address', 'subject', 'message'];

    /**
     * lay du lieu form
     * @return array
     */
    public function toFormData()
    {
        $data = $this->toArray();
        return $data;
    }

    public function replies()
    {
        return $this->hasMany('App\Models\ContactReply', 'contact_id', 'id');
    }

    public function replyListDetail()
    {
        return $this->replies()->join('users', 'users.id', '=', 'contact_replies.user_id')
                    ->select('contact_replies.*', 'users.name', 'users.email');
    }

    public function beforeDelete()
    {
        $this->replies()->delete();
    }
}
