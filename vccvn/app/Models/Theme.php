<?php

namespace App\Models;

use Crazy\Files\Filemanager;

class Theme extends Model
{
    public $table = 'themes';
    public $fillable = ['owner_id', 'secret_id', 'name', 'slug', 'view_type', 'mobile_version', 'web_types', 'version', 'description','image', 'privacy', 'zip', 'available', 'deleted'];

    
    /**
     * @var array $jsonFields các cột dùng kiểu json
     */
    protected $jsonFields = ['components', 'options', 'areas', 'layout', 'menus', 'package'];

    // public $resources = [];
    /**
     * ket noi voi bang meta
     */
    public function metadatas()
    {
        return $this->hasMany('App\Models\Metadata','ref_id','id')->where('ref', 'theme');
    }

    public function gallery()
    {
        return $this->hasMany('App\Models\File', 'ref_id', 'id')->where('ref', 'theme');
    }
    
    public function components()
    {
        return $this->hasMany('App\Models\Component', 'ref_id', 'id')->where('ref', 'theme');
    }

    public function areas()
    {
        return $this->hasMany('App\Models\HtmlArea', 'ref_id', 'id')->where('ref', 'theme');
    }

    public function themeOptions()
    {
        return $this->hasMany('App\Models\Option', 'ref_id', 'id')->where('ref', 'theme');
    }
    

    public function getGallery()
    {
        $data = [];
        if(count($this->gallery)){
            foreach ($this->gallery as $file) {
                $data[] = $file->getUrl();
            }
        }
        return $data;
    }

    public function owner()
    {
        return $this->belongsTo('App\Models\User', 'owner_id', 'id')->select('id','name', 'avatar', 'email');
    }
    


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
        $data['web_types'] = array_map('trim', explode(',', $this->web_types));
        
        return $data;
    }

    /**
     * lay file path
     */
    public function getZipPath()
    {
        if($this->zip && file_exists($path = base_path('themes/zip/'.$this->zip))) return $path;
        return null;
    }

    

    /**
     * lấy tên thư mục chứa ảnh thumbnail / feature image
     * @return string tên tư mục
     */
    public function getImageFolder() : string
    {
        return 'themes';
    }


    
    /**
     * get image url
     * @param boolean $urlencode mã hóa url
     * @return string 
     */
    public function getImage($urlencode=false)
    {
        if($this->image){
            $image = $this->image;
        }else{
            $image = 'default.png';
        }
        $fd = $this->getImageFolder();
        $url = asset('static/'.$fd.'/'.$image);
        if($urlencode) return urlencode($url);
        return $url;
    }

    /**
     * xoa image
     */
    public function deleteImage()
    {
        $fd = $this->getImageFolder();
        if($this->image && file_exists($path = public_path('static/'.$fd.'/'.$this->image))){
            unlink($path);
            if(file_exists($p = public_path('static/'.$fd.'/90x90/'.$this->image))){
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
        // deletegallery
        if(count($this->gallery)){
            foreach ($this->gallery as $gallery) {
                $gallery->delete();
            }
        }
        
        // delete image
        $this->deleteImage();

        if (count($this->areas)) {
            foreach ($this->areas as $key => $area) {
                $area->delete();
            }
        }
        
        if (count($this->themeOptions)) {
            foreach ($this->themeOptions as $key => $themeOption) {
                $themeOption->delete();
            }
        }
        if (count($this->components)) {
            foreach ($this->components as $key => $component) {
                $component->delete();
            }
        }
        if(is_dir($p = asset('static/assets/' . $this->slug))){
            $filemanager = new Filemanager($p);
            $filemanager->delete($p);
        }
        
    }

}
