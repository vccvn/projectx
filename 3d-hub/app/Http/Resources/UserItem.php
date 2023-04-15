<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserItem extends JsonResource
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
            'email' => $this->email,
            'username' => $this->username,
            'email_verified_at' => $this->email_verified_at,
            'password' => $this->password,
            'phone_number' => $this->phone_number,
            'facebook_id' => $this->facebook_id,
            'google_id' => $this->google_id,
            'type' => $this->type,
            'avatar' => $this->avatar,
            'status' => $this->status,
            'deleted' => $this->deleted,

        ];
        return $data;
    }
}
