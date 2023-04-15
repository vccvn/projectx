<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AttributeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'category_id' => $this->category_id,
            'name' => $this->name,
            'label' => $this->label,
            'input_type' => $this->input_type,
            'value_type' => $this->value_type,
            'advance_value_type' => $this->advance_value_type,
            'show_type' => $this->show_type,
            'value_unit' => $this->value_unit,
            'is_required' => $this->is_required,
            'is_query' => $this->is_query,
            'is_order_option' => $this->is_order_option,
            'has_price' => $this->has_price,
            'price_type' => $this->price_type,
            'is_unique' => $this->is_unique,
            'use_list' => $this->use_list,
            'values' => $this->detailValues
        ];
    }
}
