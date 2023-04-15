<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class FileItem extends JsonResource
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
            'privacy' => $this->privacy,
            'ref' => $this->ref,
            'ref_id' => $this->ref_id,
            'filename' => $this->filename,
            'original_filename' => $this->original_filename,
            'sid' => $this->sid,
            'filetype' => $this->filetype,
            'mime' => $this->mime,
            'size' => $this->size,
            'extension' => $this->extension,
            'description' => $this->description,
            'url' => $this->getUrl(),
            'thumbnail' => $this->getThumbnail(),
            
        ];
        
        $size_unit = "KB";
        if($this->size>=1024){
            $data['size'] = round($this->size*10/1024)/10;
            $size_unit = 'MB';
            if($data['size']>=1024){
                $data['size'] = round($data['size']*10/1024)/10;
                $size_unit = 'GB';
                if($data['size']>=1024){
                    $data['size'] = round($data['size']*10/1024)/10;
                    $size_unit = 'TB';
                    
                }
            }
        }
        $data['size_unit'] = $size_unit;


        return $data;
    }
}
