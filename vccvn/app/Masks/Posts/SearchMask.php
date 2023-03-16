<?php
namespace App\Masks\Posts;

use App\Masks\Categories\CategoryMask;
use App\Masks\Comments\CommentCollection;
use App\Masks\Dynamics\DynamicMask;
use App\Masks\Files\FileCollection;
use App\Masks\Files\GalleryCollection;
use App\Masks\Metadatas\MetadataCollection;
use App\Masks\Tags\TagCollection;
use App\Masks\Users\AuthorMask;
use App\Models\BasePost;
use App\Repositories\Posts\SearchRepository;
use Crazy\Magic\Mask;

class SearchMask extends Mask
{

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
            'getViewUrl', 'getFullTitle', 'getSeoKeywords', 'getFeatureImage', 'getThumbnail', 'getCategory', 'getAuthor',
        ]);
        $this->map([
            'metadatas'        => MetadataCollection::class,
            'category'         => CategoryMask::class,
            'author'           => AuthorMask::class,
            'tags'             => TagCollection::class,
            'dynamic'          => DynamicMask::class,
            'gallery'          => GalleryCollection::class,
            'files'            => FileCollection::class,
            'media'            => FileCollection::class,
            'comments'         => CommentCollection::class,
            'publishComments'  => CommentCollection::class,
        ]);
        
    }

    /**
     * lấy data từ model sang mask
     * @param BasePost $basePost Tham số không bắt buộc phải khai báo. 
     * Xem thêm ExampleMask
     */
    // public function toMask()
    // {
    //     $data = $this->getAttrData();
    //     // thêm data tại đây.
    //     // Xem thêm ExampleMask
    //     return $data;
        
    // }
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

    
    /**
     * lấy ra các bài viết liên quan
     *
     * @param array|int|str $args
     * @return \App\Masks\MaskCollection
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
        $params['category_id'] = $this->category_id;
        $params['dynamic_id'] = $this->dynamic_id;
        $params['parent_id'] = $this->parent_id;
        if(!isset($params['@limit'])) $params['limit'] = 12;
        /**
         * @var \App\Repositories\Posts\SearchRepository
         */
        $repository = app(SearchRepository::class)->cache('related-result-'.$this->id, system_setting('cache_data_time', 0), $params)->mode('mask');
        return $repository->where('id', '!=', $this->id)->getData($params);
    }

    
    // khai báo thêm các hàm khác bên dưới nếu cần

    
    /**
     * lấy thông tin loai nội dung hoặc kiểm tra
     *
     * @param string $type
     * @return bool|string
     */
    public function contentType($type = null)
    {
        if(!$type) return $this->content_type;
        if(!is_string($type)) return false;
        $t = strtolower($type);
        if(in_array($t, ['video_embed', 'embed', 'videoembed']) && $this->content_type == 'video_embed') return true;
        return $t == strtolower($this->content_type);
    }

    public function isContentType($type = null)
    {
        if(!$type) return false;
        return $this->contentType($type);
    }
}