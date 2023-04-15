<?php
namespace App\Masks\Categories;

use App\Masks\Posts\PostCollection;
use App\Masks\Products\ProductCollection;
use App\Masks\Projects\ProjectCollection;
use App\Models\Category;
use Crazy\Magic\Mask;

class CategoryMask extends Mask{

    protected function init(){
        // khai báo các hàm được cho phép gọi trực tiếp 
        $this->allow([
            'hasChild', 'getMap', 'getLevel', 'getSonLevel', 'hasPost', 'countProduct', 'countPost',
            'getFullTitle', 'getViewUrl', // 'getFeatureImage', 
            'getFeatureImage' => 'getThumbnail',
            'getParent' => 'getCategory',
            'parent' => 'category'
        ]);
        $this->map([
            'parent'         => static::class,
            'posts'          => PostCollection::class,
            'products'       => ProductCollection::class,
            'projects'       => ProjectCollection::class,
            'children'       => CategoryCollection::class,
            'activeChildren' => CategoryCollection::class,
            'activePosts'    => PostCollection::class,
            'activeProducts' => ProductCollection::class
        ]);
    }
    /**
     * lấy data từ model sang mask
     * @param Category $category Tham số không bặt buộc phải khai báo. 
     * Xem thêm ExampleMask
     */
    // public function toMask()
    // {
    //     $data = $this->getAttrData();
    //     // thêm data tại đây.
    //     // Xem thêm ExampleMask
    //     return $data;
        
    // }

    protected function onLoaded()
    {
        if(!check_model_data('category', $this->id)){
            set_model_data('category', $this->id, $this);
        }
        $this->title = $this->name;
    }
    public function getParent()
    {
        if(!$this->parent_id) return null;
        if ($parent = $this->relation('parent')) {
            if($parent){
                if(!check_model_data('category', $this->parent_id)){
                    set_model_data('category', $this->parent_id, $parent);
                }
                return $parent;
            }
            
        }
        if(!($parent = get_model_data('category', $this->parent_id, false))){
            $parent = $this->relation('parent', true);
            if($parent){
                set_model_data('category', $this->parent_id, $parent);
            }
        }
        return $parent;
    }

    public function getChildren()
    {
        return new CategoryCollection($this->model->getChildren());
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


    // khai báo thêm các hàm khác bên dưới nếu cần
}