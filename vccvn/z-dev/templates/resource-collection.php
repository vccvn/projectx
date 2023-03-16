<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class NAMECollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $data = [];

        if(count($this->collection)){
            foreach ($this->collection as $item) {
                $data[] = new NAMEItem($item);
            }
        }
        return $data;
    }
}
