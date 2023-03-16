<?php

namespace App\Models;

class OrderFeedback extends Model
{
    public $table = 'order_feedback';
    public $fillable = ['owner_id', 'order_id', 'customer_id', 'user_id', 'type', 'title', 'description', 'solved', 'solved_at'];

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
