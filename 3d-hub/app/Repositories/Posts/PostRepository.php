<?php

namespace App\Repositories\Posts;

use App\Repositories\Base\BaseRepository;
use Crazy\Files\Filemanager;
use Crazy\Files\Image;
use App\Http\Controllers\Traits\ModuleData;
use Crazy\Helpers\Arr;

class PostRepository extends BaseRepository
{
    use ModuleData;
    /**
     * class chứ các phương thức để validate dử liệu
     * @var string $validatorClass 
     */
    protected $validatorClass = 'App\Validators\Posts\PostValidator';

    
    /**
     * tên class mặt nạ. Thược có tiền tố [tên thư mục] + \ vá hậu tố Mask
     *
     * @var string
     */
    protected $maskClass = 'Posts\PostMask';

    /**
     * tên collection mặt nạ
     *
     * @var string
     */
    protected $maskCollectionClass = 'Posts\PostCollection';

    /**
     * @var string $system
     */
    protected $system = 'both';

    /**
     * @var int $dynamic_id id muc noi dung
     */
    protected static $dynamic_id = 0;

    /**
     * đã kiểm tra hay chưa
     * @var boolean $checked
     */
    protected $checked = false;

    protected $filemanager;


    
    /**
     * @var array $sortByRules kiểu sắp xếp
     */
    protected $sortByRules = [
        1 => 'id-DESC',
        2 => 'id-ASC',
        3 => 'title-ASC',
        4 => 'title-DESC',
        5 => 'views-DESC',
        6 => 'rand()'
    ];

    

    /**
     * @var array $defaultSortBy Mảng key value là tên cộ và kiểu sắp xếp
     */
    protected $defaultSortBy = [
        'posts.id' => 'DESC'
    ];

    
    



    /**
     * thiết lập mục nội dung
     * @param int $dynamic_id
     * @return void
     */
    public static function setDynamicID($dynamic_id)
    {
        static::$dynamic_id = $dynamic_id;
    }

    /**
     * lấy đi đã dc set
     * @return int
     */
    public static function getDynamicID()
    {
        return static::$dynamic_id;
    }

    /**
     * get model
     * @return string
     */
    public function getModel()
    {
        return \App\Models\Post::class;
    }


    public function dynamicInit()
    {
        if($this->checked) return true;
        if(in_array('dynamic_id', $this->getFields()) && $dynamic_id = static::getDynamicID()){
            $this->checked = true;
            $this->addDefaultValue('dynamic_id', $dynamic_id)
            ->addDefaultParam('dynamic', 'dynamic_id', $dynamic_id);
        }
    }

    public function init()
    {
        $this->dynamicInit();
        $this->addDefaultParam('type', 'type', 'post');
        $this->addDefaultValue('type', 'post');
        $this->filemanager = new Filemanager();
        $this->registerCacheMethod('getPostDetail');
    }


    public function beforeFillter($request)
    {
        $keywords = strlen($request->search)?$request->search:(
            strlen($request->s)?$request->s:(
                strlen($request->keyword)?$request->keyword:(
                    strlen($request->keywords)?$request->keywords:(
                        strlen($request->tim)?$request->tim:(
                            $request->timkiem
                        )
                    )
                )
            )
        );
        if($keywords){
            $this->where(function($query) use($keywords){
                $t = 'posts.';
                $query->where($t.'title','like',"%$keywords%");
                $query->orWhere($t.'keywords','like',"%$keywords%");
                $query->orWhereRaw("posts.id in (
                    SELECT tag_refs.ref_id FROM tag_refs INNER JOIN tags ON tags.id = tag_refs.tag_id
                    WHERE tag_refs.ref = 'post' AND "
                    ."(tags.name_lower like '%".str_replace("'", "\'", strtolower($keywords))."%' OR tags.slug like '%".str_slug($keywords)."%')
                )");
            });
        }
        
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
     * lấy thông tin form input 
     * @param string $formDir
     * @return array
     */
    public function getFormInputs($formDir = null)
    {
        return array_merge(
            $this->getDefaultActiveInputs($formDir),
            $this->getPropInputs()
        );
    }


    /**
     * get default input
     * @param string $formDir
     * @return array
     */
    public function getDefaultActiveInputs($formDir = null)
    {
        // nếu chưa được set dynamic hoặc không có sẽ trả về mảng rỗng
        if(!($dynamic = get_web_data('dynamic'))) return [];
        $data = [];
        $file = ($formDir??'admin/forms') . '/posts';
        if($storage = $this->getStorageData($file)){
            $inputs = new Arr($storage);
        }else{
            $inputs = $this->filemanager->getJson($file, true);
        }
        
        
        // nếu không có input hoặc default không phải mảng thỉ trả về rỗng
        if(!$inputs || !is_array($default = $dynamic->default_fields)) return [];
        // ưu tiên với title, slug và category_id
        if(in_array('title', $default) && $inputs->title) $data['title'] = $inputs->title;
        if(in_array('slug', $default) && $inputs->slug) {
            $data['slug'] = $inputs->slug;
            if($inputs->custom_slug){
                $data['custom_slug'] = $inputs->custom_slug;
            }
        }
        if($dynamic->use_category && $inputs->category_id) $data['category_id'] = $inputs->category_id;

        // duyệt mảng default để lấy thông tin còn lại
        foreach ($default as $key) {
            if(!array_key_exists($key, $data) && $inputs->{$key}){
                $data[$key] = $inputs->{$key};
            }
        }
        return $data;
    }

    /**
     * lấy các input nang cao
     * @return array
     */
    public function getPropInputs()
    {
        // nếu chưa được set dynamic hoặc không có sẽ trả về mảng rỗng
        if(!($dynamic = get_web_data('dynamic'))) return [];
        if(!is_array($dynamic->prop_inputs)) return [];
        $a = $dynamic->prop_inputs;
        foreach ($a as $key => $inp) {
            if(is_array($inp)){
                foreach ($inp as $prop => $value) {
                    if(preg_match('/(^@\{.*\}$|^@\[.*\]$)/', $value)){
                        $a[$key][$prop] = json_decode(substr($value, 1), true);
                    }
                }
            }
        }
        return $a;
    }

    
    /**
     * upload hình đạ diện cho bài viết
     * @param string $url
     * @param string $filename
     * @param string $folder thư mục lưu file
     * @return string tên file
     */
    public function saveFeatureImageFromUrl($url, $filename=null, $folder='posts'){
        $image = new Image($url);
        if(!$image->check()) return null;
        $name = $filename?$filename : str_slug(md5(microtime())).'.'.$image->getExt();
        $image->resizeAndCrop(800,450);
        if($image->save(public_path('static/'.$folder.'/'.$name))){
            $image->resizeAndCrop(90,90);
            $image->save(public_path('static/'.$folder.'/90x90/'.$name));
            return $name;
        }
        
        return null;
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
            dd($sortBy);
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


    /**
     * lấy chi tiết bài viết
     *
     * @param array $args
     * @return \App\Models\Post|\App\Masks\Posts\PostMask
     */
    public function getPostDetail(array $args = [])
    {
        if(!$args) return null;
        $data = $this->with(['author','category','metadatas', 'publishComments' => function($query){
            $query->with(['publishChildren' => function($query){
                $query->with(['publishChildren' => function($query){
                    $query->with('publishChildren');
                }]);
            }]);
        }])->first($args);
        return $this->parseDetail($data);
    }

    /**
     * lấy options của posts
     *
     * @param array $args
     * @param string $defaultFirst
     * @param string $value_key
     * @param string $text_key
     * @return array
     */
    public function getPostOptions($args = [], $defaultFirst = null, $value_key = 'id', $text_key = 'title')
    {
        return $this->leftJoin('categories', 'categories.id', '=', 'posts.category_id')
                    ->select('posts.id', 'posts.title', 'posts.category_id', 'categories.name as category_name')
                    ->getDataOptions($args, $defaultFirst, $value_key, $text_key);
    }
}