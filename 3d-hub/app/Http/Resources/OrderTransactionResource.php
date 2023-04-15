<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderTransactionResource extends JsonResource
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
            'customer_id' => $this->customer_id,
            'customer_name' => $this->customer_name,
            'customer_email' => $this->customer_email,
            'type' => $this->type,
            'code' => $this->code,
            'amount' => $this->amount,
            'time' => $this->time,
            'status' => $this->status,
            'note' => htmlentities($this->note),
            'bills' => new FileCollection($this->bills)
        ];
        return $data;
    }
}
