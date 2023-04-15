<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
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
            'type' => $this->type,
            'name' => $this->name,
            'phone_number' => $this->phone_number,
            'email' => $this->email,
            'address' => $this->address,
            'payment_method' => $this->payment_method,
            'ship_fee' => $this->ship_fee,
            'vat' => $this->vat,
            'total_money' => $this->total_money,
            'note' => $this->note,
            'status' => $this->status,
            'deleted' => $this->deleted,
            'completed_at' => $this->completed_at,
            'created_at' => $this->created_at.'',
            'updated_at' => $this->updated_at.'',
            'items' => new OrderItemCollection($this->productItems)
        ];
        return $data;
    }
}
