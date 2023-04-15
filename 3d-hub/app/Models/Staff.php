<?php

namespace App\Models;

class Staff extends Model
{
    public $table = 'users';
    public $fillable = ['name', 'email', 'username', 'email_verified_at', 'password', 'phone_number', 'facebook_id', 'google_id', 'google2fa_secret', 'type', 'avatar', 'status', 'deleted'];

}
