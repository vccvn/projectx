<?php

namespace App\Models;

class Dynamic extends Model
{
    public $table = 'dynamics';
    public $fillable = [
        'owner_id', 'name', 'slug', 'description', 'content', 'keywords', 'feature_image', 'post_type', 'use_category', 'use_gallery', 'deleted'
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
     * lấy tên thư mục chứa ảnh thumbnail / feature image
     * @return string tên tư mục
     */
    public function getImageFolder(): string
    {
        return $this->table;
    }



    
    /**
     * get image url
     * @param string $size
     * @return string 
     */
    public function getFeatureImage($size = false)
    {
        $fd = $this->getSecretPath() . '/'. $this->getImageFolder();
        if ($this->feature_image) {
            $feature_image = $this->feature_image;
            if($size){
                if(file_exists($f = $fd . '/' . $size . '/' . $feature_image)) return asset($f);
            }
            if(file_exists($f = $fd . '/' . $feature_image)) return asset($f);
        }
        return asset('static/images/post.png');
    }

    public function getThumbnail()
    {
        if ($this->feature_image) {
            $feature_image = $this->feature_image;
        } else {
            $feature_image = 'default.png';
        }
        $fd = $this->getSecretPath() . '/'. $this->getImageFolder();
        if (file_exists(public_path($fd . '/thumbs/' . $feature_image))) {
            return asset($fd . '/thumbs/' . $feature_image);
        }
        return $this->getImage();
    }

    // lấy hình ảnh theo kích thước

    public function getImage($size = null)
    {
        if (!$size) {
            return $this->getFeatureImage();
        } elseif (in_array($size, ['thumb',  'thumbnail'])) {
            return $this->getThumbnail();
        } elseif (in_array($size, ['social',  '90x90'])) {
            return $this->getFeatureImage($size);
        } else {
            if ($this->feature_image) {
                $feature_image = $this->feature_image;
            } else {
                $feature_image = 'default.png';
            }

            $fd = $this->getSecretPath() . '/'. $this->getImageFolder();
            if(file_exists($p = $fd . '/' . $size . '/' . $feature_image)){
                return asset($p);
            }
            return asset('static/images/default.png');
        }
    }
    /**
     * xoa image
     */
    public function deleteFeatureImage()
    {
        $fd = '/users/' . get_secret_id($this->owner_id) . '/' . $this->getImageFolder();
        if ($this->feature_image && file_exists($path = public_path('static/' . $fd . '/' . $this->feature_image))) {
            unlink($path);
            if (file_exists($p = public_path('static/' . $fd . '/90x90/' . $this->feature_image))) {
                unlink($p);
            }
            if (file_exists($p = public_path('static/' . $fd . '/thumbs/' . $this->feature_image))) {
                unlink($p);
            }if (file_exists($p = public_path('static/' . $fd . '/social/' . $this->feature_image))) {
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
