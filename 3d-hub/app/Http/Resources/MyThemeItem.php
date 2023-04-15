<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class MyThemeItem extends JsonResource
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
            'name' => $this->name,
            'slug' => $this->slug,
            'type' => $this->type,
            'ref' => $this->ref,
            'version' => $this->version,
            'description' => $this->description,
            'privacy' => $this->privacy,
            'image' => $this->getImage(),
            'available' => $this->available,
            'edit_url' => (!$this->available || $this->privacy=='protected')?route('admin.themes.update', ['id' => $this->id]):'javascript:void(0);'
        ];

        return $data;
    }
}
