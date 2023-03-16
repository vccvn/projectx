<?php

namespace App\Models;

class Brand extends Model
{
    public $table = 'brands';
    public $fillable = ['owner_id', 'name', 'slug', 'logo', 'website'];

    public $timestamps = false;

    

    public function getLogoPath()
    {
        if($this->logo && file_exists( $path = public_path('static/brands/'.$this->logo))) return $path;
        return null;
    }

    public function getLogo()
    {
        if($this->getLogoPath()) return asset('static/brands/'.$this->logo);
        return asset('static/brands/default.png');
        
    }


    public function beforeDelete()
    {
        $this->deleteAttachFile();
    }

    
     /**
     * ham xóa file cũ
     * @param int $id
     * 
     * @return boolean
     */
    public function deleteAttachFile()
    {
        if($p = $this->getLogoPath()){
            unlink($p);
            return true;
        }
        return false;
    }

}
