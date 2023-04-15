<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ClientResource extends JsonResource
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
            'phone_number' => $this->phone_number,
            'avatar' => $this->avatar,

        ];
        return $data;
    }
}
