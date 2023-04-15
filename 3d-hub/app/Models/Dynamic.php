<?php

namespace App\Models;

class Dynamic extends Model
{
    public $table = 'dynamics';
    public $fillable = [
        'name', 'slug', 'description', 'content', 'keywords', 'feature_image', 'post_type', 'use_category', 'use_gallery', 'deleted'
    ];


    /**
     * @var array $jsonFields các cột dùng kiểu json
     */
    protected $jsonFields = ['prop_inputs', 'default_fields', 'advance_props', 'form_config'];

    /**
     * ket noi voi bang user_meta
     * @return queryBuilder 
     */
    public function metadatas()
    {
        return $this->hasMany('App\Models\Metadata','ref_id','id')->where('ref', 'dynamic');
    }

    
    /**
     * liên kết tới danh mục
     */
    public function categories()
    {
        return $this->hasMany('App\Models\Category', 'dynamic_id', 'id')->where('type','post');
    }

    /**
     * liên kết tới bài viết
     */
    public function posts()
    {
        return $this->hasMany('App\Models\Post', 'dynamic_id', 'id')->where('type','post');
    }

    
    /**
     * kiểm tra cột có phải json ko
     * @param string $columnName
     * @return boolean
     */
    public function isJson(string $columnName):bool
    {
        return in_array(strtolower($columnName), $this->jsonFields);
    }

    public function getViewUrl()
    {
        return get_dynamic_url($this);
    }


    /**
     * lay du lieu form
     * @return array
     */
    public function toFormData()
    {
        $this->applyMeta();
        $data = $this->toArray();
        if($this->feature_image){
            $data['feature_image'] = $this->getFeatureImage();
        }
        return $data;
    }


        
    /**
     * get avatar url
     * @param boolean $urlencode mã hóa url
     * @return string 
     */
    public function getFeatureImage($urlencode=false)
    {
        if($this->feature_image){
            $feature_image = $this->feature_image;
        }else{
            $feature_image = 'default.png';
        }
        $url = url('static/dynamics/'.$feature_image);
        if($urlencode) return urlencode($url);
        return $url;
    }

    /**
     * xoa avatar
     */
    public function deleteFeatureImage()
    {
        if($this->feature_image){
            if(file_exists($path = public_path('static/dynamics/'.$this->feature_image))){
                unlink($path);
            }
            if(file_exists($path2 = public_path('static/dynamics/thumbs/'.$this->feature_image))){
                unlink($path2);
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
        return $this->deleteFeatureImage();
    }

    /**
     * lấy tên file đính kèm cũ
     */
    public function getAttachFilename()
    {
        return $this->feature_image;
    }

    
    /**
     * xóa dữ liệu
     */
    public function beforeDelete()
    {
        // delete category
        if(count($this->categories)){
            foreach ($this->categories as $category) {
                $category->delete();
            }
        }
        // delete post
        if(count($this->posts)){
            foreach ($this->posts as $post) {
                $post->delete();
            }
        }
        // delete meta
        if(count($this->metadatas)){
            foreach ($this->metadatas as $metadata) {
                $metadata->delete();
            }
        }
        
        // delete image
        $this->deleteFeatureImage();
    }




    

}
