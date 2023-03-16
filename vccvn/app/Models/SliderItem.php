<?php

namespace App\Models;

class SliderItem extends Model
{
    public $table = 'slider_items';
    public $fillable = ['owner_id', 'slider_id', 'title', 'sub_title', 'description', 'image', 'link', 'url', 'priority', 'props'];

    public $timestamps = false;
    
    public $casts = [
        'props' => 'json'
    ];
    /**
     * lay du lieu form
     * @return array
     */
    public function toFormData()
    {
        $data = $this->toArray();
        if($this->image){
            $data['image'] = $this->getImage();
        }
        return $data;
    }

    
    
    /**
     * lấy tên thư mục chứa ảnh thumbnail / feature image
     * @return string tên tư mục
     */
    public function getImageFolder() : string
    {
        return 'sliders';
    }


    
    /**
     * get image url
     * @param boolean $urlencode mã hóa url
     * @return string 
     */
    public function getImage($urlencode=false)
    {
        
        if ($this->image) {
            $image = $this->getSecretPath() . '/'. $this->getImageFolder(). '/' . $this->image;
        } else {
            $image = 'static/images/default.png';
        }
        $url = asset($image);
        if($urlencode) return urlencode($url);
        return $url;

    }

    /**
     * xoa image
     */
    public function deleteImage()
    {
        if($this->image && file_exists($path = public_path($this->getSecretPath() . '/'. $this->getImageFolder().'/'.$this->image))){
            unlink($path);
            if(file_exists($p = public_path($this->getSecretPath() . '/'. $this->getImageFolder().'/90x90/'.$this->image))){
                unlink($p);
            }
        }
    }

    
     /**
     * ham xóa file cũ
     * @param int $id
     * 
     * @return boolean
     */
    public function deleteAttachFile()
    {
        return $this->deleteImage();
    }

    /**
     * lấy tên file đính kèm cũ
     */
    public function getAttachFilename()
    {
        return $this->image;
    }

    
    
    /**
     * xóa dữ liệu
     */
    public function beforeDelete()
    {
        // delete image
        $this->deleteImage();
    }


}
