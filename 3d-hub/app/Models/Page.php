<?php

namespace App\Models;

class Page extends BasePost
{
    /**
     * dây là model đã diện cho post
     */
    protected $ref = 'page';

    public $fillable = [
        'author_id', 'parent_id', 'type', 'title', 'slug', 'keywords', 'description', 'content', 
        'feature_image', 'views', 'privacy', 'deleted'
    ];


    public function getViewUrl()
    {
        return get_page_url($this);
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
                if(!check_model_data('page', $this->parent_id)){
                    set_model_data('page', $this->parent_id, $parent);
                }
                return $parent;
            }
            
        }
        if(!($parent = get_model_data('page', $this->parent_id))){
            $parent = $this->parent;
            if($parent){
                set_model_data('page', $this->parent_id, $parent);
            }
        }
        return $parent;
        
    }


    /**
     * lấy danh mục con
     */

    public function getChildren($deleted = null)
    {
        $query = self::where('parent_id',$this->id);
        if(!is_null($deleted)){
            $query->where('deleted',$deleted); 
        }
        return $query->get();
    }
    /**
     * kiểm tra có danh mục con hay ko
     */
    public function hasChild()
    {
        return self::where('parent_id',$this->id)->count();
    }


    /**
     * làm gì đó trước khi chuyển vào thùng rác
     * @return void
     */
    public function beforeMoveToTrash()
    {
        if(count($children = $this->getChildren(0))){
            foreach ($children as $child) {
                $child->deleted = 2;
                $child->save();
            }
        }
    }
    /**
     * khoi phuc cac trang con
     * @return void
     */
    public function afterRestore()
    {
        if(count($children = $this->getChildren(2))){
            foreach ($children as $child) {
                $child->deleted = 0;
                $child->save();
            }
        }
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


    public function getSonLevel($n = 0)
    {
        if(!is_integer($n)) $n = 0;
        $max = 0;
        if(count($children = $this->getChildren())){
            $n++;
            $max = $n;
            foreach ($children as $child) {
                $k = $child->getSonLevel($n);
                if($k > $max){
                    $max = $k;
                }
            }
            $n = $max;
        }
        return $n;
    }


    public function getFullTitle()
    {
        $title = '';

        $tree = $this->getTree();
        foreach ($tree as $cate) {
            $title = $cate->title . ' | '.$title;
        }

        return trim(trim(trim($title), '|'));
    }


}
