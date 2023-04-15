<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SliderResource extends JsonResource
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
            'owner_id' => $this->owner_id,
            'name' => $this->name,
            'slug' => $this->slug,
            'description' => $this->description,
            'is_main' => $this->is_main,
            'priority' => $this->priority,
            'crop' => $this->crop,
            'width' => $this->width,
            'height' => $this->height,
            'deleted' => $this->deleted,

        ];
        return $data;
    }
}
