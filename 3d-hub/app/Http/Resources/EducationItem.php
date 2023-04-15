<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class EducationItem extends JsonResource
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
            'has_start_date' => $this->has_start_date,
            'has_finish_date' => $this->has_finish_date,
            'started_at' => $this->started_at,
            'finished_at' => $this->finished_at,

        ];
        return $data;
    }
}
