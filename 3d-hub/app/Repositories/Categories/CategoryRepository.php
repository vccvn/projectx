<?php

namespace App\Repositories\Categories;

use App\Repositories\Base\BaseRepository;

class CategoryRepository extends BaseRepository
{
    
    /**
     * class chứ các phương thức để validate dử liệu
     * @var string $validatorClass 
     */
    protected $validatorClass = 'App\Validators\Categories\CategoryValidator';

    /**
     * @var string $resource
     */
    protected $resourceClass = 'App\Http\Resources\CategoryResource';

    /**
     * @var string $collectionClass
     */
    protected $collectionClass = 'App\Http\Resources\CategoryCollection';

    /**
     * @var string $system
     */
    protected $system = 'both';


    /**
     * @var int $dynamic_id id muc noi dung
     */
    protected static $dynamic_id = 0;

    
    
    public static $sonLevel = 0;

    public static $maxLevel = 4;
    
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
        return \App\Models\Category::class;
    }

    /**
     * lấy thông tin max level
     * @return int
     */
    public function getMaxLevel()
    {
        return static::$maxLevel;
    }
    
    /**
     * lấy level con của một danh muc
     * @param int $id id vủa danh mục
     * @return int
     */
    public function getSonLevel($id)
    {
        if($cate = $this->findBy('id', $id)){
            return $cate->getSonLevel();
        }
        return 0;
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
            if($cate = $repository->find(self::$activeID)){
                self::$sonLevel = $cate->getSonLevel();
            }
            
        }
        if($categories = $repository->get(array_merge(['deleted' => 0], $args))){
            $list = self::toParentSelectOptions($categories, $list);
        }
        return $list;
    }
    protected static function toParentSelectOptions($list, $opts = [], $prefix='')
    {
        if(count($list)>0){
            foreach($list as $c){
                $name = $prefix.$c->name;
                $cond = ($c->getLevel() + self::$sonLevel < self::$maxLevel);
                if($c->id != self::$activeID && $cond && !$c->hasPost()){
                    
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


    public function getCategoryOptions(array $args = [])
    {
        $a = [];
        if(count($args)){
            foreach ($args as $key => $value) {
                if(strlen($value)) $a[$key] = $value;
            }
        }
        $list = ["-- Danh mục --"];
        $this->where('parent_id', '<', 1);
        if($categories = $this->get($a)){
            $list = static::toCategorySelectOptions($categories, $list);
        }
        return $list;
    }

    public static function getCategorySelectOptions(array $args = [])
    {
        return (new static)->getCategoryOptions(array_merge(['deleted' => 0], $args));
    }
    protected static function toCategorySelectOptions($list, $opts = [])
    {
        if(count($list)>0){
            foreach($list as $c){
                $name = $c->name;
                if(count($ch = $c->getChildren())){
                    $data = self::toCategorySelectOptions($ch,[]);
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