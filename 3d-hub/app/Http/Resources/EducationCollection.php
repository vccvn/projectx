<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class EducationCollection extends ResourceCollection
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
                $data[] = new EducationItem($item);
            }
        }
        return $data;
    }
}
