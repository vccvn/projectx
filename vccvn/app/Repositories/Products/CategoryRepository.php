<?php

namespace App\Repositories\Products;

use App\Repositories\Categories\CategoryRepository as BaseRepository;
use App\Repositories\Orders\OrderRepository;
use Crazy\Helpers\Arr;
use Illuminate\Support\Facades\DB;

class CategoryRepository extends BaseRepository
{
    
    /**
     * class chứ các phương thức để validate dử liệu
     * @var string $validatorClass 
     */
    protected $validatorClass = 'Products\CategoryValidator';

    /**
     * @var string $resource
     */
    protected $resourceClass = 'ProductCategoryResource';

    /**
     * @var string $collectionClass
     */
    protected $collectionClass = 'ProductCategoryCollection';

    
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

    protected $joinProducts = false;
    
    /**
     * @var array $sortByRules kiểu sắp xếp
     */
    protected $sortByRules = [
        1 => 'id-DESC',
        2 => 'name-ASC',
        3 => 'name-DESC',
        4 => 'best-seller',
        5 => 'rand()',
        6 => 'id-ASC',
        
    ];
    /**
     * thiết lập ban đầu
     */
    public function init()
    {
        $this->addDefaultValue('type','product')->addDefaultParam('type', 'type', 'product');
        $this->setJoinable([
            ['leftJoin', 'products', 'products.category_id', '=', 'categories.id']
        ])
        ->setSelectRaw(['COUNT(products.id) as product_count'])
        ->setSelectable(['categories.*'])
        ->setGroupBy('categories.id');

        $this->perPage = 20;
    }

    
    public function beforeGetData($data = [])
    {
        if(isset($data['@withChildren']) && $data['@withChildren'] && !$this->hasActionParam('width', 'children')){
            
            $this->with('children');
        }
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
        if(isset($args['@advance']) && is_array($args['@advance']) && in_array('product_count', $args['@advance']))
        {
            // nếu cần đếm toàn bộ số sản phẩm
            $this->joinProducts = true;
            $columns = 'categories.*, count(products.id) as product_count';
            $joinFnc = function($join){
                $join->on('products.category_map', 'like', DB::raw("concat('% ', categories.id, ',%')"));
            };
            $this->where('parent_id', 0);
            $this->selectRaw($columns)->leftJoin('products', $joinFnc)->groupBy('categories.id')->with(['children' => function ($query) use ($columns, $joinFnc){
                $query->selectRaw($columns)->leftJoin('products', $joinFnc)->groupBy('categories.id')->with(['children' => function ($query) use ($columns, $joinFnc){
                    $query->selectRaw($columns)->leftJoin('products', $joinFnc)->groupBy('categories.id')->with(['children' => function ($query) use ($columns, $joinFnc){
                        $query->selectRaw($columns)->leftJoin('products', $joinFnc)->groupBy('categories.id');
                    }]);
                }]);
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
                    }elseif(strtolower($column) == 'seller') {
                        $this->orderBySeller($type);
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
            $this->orderBySeller($type?$type:'DESC');
        }elseif(count($a = explode('-', $sortBy)) == 2){
            $this->order_by($a[0], $a[1]);
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
            
        }elseif($rule == 'best-seller'){
            $this->orderBySeller();
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
    protected function orderBySeller($type = 'DESC')
    {
        if(strtoupper($type) != 'ASC') $type = 'DESC';
        if(!$this->joinProducts){
            $this->selectRaw('categories.*, count(products.id) as product_count')
            ->leftJoin('products', function($join){
                $join->on('products.category_map', 'like', DB::raw("concat('% ', categories.id, ',%')"));
            });
            
        }
        $this->join('order_items', 'order_items.product_id', '=', 'products.id')
            ->join('orders', 'orders.id', '=', 'order_items.order_id')
            ->where('orders.status', OrderRepository::COMPLETED)
            ->groupBy('categories.id')
            ->orderByRaw('count(products.id) '.$type);
    }

}