<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderFeedbackResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $data = [
            'id' => $this->id,
            'order_id' => $this->order_id,
            'customer_id' => $this->customer_id,
            'customer_name' => $this->customer_name,
            'customer_email' => $this->customer_email,
            'type' => $this->type,
            'title' => $this->title,
            'description' => htmlentities($this->description),
            'solved' => $this->solved,
            'created_at' => $this->created_at . ''
            
        ];
        return $data;
    }
}
