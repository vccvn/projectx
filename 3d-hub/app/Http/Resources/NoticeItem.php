<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class NoticeItem extends JsonResource
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
            'title' => $this->title,
            'message' => $this->message,
            'time' => $this->calculator_time('created_at'),
            'created_at' => $this->created_at.'',
            'updated_at' => $this->updated_at.'',
        ];

        return $data;
    }
}
