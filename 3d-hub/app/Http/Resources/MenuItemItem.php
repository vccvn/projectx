<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class MenuItemItem extends JsonResource
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
            'menu_id' => $this->menu_id,
            'parent_id' => $this->parent_id,
            'type' => $this->type,
            'ref' => $this->ref,
            'ref_id' => $this->ref_id,
            'sub_type' => $this->sub_type,
            'props' => $this->props,
            'children' => count($this->children)?(new MenuItemCollection($this->children)):[]

        ];
        return $data;
    }
}
