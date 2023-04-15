<?php

namespace App\Models;

class PaymentMethod extends Model
{
    public $table = 'payment_methods';
    public $fillable = ['name', 'method', 'config', 'description', 'priority', 'status', 'deleted'];


    public $casts = [
        'config' => 'json',
    ];

}
