<?php

namespace App\Repositories\Projects;

use App\Repositories\Base\BaseRepository;
use Crazy\Helpers\Arr;

class ProjectRepository extends BaseRepository
{
    /**
     * class chứ các phương thức để validate dử liệu
     * @var string $validatorClass 
     */
    protected $validatorClass = 'App\Validators\Projects\ProjectValidator';
    /**
     * @var string $resourceClass
     */
    protected $resourceClass = 'ProjectResource';
    /**
     * @var string $collectionClass
     */
    protected $collectionClass = 'ProjectCollection';



    /**
     * tên class mặt nạ. Thược có tiền tố [tên thư mục] + \ vá hậu tố Mask
     *
     * @var string
     */
    protected $maskClass = 'Projects\ProjectMask';

    /**
     * tên collection mặt nạ
     *
     * @var string
     */
    protected $maskCollectionClass = 'Projects\ProjectCollection';


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
        return \App\Models\Project::class;
    }



    /**
     * thiết lập
     * @return void
     */
    public function init()
    {
        // $this->metadataRepository = new MetadataRepository();
        $this->addDefaultParam('type', 'type', 'project');
        $this->addDefaultValue('type', 'project');
        $this->setJoinable([
            ['leftJoin', 'categories', 'categories.id', '=', 'posts.category_id']
        ])->setSelectable(['posts.*', 'category_name' => 'categories.name']);
        
        $this->registerCacheMethods('getProjectDetail');
    }




    /**
     * @override
     * @param array $data Dữ liệu thông tin người dùng
     * @return array Mảng sau khi dược xử lý
     */
    public function beforeSave($data)
    {
        if (array_key_exists('content', $data) && $data['content']) {
            // tìm các chứa địa chỉ trang chủ thay bằng /
            $search = rtrim(asset('/'), '/') . '/';
            $replace = '/';
            $newContent = str_replace($search, $replace, $data['content']);
            $data['content'] = $newContent;
        }
        return $data;
    }


    public function beforeGetData($args = [])
    {
        if (is_array($args) && count($args)) {
            if ((isset($args['@category']) || array_key_exists('@category', $args))) {
                $cat = $args['@category'];
                if (is_array($cat)) {
                    foreach ($cat as $key => $c) {
                        $this->like('posts.category_map', " $c,");
                    }
                } else {
                    $this->like('posts.category_map', " $cat,");
                }
            }

            

            // sap xep danh sach
            $a = false;
            foreach (['', 'type', 'Type', '_type'] as $k) {
                if (isset($args['@sort' . $k])) {
                    if (!$a) {
                        $this->parseSortBy($args['@sort' . $k]);
                        $a = true;
                    }
                    unset($args['@sort' . $k]);
                }
            }


        }
    }


    /**
     * tạo cây danh mục
     * @param int $category_id
     * @return string ví dụ: " 1, 4, 6,"
     */
    public function makeCategoryMap($category_id)
    {
        $rep = new CategoryRepository();
        $cate = $rep->find($category_id);
        $str='';
        if($cate){
            $str = ' '.implode(', ', $cate->getMap()).',';
        }
        
        return $str;
    }




    /**
     * xử lý order by cho hàm lấy sản phẩm
     *
     * @param array|string $sortBy
     * @return void
     */
    public function parseSortBy($sortBy)
    {
        if (is_array($sortBy)) {
            // truong hop mang toan index la so
            if (Arr::isNumericKeys($sortBy)) {
                foreach ($sortBy as $by) {
                    $this->checkSortBy($by);
                }
            } else {
                foreach ($sortBy as $column => $type) {
                    if (is_numeric($column)) {
                        $this->checkSortBy($type);
                    } else {
                        $this->order_by($column, $type);
                    }
                }
            }
        } else {
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
        if (in_array($sortBy, $this->sortByRules)) {
            $this->orderByRule($sortBy);
        } elseif (array_key_exists($sortBy, $this->sortByRules)) {
            $this->orderByRule($this->sortByRules[$sortBy]);
        } elseif ($sortBy) {
            $this->order_by($sortBy, $type ? $type : 'ASC');
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
        if ($rule == 'rand()') {
            $this->orderByRaw($rule);
        } else {
            $a = explode('-', $rule);
            $this->order_by($a[0], $a[1]);
        }
    }

    
    /**
     * lấy chi tiết bài viết
     *
     * @param array $args
     * @return \App\Models\Post|\App\Masks\Posts\PostMask
     */
    public function getProjectDetail(array $args = [])
    {
        if(!$args) return null;
        $data = $this->with(['author','category','metadatas', 'tags', 'publishComments' => function($query){
            $query->with(['publishChildren' => function($query){
                $query->with(['publishChildren' => function($query){
                    $query->with('publishChildren');
                }]);
            }]);
        }])->first($args);
        return $this->parseDetail($data);
    }
}

