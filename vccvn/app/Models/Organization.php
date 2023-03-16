<?php

namespace App\Models;

class Organization extends Model
{
    public $table = 'organizations';
    public $fillable = ['type', 'name', 'address', 'phone_number', 'email', 'website', 'logo', 'deleted'];

    
    
    /**
     * lay du lieu form
     * @return array
     */
    public function toFormData()
    {
        $data = $this->toArray();
        if($this->logo) $data['logo'] = $this->getLogo();
        return $data;
    }

   

    public function getLogoPath()
    {
        if($this->logo && file_exists( $path = public_path($this->getSecretPath() . '/organizations/'.$this->logo))) return $path;
        return null;
    }

    public function getLogo()
    {
        if($p = $this->getLogoPath()) return asset($p);
        return asset('static/images/default.png');
        
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

    /**
     * lấy tên file đính kèm cũ
     */
    public function getAttachFilename()
    {
        return $this->logo;
    }
}
