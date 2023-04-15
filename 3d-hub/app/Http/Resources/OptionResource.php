<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class OptionResource extends JsonResource
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
            'label' => $this->label,
            'slug' => $this->slug,
            'ref' => $this->ref,
            'ref_id' => $this->ref_id,

        ];
        return $data;
    }
}
