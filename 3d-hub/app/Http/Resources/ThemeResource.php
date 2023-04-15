<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ThemeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $types = ['multi-page' => 'Multi Page', 'spa' => 'SPA'];
        $refs = get_system_config('web_type_list');
        $owner = $this->owner;
        
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
            'owner' => [
                'name' => optional($this->owner)->name,
                'email' => optional($this->owner)->email,
                'avatar' => get_user_avatar(optional($this->owner)->avatar)
            ],
            'type_text' => $types[$this->type]??$this->type,
            'ref_text' => $refs[$this->ref]??$this->ref,
            
            'gallery' => $this->getGallery()
            
        ];
        return $data;
    }
}
