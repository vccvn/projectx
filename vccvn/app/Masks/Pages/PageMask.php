<?php
namespace App\Masks\Pages;

use App\Masks\Comments\CommentCollection;
use App\Masks\Files\FileCollection;
use App\Masks\Files\GalleryCollection;
use App\Masks\Tags\TagCollection;
use App\Masks\Users\AuthorMask;
use App\Models\Page;
use App\Repositories\Pages\PageRepository;
use Crazy\Magic\Mask;

class PageMask extends Mask
{
    public $meta = [];
    // xem thêm ExampleMask
    /**
     * thêm các thiết lập của bạn
     * ví dụ thêm danh sách cho phép truy cập vào thuộc tính hay gọi phương thức trong model
     * hoặc map vs các quan hệ dữ liệu
     *
     * @return void
     */
    protected function init(){
        $this->allow([
            'hasChild', 'getMap', 'getLevel', 'getSonLevel', 'getSeoKeywords',
            'getFullTitle', 'getViewUrl', 'getFeatureImage', 'getThumbnail', 'getImage'
        ]);

        $this->map([
            'parent'           => static::class,
            'children'         => PageCollection::class,
            'author'           => AuthorMask::class,
            'tags'             => TagCollection::class,
            'gallery'          => GalleryCollection::class,
            'files'            => FileCollection::class,
            'media'            => FileCollection::class,
            'comments'         => CommentCollection::class,
            'publishComments'  => CommentCollection::class,

        ]);

    }

    /**
     * lấy data từ model sang mask
     * @param Page $page Tham số không bắt buộc phải khai báo. 
     * Xem thêm ExampleMask
     */
    // public function toMask()
    // {
    //     $data = $this->getAttrData();
    //     // thêm data tại đây.
    //     // Xem thêm ExampleMask
    //     return $data;
        
    // }

    /**
     * sẽ được gọi sau khi thiết lập xong
     *
     * @return void
     */
    protected function onLoaded()
    {
        if ($metadatas = $this->relation('metadatas')) {
            $jsf = $this->model->getJsonFields();
            foreach ($metadatas as $m) {
                if(in_array($m->name, $jsf)){
                    $value = json_decode($m->value, true);
                }else{
                    $value = $m->value;
                }
                
                $this->meta[$m->name] = $value;
            }
        }
        if($this->content) $this->content = do_shortcode($this->content);
    }
    
    /**
     * gán dự liệu meta cho product
     * @return void
     */
    public function applyMeta()
    {
        if(!$this->meta){
            if ($metadatas = $this->relation('metadatas', true)) {
                $jsf = $this->model->getJsonFields();
                foreach ($metadatas as $m) {
                    if(in_array($m->name, $jsf)){
                        $value = json_decode($m->value, true);
                    }else{
                        $value = $m->value;
                    }
                    $this->data[$m->name] = $value;
                    $this->meta[$m->name] = $value;
                }
            }
        }
        else{
            foreach ($this->meta as $key => $value) {
                $this->data[$key] = $value;
                
            }
        }
    }

    
    public function getParent()
    {
        if(!$this->parent_id) return null;
        if ($parent = $this->relation('parent')) {
            if($parent){
                if(!check_model_data('page', $this->parent_id)){
                    set_model_data('page', $this->parent_id, $parent);
                }
                return $parent;
            }
            
        }
        if(!($parent = get_model_data('page', $this->parent_id, false))){
            $parent = $this->relation('parent', true);
            if($parent){
                set_model_data('page', $this->parent_id, $parent);
            }
        }
        return $parent;
    }

    public function getChildren()
    {
        return new PageCollection($this->model->getChildren());
    }

    /**
     * lấy cây thư mục
     * @param array $list
     * @param integer $n
     * @return static[]
     */
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

    
    /**
     * lấy ra các bài viết liên quan
     *
     * @param array|int|str $args
     * @return PageCollection
     */
    public function getRelated($args = null){
        $params = [];
        if(is_numeric($args)){
            $params['@limit'] = $args;
        }elseif(is_array($args)){
            $params = $args;
        }elseif (is_string($args) && $args) {
            $params['@order_by'] = $args;
        }
        // $params['category_id'] = $this->category_id;
        // $params['dynamic_id'] = $this->dynamic_id;
        $params['parent_id'] = $this->parent_id;
        if(!isset($params['@limit'])) $params['limit'] = 12;
        if(!isset($params['@sort']) && !isset($params['@sorttype']) && !isset($params['@sortType']) && !isset($params['@sort_type']) && !isset($params['@order_by']) && !isset($params['@orderBy']) && !isset($params['@orderby'])){
            $params['@sorttype'] = 'rand()';
        }
        /**
         * @var \App\Repositories\Pages\PageRepository
         */
        $repository = app(PageRepository::class)->cache('related-page-'.$this->id, system_setting('cache_data_time', 0), $params)->mode('mask');
        return $repository->where('id', '!=', $this->id)->getData($params);
    }

    // khai báo thêm các hàm khác bên dưới nếu cần
}