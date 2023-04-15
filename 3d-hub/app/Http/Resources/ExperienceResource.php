<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ExperienceResource extends JsonResource
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

            'profile_id' => $this->profile_id,
            'org_id' => $this->org_id,
            'type' => $this->type,
            'title' => $this->title,
            'description' => $this->description,
            'started_at' => $this->started_at,
            'finished_at' => $this->finished_at,

        ];
        return $data;
    }
}
