<?php

namespace App\Models;

class AuthLog extends Model
{
    public $table = 'auth_logs';
    public $fillable = ['owner_id', 'user_id', 'status', 'log_fail_count'];


}
