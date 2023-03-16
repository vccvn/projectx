<?php

namespace App\Repositories\Posts;

use App\Repositories\Base\BaseRepository;
use Crazy\Helpers\Arr;

class SearchRepository extends BaseRepository
{
    /**
     * @var string $resourceClass
     */
    protected $resourceClass = 'BasePostResource';
    /**
     * @var string $collectionClass
     */
    protected $collectionClass = 'BasePostCollection';

    
    /**
     * tên class mặt nạ. Thược có tiền tố [tên thư mục] + \ vá hậu tố Mask
     *
     * @var string
     */
    protected $maskClass = 'Posts\SearchMask';

    /**
     * tên collection mặt nạ
     *
     * @var string
     */
    protected $maskCollectionClass = 'Posts\SearchCollection';
    /**
     * @var array $sortByRules kiểu sắp xếp
     */
    protected $sortByRules = [
        1 => 'id-DESC',
        2 => 'name-ASC',
        3 => 'name-DESC',
        4 => 'views-DESC',
        5 => 'rand()'
    ];
    /**
     * get model
     * @return string
     */
    public function getModel()
    {
        return \App\Models\BasePost::class;
    }

    public function init()
    {
        $this->registerCacheMethod('search');
    }

    /**
     * tìm kiếm các dạng biến thể của bài viết
     *
     * @param \Iluminate\Http\Request $request
     * @param string $keywords
     * @param string $ref
     * @param array $args
     * @return \App\Masks\Posts\SearchCollection|[]
     */
    public function search($request, $keywords = null, $ref = null, $args = [])
    {
        if(!in_array($ref.'', ['post','page', 'project'])) $ref=null;
        // nếu có ref và ref khác tất cả
        if($request->ref && !in_array($r = strtolower($request->ref), ['*', 'all'])){
            // nếu không trong nhóm post
            if(!in_array($r.'', ['post','page', 'project'])){
                if($dynamic = get_dynamic(['slug' => $request->ref])){
                    $args['type'] = 'post';
                    $args['dynamic_id'] = $dynamic->id;
                }else{
                    $args['dynamic_id'] = -1000;
                }
            }
            else{
                $args['type'] = $r;
                $ref = $request->ref;
            }
        }

        $s = $keywords;
        
        $t = 'posts.';
        $this->selectRaw('posts.*');
        $this->where(function($query) use($s, $t, $ref){
            $query->where($t.'title','like',"%$s%");
            $query->orWhere($t.'keywords','like',"%$s%");
            $query->orWhereRaw("posts.id in (
                SELECT tag_refs.ref_id FROM tag_refs INNER JOIN tags ON tags.id = tag_refs.tag_id
                WHERE "
                .($ref?"tag_refs.ref = '$ref'":"tag_refs.ref IN ('post','page', 'project')")." AND "
                ."(tags.name_lower like '%".str_replace("'", "\'", strtolower($s))."%' OR tags.slug like '%".str_slug($s)."%')
            )");
        });
        $this->prepareFilter($request);
        $this->buildJoin();
        $this->buildSelect();

        $args = $this->parsePaginateParam($request, $args);
        // lấy kết qua
        // dd($args);
        $args['privacy'] = 'public';
        
        if(!$this->hasSortby && !isset($args['@orderBy']) && !isset($args['@order_by']) && $this->defaultSortBy){
            $args['@order_by'] = $this->defaultSortBy;
        }

        $this->with(['author', 'dynamic', 'category']);
        $results = $this->get($args);
        // nếu tham số có yêu cau paginate
        if($this->hasPaginateParam){
            $query_string = parse_query_string(null,$request->all(), 'page');
            if($query_string){
                // them query string vào url
                $results->withPath('?'.$query_string);
            }
            
        }
        return $this->parseCollection($results);
    }


    

    public function beforeGetData($args = []){
        if(is_array($args) && (isset($args['@category']) || array_key_exists('@category', $args))){
            $cat = $args['@category'];
            if(is_array($cat)){
                foreach ($cat as $key => $c) {
                    $this->like('posts.category_map', " $c,");
                }
            }else{
                $this->like('posts.category_map', " $cat,");
            }
        }

        
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

    

    
    /**
     * xử lý order by cho hàm lấy sản phẩm
     *
     * @param array|string $sortBy
     * @return void
     */
    public function parseSortBy($sortBy)
    {
        if(is_array($sortBy)){
            // truong hop mang toan index la so
            if(Arr::isNumericKeys($sortBy)){
                foreach ($sortBy as $by) {
                    $this->checkSortBy($by);
                }
            }else{
                foreach ($sortBy as $column => $type) {
                    if(is_numeric($column)){
                        $this->checkSortBy($type);
                    }elseif(strtolower($column) == 'posts') {
                        $this->orderByPostCount($type);
                    }else{
                        $this->order_by($column, $type);
                    }
                }
            }
        }else{
            $this->checkSortBy($sortBy);
        }
    }


    /**
     * kiểm tra tính hợp lệ của tham sớ truyền vào
     *
     * @param string $sortBy
     * @param string $type
     * @return void
     */
    protected function checkSortBy($sortBy = null, $type = null)
    {
        if(in_array($sortBy, $this->sortByRules)){
            $this->orderByRule($sortBy);
        }elseif (array_key_exists($sortBy, $this->sortByRules)) {
            $this->orderByRule($this->sortByRules[$sortBy]);
        }elseif($sortBy){
            $this->order_by($sortBy, $type?$type:'ASC');
        }
    }


    /**
     * order by rule
     *
     * @param string $rule
     * @return void
     */
    protected function orderByRule($rule)
    {
        if($rule == 'rand()'){
            $this->orderByRaw($rule);
            
        }
        else{
            $a = explode('-', $rule);
            $this->order_by($a[0], $a[1]);
        }
    }


}