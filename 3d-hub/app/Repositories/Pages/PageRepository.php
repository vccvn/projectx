<?php

namespace App\Repositories\Pages;

use App\Repositories\Base\BaseRepository;
use App\Repositories\Metadatas\MetadataRepository;
use Crazy\Helpers\Arr;

class PageRepository extends BaseRepository
{
    /**
     * class chứ các phương thức để validate dử liệu
     * @var string $validatorClass 
     */
    protected $validatorClass = 'App\Validators\Pages\PageValidator';
    /**
     * @var string $resource
     */
    protected $resourceClass = 'App\Http\Resources\PageResource';
    /**
     * @var string $collectionClass
     */
    protected $collectionClass = 'App\Http\Resources\PageCollection';
    
    /**
     * tên class mặt nạ. Thược có tiền tố [tên thư mục] + \ vá hậu tố Mask
     *
     * @var string
     */
    protected $maskClass = 'Pages\PageMask';

    /**
     * tên collection mặt nạ
     *
     * @var string
     */
    protected $maskCollectionClass = 'Pages\PageCollection';
    /**
     * @var string $system
     */
    protected $system = 'both';

    /**
     * @var App\Repositories\Metadatas\MetadataRepository $metadataRepository
     */
    public $metadataRepository;

    
    
    public static $sonLevel = 0;

    public static $maxLevel = 2;
    
    protected static $activeID = 0;

    

    public function setActiveID($id = null)
    {
        if($id){
            self::$activeID = $id;
        }
    }

    public function getActiveID()
    {
        return self::$activeID;
    }

    /**
     * get model
     * @return string
     */
    public function getModel()
    {
        return \App\Models\Page::class;
    }

    /**
     * thiết lập
     * @return void
     */
    public function init()
    {
        $this->metadataRepository = new MetadataRepository();
        $this->addDefaultParam('type', 'type', 'page');
        $this->addDefaultValue('type', 'page');
        $this->setJoinable([
            ['leftJoin', 'posts AS pages', 'pages.id', '=', 'posts.parent_id']
        ])->setSelectable(['posts.*', 'parent_title'=>'pages.title']);
    }


    /**
     * @override
     * @param array $data Dữ liệu thông tin người dùng
     * @return array Mảng sau khi dược xử lý
     */
    public function beforeSave($data)
    {
        if(array_key_exists('content', $data) && $data['content']){
            // tìm các chứa địa chỉ trang chủ thay bằng /
            $search = rtrim(asset('/'), '/').'/';
            $replace = '/';
            $newContent = str_replace("\"".$search, "\"".$replace, $data['content']);
            $newContent = str_replace("\'".$search, "\'".$replace, $newContent);
            
            $data['content'] = $newContent;
        }
        return $data;
    }

    
    /**
     * lay danh sach cha
     * @param integer $maxLevel level cao nhat cua 1 danh muc
     * 
     * @return Collection
     */
    public static function getParentSelectOptions($maxLevel = 2, $args = [])
    {
        self::$maxLevel = $maxLevel;
        $list = ["Không"];
        $repository = new static();
        $repository->where('parent_id', '<', 1);
        if(self::$activeID){
            if($page = $repository->find(self::$activeID)){
                self::$sonLevel = $page->getSonLevel();
            }
            
        }
        if($pages = $repository->get(array_merge(['deleted' => 0], $args))){
            $list = self::toParentSelectOptions($pages, $list);
        }
        return $list;
    }
    protected static function toParentSelectOptions($list, $opts = [], $prefix='')
    {
        if(count($list)>0){
            foreach($list as $c){
                $name = $prefix.$c->title;
                $cond = ($c->getLevel() + self::$sonLevel < self::$maxLevel);
                if($c->id != self::$activeID && $cond){
                    
                    if(count($ch = $c->getChildren())>0){
                        
                        $data = self::toParentSelectOptions($ch,[]);
                        $opts[$c->id] = [
                            'label' => $name,
                            'data' => $data
                        ];
                    }else{
                        $opts[$c->id] = $name;
                    }
                }
            }
        }
        return $opts;
    }

    public function getPageOptions(array $args = [])
    {
        $a = [];
        if(count($args)){
            foreach ($args as $key => $value) {
                if(strlen($value)) $a[$key] = $value;
            }
        }
        $list = ["-- Trang --"];
        $this->where('parent_id', '<', 1);
        if($categories = $this->get($a)){
            $list = static::toPageSelectOptions($categories, $list);
        }
        return $list;
    }

    public static function getPageSelectOptions(array $args = [])
    {
        return (new static)->getPageOptions(array_merge(['deleted' => 0], $args));
    }
    protected static function toPageSelectOptions($list, $opts = [])
    {
        if(count($list)>0){
            foreach($list as $c){
                $name = $c->title;
                
                if(count($ch = $c->getChildren())){
                    $data = self::toPageSelectOptions($ch,[]);
                    $opts[$c->id] = [
                        'label' => $name,
                        'data' => $data
                    ];
                    
                    
                    
                }else{
                    $opts[$c->id] = $name;
                }
            }
        }
        return $opts;
    }


}