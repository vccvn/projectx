<?php

namespace App\Repositories\Projects;

use App\Repositories\Categories\CategoryRepository as BaseRepository;
use Crazy\Helpers\Arr;
use Illuminate\Support\Facades\DB;

class CategoryRepository extends BaseRepository
{    
    /**
     * tên class mặt nạ. Thược có tiền tố [tên thư mục] + \ vá hậu tố Mask
     *
     * @var string
     */
    protected $maskClass = 'Categories\CategoryMask';

    /**
     * tên collection mặt nạ
     *
     * @var string
     */
    protected $maskCollectionClass = 'Categories\CategoryCollection';
    /**
     * @var string $system
     */
    protected $system = 'both';

    /**
     * @var boolean $isSetDefault
     */
    public $isSetDefault = false;
    
    

    /**
     * đã kiểm tra hay chưa
     * @var boolean $checked
     */
    protected $checked = false;

    
    protected $joinPosts = false;
    
    /**
     * @var array $sortByRules kiểu sắp xếp
     */
    protected $sortByRules = [
        1 => 'id-DESC',
        2 => 'name-ASC',
        3 => 'name-DESC',
        4 => 'posts',
        5 => 'rand()',
        6 => 'id-ASC'
    ];

    /**
     * thiết lập ban đầu
     */
    public function init()
    {
        $this->addDefaultValue('type','project')->addDefaultParam('type', 'type', 'project');
        $this->setJoinable([
            ['leftJoin', 'posts', 'posts.category_id', '=', 'categories.id'],
            ['leftJoin', 'categories AS parents', 'parents.id', '=', 'categories.parent_id']
            
        ])
        ->setSelectRaw(['COUNT(posts.id) as project_count'])
        ->setSelectable(['categories.*', 'parent_name' => 'parents.name'])
        ->setGroupBy('categories.id');
    }
    

    /**
     * lam gi do truoc khi lay data
     */
    public function beforeGetData($args = [])
    {

        if(isset($args['@count_project'])){
            $this->joinPosts = true;
            $this->leftJoin('posts', function($join){
                $join->on('posts.category_id', '=', 'categories.id');
                $join->on('posts.type', '=', DB::raw("'project'"));

            })->groupBy('categories.id')
            ->select('categories.*')
            ->selectRaw('count(posts.id) as '.str_slug($args['@count_project'], '_'));
        }
        // elseif(isset($args['@count_all'])){
        //     $this->leftJoin('posts', function($join){
        //         $join->on('posts.category_id', '=', 'categories.id');
        //         $join->on('posts.type', '=', 'post');

        //     })->groupBy('categories.id')
        //     ->select('categories.*')
        //     ->selectRaw('count(posts.id) as '.str_slug($args['@count_post'], '_'));
        // }
    }

    public function avaliableCategory()
    {
        return $this;
    }


        /**
     * lấy danh sach danh mục
     *
     * @param array $args
     * @return collection|\App\Masks\Categories\CategoryCollection|[]
     */
    public function getCategories($args = [])
    {
        // tham số nâng cao
        if(isset($args['@advance']) && is_array($args['@advance']) && in_array('project_count', $args['@advance']))
        {
            // nếu cần đếm toàn bộ số sản phẩm
            $this->joinPosts = true;
            $columns = 'categories.*, count(posts.id) as project_count';
            $joinFnc = function($join){
                $join->on('posts.category_map', 'like', DB::raw("concat('% ', categories.id, ',%')"));
                $join->on('posts.type', '=', DB::raw("'project'"));
            };
            $this->where('categories.parent_id', 0);
            $this->selectRaw($columns)->leftJoin('posts', $joinFnc)->groupBy('categories.id')->with(['children' => function ($query) use ($columns, $joinFnc){
                
            }]);
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
        
        return $this->parseCollection($this->get($args));
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
        }elseif(strtolower($sortBy) == 'seller'){
            $this->orderByPostCount($type?$type:'DESC');
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
            
        }elseif($rule == 'posts'){
            $this->orderByPostCount();
        }
        else{
            $a = explode('-', $rule);
            $this->order_by($a[0], $a[1]);
        }
    }

    
    /**
     * sap xep theo ban nhieu
     *
     * @param string $type
     * @return void
     */
    protected function orderByPostCount($type = 'DESC')
    {
        if(strtoupper($type) != 'ASC') $type = 'DESC';
        if(!$this->joinProducts){
            $this->selectRaw('categories.*, count(posts.id) as project_count')
            ->leftJoin('posts', function($join){
                $join->on('posts.category_map', 'like', DB::raw("concat('% ', categories.id, ',%')"));
                $join->on('posts.type', '=', DB::raw("'project'"));
            });
            
        }
        $this->groupBy('categories.id')
            ->orderByRaw('count(posts.id) '.$type);
    }
}