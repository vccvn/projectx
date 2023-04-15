<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ContactReplyResource extends JsonResource
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
            'contact_id' => $this->contact_id,
            'user_id' => $this->user_id,
            'message' => $this->message,
            'name' => $this->name,
            'email' => $this->email,
            'time' => $this->calculator_time('created_at')
        ];
        return $data;
    }
}
