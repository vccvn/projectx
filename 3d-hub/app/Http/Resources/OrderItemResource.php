<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderItemResource extends JsonResource
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
            'product_id' => $this->product_id,
            'product_name' => $this->product_name,
            'product_image' => get_product_image($this->product_image),
            'attr_values' => $this->attr_values,
            'quantity' => $this->quantity,
            'list_price' => $this->list_price,
            'final_price' => $this->final_price,
            'note' => $this->note,
            'total_price' => $this->final_price * $this->quantity,
            'attributes' => $this->getAttrs(),
            
        ];
        return $data;
    }
}
