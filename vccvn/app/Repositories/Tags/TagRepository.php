<?php

namespace App\Repositories\Tags;

use App\Repositories\Base\BaseRepository;

class TagRepository extends BaseRepository
{
     
    /**
     * @var array $sortByRules kiểu sắp xếp
     */
    protected $sortByRules = [
        1 => 'id-DESC',
        2 => 'name-ASC',
        3 => 'name-DESC',
        4 => 'rand()'
    ];

    /**
     * phương thức sap91 xếp
     *
     * @var array [type => Method]
     */
    protected $sortByMethods = [
        'popular' => 'sortByPopular'
    ];

    /**
     * get model
     * @return string
     */
    public function getModel()
    {
        return \App\Models\Tag::class;
    }

    /**
     * thiết lập mặc định
     */
    public function init()
    {
        $this->setSearchable(['name', 'name_lower', 'keyword'])
            ->setJoinable([
                ['leftJoin', 'tag_refs', 'tag_refs.tag_id', '=', 'tags.id']
            ])
            ->setSelectable(['id' => 'tags.id', 'name' => 'tags.name', 'keyword' => 'tags.keyword', 'slug' => 'tags.slug'])
            ->setSelectRaw(['COUNT(tag_refs.tag_id) tag_count'])
            ->setGroupBy('tags.id');
    }




    /**
     * tạo thẻ mới
     * @param string $name
     * @return null|App\Models\Tag
     */
    public function createTag($name)
    {
        $a = null;
        $keyword = vnclean($name);
        if(!$keyword) return null;
        $name_lower = vntolower($name);
        $slug = str_slug($keyword);
        if($ta = $this->findBy('name_lower',$name_lower)){
            //$a = $ta;
        }elseif($m = $this->save(compact('keyword','name_lower','name', 'slug'))){
            $a = $m;
        }
        return $a;
    }

    /**
     * cập nhật thẻ
     * @param int $id
     * @param string $name
     * 
     * @return null|App\Models\Tag
     */
    public function updateTag($id, $name)
    {
        if(!$this->find($id)) return false;
        $a = null;
        $keyword = vnclean($name);
        $name_lower = vntolower($name);
        $slug = str_slug($keyword);
        if($m = $this->save(compact('keyword','name_lower','name', 'slug'),$id)){
            $a = $m;
        }
        return $a;
    }

    /**
     * tạo nhiều thẻ
     * @param string $tags danh sách thẻ ngăn cách nhau bằng dấu phẩy (,)
     * @return array
     */
    public function createTags($tags)
    {
        
        $a = [];
        if($tags){
            if(count($tag_list = explode(',', $tags))){
                foreach ($tag_list as $t) {
                    if($ta = $this->findBy('name_lower',trim(vntolower($t)))){
                        $a[] = $ta;
                    }elseif($tag = $this->createTag($t)){
                        $a[] = $tag;
                    }
                }
            }
        }

        return $a;
    }

    /**
     * tạo nhiều thẻ
     * @param string $tags danh sách thẻ ngăn cách nhau bằng dấu phẩy (,)
     * @return array
     */
    public function createTagIfNotExists($tags)
    {
        
        $a = [];
        if($tags){
            if(count($tag_list = explode(',', $tags))){
                foreach ($tag_list as $t) {
                    if($tag = $this->createTag($t)){
                        $a[] = $tag;
                    }
                }
            }
        }

        return $a;
    }


    /**
     * ref Query
     */
    public function refQuery()
    {
        return $this->setWhereable([
            'ref'          => 'tag_refs.ref',
            'ref_id'       => 'tag_refs.ref_id',
            'id'           => 'tags.id',
        ])
        ->join('tag_refs', 'tags.id', '=', 'tag_refs.tag_id')
        ->groupBy('tags.id')
        ->select('tags.id', 'tags.name','tags.keyword', 'tags.slug');
    }

    /**
     * lấy tag có ref hoặc ko
     */
    public function getTags(array $args = [])
    {

        return $this->get($args);
    }

    /**
     * lấy tag có ref hoặc ko
     * 
     * @param string $ref
     * @param integer $ref_id
     * @param array $args
     * @return array
     */
    public function getRefTags(string $ref = 'post', $ref_id = 0, array $args = [])
    {
        $b = [];
        if($ref){
            $b['ref'] = $ref;
            if($ref_id){
                $b['ref_id'] = $ref_id;
            }
        }
        $args = array_merge($b, $args);
        return $this->refQuery()->get($args);
    }

    

    public function beforeGetData($args = []){
        
        // sap xep danh sach
        $a = false;
        foreach (['', 'type', 'Type', '_type'] as $k) {
            if(isset($args['@sort'.$k])){
                if(!$a){
                    $this->parseSortBy($args['@sort'.$k]);
                    $a = true;
                }
                unset($args['@sort'.$k]);
            }    
        }
        
    }


    public function sortByPopular($type = null)
    {
        $this->withCount('refs');
        $this->orderByRaw('refs_count DESC');
    }
    

}