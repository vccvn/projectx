<?php

namespace App\Models;

class Category extends Model
{
    public $table = 'categories';
    public $fillable = ['owner_id', 'dynamic_id', 'parent_id', 'name', 'type', 'slug', 'keywords', 'description', 'feature_image', 'deleted'];

    
    public function parent()
    {
        return $this->belongsTo('App\Models\Category','parent_id','id');
    }


    /**
     * lay du lieu form
     * @return array
     */
    public function toFormData()
    {
        $data = $this->toArray();
        // if($this->feature_image){
        //     $data['feature_image'] = $this->getFeatureImage();
        // }
        return $data;
    }


        
    /**
     * get avatar url
     * @param boolean $urlencode mã hóa url
     * @return string 
     */
    public function getFeatureImage($urlencode=false)
    {
        $path = $this->getSecretPath('categories');
        if($this->feature_image && file_exists($p = $path . '/'.$this->feature_image)){
            $feature_image = $p;

        }else{
            $feature_image = 'static/images/default.png';
        }
        $url = url($feature_image);
        if($urlencode) return urlencode($url);
        return $url;
    }

    /**
     * xoa anh
     */
    public function deleteFeatureImage()
    {

        
        if($this->feature_image){
            $fd = $this->getSecretPath('categories/');
            if(file_exists($path = public_path($fd.$this->feature_image))){
                unlink($path);
            }
            if(file_exists($path2 = public_path($fd.'thumbs/'.$this->feature_image))){
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
     * lấy danh mục cha
     */

    public function getParent()
    {
        if(!$this->parent_id) return null;
        if ($this->relationLoaded('parent')) {
            $parent = $this->relations['parent'];
            if($parent){
                if(!check_model_data('category', $this->parent_id)){
                    set_model_data('category', $this->parent_id, $parent);
                }
                return $parent;
            }
            
        }
        if(!($parent = get_model_data('category', $this->parent_id))){
            $parent = $this->parent;
            if($parent){
                set_model_data('category', $this->parent_id, $parent);
            }
        }
        return $parent;
        
    }

    /**
     * lấy danh mục con
     */

    public function getChildren()
    {
        return self::where('parent_id',$this->id)->where('deleted',$this->deleted)->get();
    }
    /**
     * kiểm tra có danh mục con hay ko
     */
    public function hasChild()
    {
        return self::where('parent_id',$this->id)->count();
    }

    /**
     * map category
     */
    public function getMap($list = [], $n = 0)
    {
        if(!is_array($list)) $list = [];
        if(!is_integer($n)) $n = 0;
        array_unshift($list,$this->id);
        $n++;
        if($parent = $this->getParent()){
            return $parent->getMap($list,$n);
        }
        return $list;
    }

    public function getTree($list = [], $n = 0)
    {
        if(!is_array($list)) $list = [];
        if(!is_integer($n)) $n = 0;
        array_unshift($list,$this);
        $n++;
        if($parent = $this->getParent()){
            return $parent->getTree($list,$n);
        }
        return $list;
    }
    public function getLevel($n = 0)
    {
        if(!is_integer($n)) $n = 0;
        $n++;
        if($parent = $this->getParent()){
            return $parent->getLevel($n);
        }
        return $n;
    }


    /**
     * lấy level của các lớp con. ví dụ lớp con có n > 0 danh mục thì sẽ +1 level
     * nếu 1 trong các danh mục lại có một lớp con nữa thì tirp61 tục +1
     * @param int $n start level
     * @return int
     */
    public function getSonLevel($n = 0)
    {
        if(!is_integer($n)) $n = 0;
        // số lớp con lớn nhất
        $max = 0;
        
        if(count($children = $this->getChildren())){
            // nếu có danh mục con tự dộng tăng level lên 1 đơn vị
            $n++;
            $max = $n;
            // duyệt qua các thằng con để lấy level con của từng thằng
            foreach ($children as $child) {
                $k = $child->getSonLevel($n);
                // nếu có thằng nào đó có level con lón hơn max thì gán max bằng nó
                if($k > $max){
                    $max = $k;
                }
            }
            $n = $max;
        }
        return $n;
    }


    /**
     * danh mục con
     */
    public function children()
    {
        return $this->hasMany('App\Models\Category', 'parent_id', 'id');
    }

    /**
     * danh sach post 
     */
    public function posts()
    {
        return $this->hasMany('App\Models\Post','category_id','id');
    }

    public function products()
    {
        return $this->hasMany('App\Models\Product','category_id','id');
    }

    public function childrenDetail()
    {
        $query = $this->children();
        if($this->type == 'product'){
            $query->selectRaw("categories.*, count(
                select products.id from products where products.category_map like concat('% ', categories.id, ',%')
            ) as products_count");
        }
        elseif($this->type == 'post'){
            $query->selectRaw("categories.*, count(
                select posts.id from posts where posts.category_map like concat('% ', categories.id, ',%')
            ) as posts_count");
        }

        return $query;
    }

    /**
     * danh mục con
     */
    public function activeChildren()
    {
        return $this->children()->where('deleted', 0);
    }

    /**
     * danh sach post chưa bị xóa hoặc ẩn
     */
    public function activePosts()
    {
        return $this->posts()->where('deleted', 0);
    }

    public function activeProducts()
    {
        return $this->products()->where('deleted', 0);
    }



    /**
     * danh mục con
     */
    public function hiddenChildren()
    {
        return $this->children()->where('deleted', -1);
    }

    public function hiddenPosts()
    {
        return $this->posts()->where('deleted', -1);
    }

    public function hiddenProducts()
    {
        return $this->products()->where('deleted', -1);
    }




    public function hasPost()
    {
        $model = ($this->type == 'product') ? 'App\Models\Product' : 'App\Models\Post';
        $query = $this->hasMany($model,'category_id','id');
        return $query->count()?true:false;
    }


    public function countProduct()
    {
        return Product::where('category_map', 'like', '% '.$this->id.',%')->where('deleted', $this->deleted)->count();
    }
    public function countPost()
    {
        return Post::where('category_map', 'like', '% '.$this->id.',%')->where('deleted', $this->deleted)->where('type', 'post')->count();
    }
 

        
    public function getFullTitle()
    {
        $title = '';

        $tree = $this->getTree();
        foreach ($tree as $cate) {
            $title = $cate->name . ' | '.$title;
        }
        if($this->type == 'post'){
            if($dynamic = get_model_data('dynamic', $this->dynamic_id)){
                $title .= $dynamic->name;
            }else{
                $title .= "Blog";
            }
        }elseif ($this->type == 'product') {
            $title .= "Sãn phẩm";
        }elseif ($this->type == 'project') {
            $title .= "Dự án";
        }else{
            $title .= "Tin bài";
        }
        return $title;
    }


    /**
     * ẩn danh mục
     */
    public function hidden()
    {
        $this->hiddenPost();
        $this->deleted++;
        $this->save();
    }

    /**
     * ẩn danh mục
     */
    public function visible()
    {
        $this->hiddenPost();
        $this->deleted--;
        $this->save();
    }

    /**
     * ẩn bài viết, sản phẩm
     */
    public function hiddenPost()
    {
        if($this->type == 'post'){
            if(count($this->posts)){
                foreach ($this->posts as $post) {
                    $post->hidden();
                }
            }
        }elseif ($this->type == 'product') {
            if(count($this->products)){
                foreach ($this->products as $product) {
                    $product->hidden();
                }
            }
        }
    }


    /**
     * ẩn danh mục
     */
    public function visiblePost()
    {
        if($this->type == 'post'){
            if(count($this->posts)){
                foreach ($this->posts as $post) {
                    $post->visible();
                }
            }
        }elseif ($this->type == 'product') {
            if(count($this->products)){
                foreach ($this->products as $product) {
                    $product->visible();
                }
            }
        }
    }


    /**
     * thủ tục trước khôi phục
     */
    public function beforeRestore()
    {
        if(count($this->hiddenChildren)){
            foreach ($this->hiddenChildren as $child) {
                $child->visible();
            }
        }
        
    }



    
    /**
     * thủ tục trước khi xoa
     */
    public function beforeMoveToTrash()
    {
        if(count($this->activeChildren)){
            foreach ($this->activeChildren as $child) {
                $child->hidden();
            }
        }
        $this->hiddenPost();
    }

    /**
     * thủ tục trước khi xóa
     */
    public function beforeDelete()
    {
        if(count($this->children)){
            foreach ($this->children as $child) {
                $child->delete();
            }
        }
        if($this->type == 'post'){
            if(count($this->posts)){
                foreach ($this->posts as $post) {
                    $post->delete();
                }
            }
        }elseif ($this->type == 'product') {
            if(count($this->products)){
                foreach ($this->products as $product) {
                    $product->delete();
                }
            }
        }

        $this->deleteFeatureImage();
    }


    /**
     * lay duong danh danh muc
     */
    public function getViewUrl()
    {
        $url = null;
        if($this->type == 'post'){
            $url = get_post_category_url($this);
        }
        elseif($this->type == 'product'){
            $url = get_product_category_url($this);
        }
        elseif($this->type == 'project'){
            $url = get_project_category_url($this);
        }
        return $url;
    }

}
