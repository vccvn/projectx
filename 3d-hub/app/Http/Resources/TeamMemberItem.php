<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TeamMemberItem extends JsonResource
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
            'email' => $this->email,
            'avatar' => get_user_avatar($this->avatar),
            'team_id' => $this->team_id,
            'member_id' => $this->member_id,
            'is_leader' => $this->is_leader,
            'job' => $this->job,

        ];
        return $data;
    }
}
