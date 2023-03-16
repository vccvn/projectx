<?php
namespace App\Masks\Projects;

use App\Masks\Categories\CategoryMask;
use App\Masks\Comments\CommentCollection;
use App\Masks\Files\FileCollection;
use App\Masks\Files\GalleryCollection;
use App\Masks\Metadatas\MetadataCollection;
use App\Masks\Tags\TagCollection;
use App\Masks\Users\AuthorMask;
use App\Models\Project;
use App\Repositories\Clients\ClientRepository;
use App\Repositories\Projects\ProjectRepository;
use Crazy\Magic\Mask;

class ProjectMask extends Mask
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
            'getViewUrl', 'getFullTitle', 'getSeoKeywords', 'getFeatureImage', 'getThumbnail', 
            'getCategory', 'getAuthor', 'getVideo', 'hasGallery', 'getImage'
        ]);

        $this->map([
            'metadatas'        => MetadataCollection::class,
            'category'         => CategoryMask::class,
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
     * @param Project $project Tham số không bắt buộc phải khai báo. 
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
        if(!isset($params['@sort']) && !isset($params['@sorttype']) && !isset($params['@sortType']) && !isset($params['@sort_type']) && !isset($params['@order_by']) && !isset($params['@orderBy']) && !isset($params['@orderby'])){
            $params['@sorttype'] = 'rand()';
        }
        /**
         * @var \App\Repositories\Projects\ProjectRepository
         */
        $repository = app(ProjectRepository::class)->cache('related-project-'.$this->id, system_setting()->cache_data_time, $params)->mode('mask');
        return $repository->where('id', '!=', $this->id)->getData($params);
    }

    public function getClient()
    {
        if($this->client_id && $client = app(ClientRepository::class)->mode('mask')->detail($this->client_id)){
            return $client;
        }
        return null;
    }
}