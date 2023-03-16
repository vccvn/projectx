<?php

namespace App\Models;

class Booking extends Model
{
    public $table = 'bookings';
    public $fillable = ['owner_id', 'user_id', 'ref_id', 'ref', 'title', 'name', 'email', 'phone_number', 'address', 'message', 'booking_time', 'quantity'];

}
