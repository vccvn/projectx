<?php

namespace App\Models;

class PaymentMethod extends Model
{
    public $table = 'payment_methods';
    public $fillable = ['owner_id', 'name', 'method', 'config', 'description', 'guide', 'priority', 'status', 'deleted'];


    public $casts = [
        'config' => 'json',
    ];

}
