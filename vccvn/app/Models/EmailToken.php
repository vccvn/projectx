<?php

namespace App\Models;

class EmailToken extends Model
{
    public $table = 'email_tokens';
    public $fillable = ['email', 'type', 'ref', 'ref_id', 'token', 'code', 'expired_at'];
    
}
