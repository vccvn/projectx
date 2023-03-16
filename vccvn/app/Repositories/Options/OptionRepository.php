<?php

namespace App\Repositories\Options;

use App\Repositories\Base\BaseRepository;
use Illuminate\Support\Str;
use Crazy\Helpers\Arr;
use Crazy\Files\Filemanager;

class OptionRepository extends BaseRepository
{
    /**
     * trinh quan ly file
     *
     * @var \Crazy\Files\Filemanager
     */
    public $filemanager;
    /**
     * option group
     *
     * @var \App\Repositories\Options\GroupRepository
     */
    public $groupRepository;
    /**
     * option data
     *
     * @var \App\Repositories\Options\DataRepository
     */
    public $dataRepository;
    
    /**
     * class chứ các phương thức để validate dử liệu
     * @var string $validatorClass 
     */
    // protected $validatorClass = 'App\Validators\Options\OptionValidator';
    /**
     * @var string $resourceClass
     */
    protected $resourceClass = 'OptionResource';
    /**
     * @var string $collectionClass
     */
    protected $collectionClass = 'OptionCollection';


    public $currentGroupLabel = '';

    public $currentOptionTitle = '';

    

    /**
     * get model
     * @return string
     */
    public function getModel()
    {
        return \App\Models\Option::class;
    }

    public function init(){
        $this->registerCacheMethods([
            'getData' => 'getOptionData'
        ]);
    }

    /**
     * kich hoạt data và group
     *
     * @return void
     */
    public function activeDataGroup()
    {
        $this->groupRepository = new GroupRepository();
        $this->dataRepository = new DataRepository();

    }

    /**
     * lấy thông tin các cột cần kiểm tra
     *
     * @return array
     */
    public function getCheckColimns()
    {
        $columns = ['slug', 'ref', 'ref_id'];
        if(!$this->getOwnerID()){
            $columns[] = 'owner_id';
        }
        return $columns;
    }

    /**
     * Tạo ra một bảng option nếu chưa tồn tại
     *
     * @param array $data
     * 
     * @param mixed $callback
     * 
     * @return \App\Models\Option
     */
    public function createDataIfNotExists(array $data = [], $callback = null)
    {
        // giá trị mặc định
        $default = ['slug' => null, 'title' => null, 'ref' => null, 'ref_id' => 0];
        $checkColumns = $this->getCheckColimns();
        // thông tim đầu vào
        $inputs = new Arr(array_merge($default, $data));
        // nếu có yêu cầu kiểm tra owner_id mà trong input không có
        if(in_array('owner_id', $checkColumns) && !$inputs->isset('owner_id')) return null;
        // nếu thiếu cả title và slug thì trả về false
        elseif(!$inputs->slug && !$inputs->title) return null;
        // nếu không có slug thì gán title cho slug
        elseif(!$inputs->slug) $inputs->slug = Str::slug($inputs->title);
        // nếu không có title thì gán slug cho title
        elseif(!$inputs->title) $inputs->title = $inputs->slug;
        // để cho chắc chắn là slug sẽ luôn đúng định dạng
        $inputs->slug = Str::slug($inputs->slug);
        // tham số để kiểm tra xem tồn tại hay không
        $params = $inputs->copy($checkColumns);
        // kiểm tra xem tồn tại hay chưa
        if(!($option = $this->first($params))){
            // nếu chưa tồn tại thì tạo mới
            $option = $this->create($inputs->all());
        }
        if(is_callable($callback)){
            $callback($option);
        }
        return $option;
    }

    /**
     * build group params
     *
     * @param Arr $params
     * @return array
     */
    public function getGroupParams($params)
    {
        if(!$params->option || !$params->group) return [];
        $optionParams = [
            'slug' => $params->option
        ];
        if($params->ref_id){
            $optionParams['ref'] = $params->ref;
            $optionParams['ref_id'] = $params->ref_id;
        }else{
            $optionParams['ref_id'] = 0;
        }
        
        if(!($option = $this->first($optionParams))) return [];
        
        
        $this->activeDataGroup();
        if(!($group = $this->groupRepository->first(['option_id' => $option->id, 'slug' => $params->group]))) return [];
        $params->remove('option', 'ref', 'ref_id', 'group');
        return compact('option', 'group');
    }
    
    /**
     * lấy thông tin input và data
     * @param array $args
     * 
     * @return array
     */
    public function getOptionFormData(array $args = [])
    {
        $params = new Arr($args);
        if(!count($optionGroup = $this->getGroupParams($params))) return [];
        extract($optionGroup);
        $params->merge(['group_id' => $group->id, '@order_by' => ['priority' => 'ASC']]);
        $data = [];
        $inputs = [];
        $option_title = $option->title;
        $group_label = $group->label;
        $this->currentOptionTitle = $option->title;
        $this->currentGroupLabel = $group->label;
        $listData = $this->dataRepository->get($params->all());
        if(count($listData)){
            foreach ($listData as $oData) {
                $d = new Arr($oData->toArray());
                $d->remove('props', 'value', 'id');
                if(is_array($oData->props)){
                    $d->merge($oData->props);
                }
                $d->remove('validate', 'rules', 'messages');
                $inputs[$oData->name] = $d->all();
                $data[$oData->name] = $oData->value;
            }
        }
        return compact('inputs', 'data', 'option_title', 'group_label');
    }

    
    /**
     * lấy thông tin input và data
     * @param array $args
     * 
     * @return array
     */
    public function getOptionItems(array $args = [])
    {
        
        $params = new Arr($args);
        if(!count($optionGroup = $this->getGroupParams($params))) return [];
        extract($optionGroup);
        
        $this->currentOptionTitle = $option->title;
        $this->currentGroupLabel = $group->label;
        $params->merge(['group_id' => $group->id, '@order_by' => ['priority' => 'ASC']]);
        return $this->dataRepository->get($params->all());
    }

    /**
     * lấy thông tin input và data
     * @param array $args
     * 
     * @return array
     */
    public function getOptionItem(array $args = [])
    {
        
        $params = new Arr($args);
        if(!count($optionGroup = $this->getGroupParams($params))) return [];
        extract($optionGroup);
        
        $this->currentOptionTitle = $option->title;
        $this->currentGroupLabel = $group->label;
        $params->merge(['group_id' => $group->id, '@order_by' => ['priority' => 'ASC']]);
        return $this->dataRepository->first($params->all());
    }

    

    
    /**
     * lấy thông tin input và data
     * @param array $args
     * @param array $data Dữ liệu cần cập nhật, là một mảng kry => value
     * @return boolean
     */
    public function updateOptionData(array $args = [], array $data = []) : bool
    {
        if(!$data) return false;
        $params = new Arr($args);
        if(!count($optionGroup = $this->getGroupParams($params))) return false;
        extract($optionGroup);
        
        $params->merge(['group_id' => $group->id, 'name' => array_keys($data)]);
        $list = $this->dataRepository->get($params->all());
        if(count($list)){
            foreach ($list as $item) {
                if(array_key_exists($item->name, $data)){
                    $v = $data[$item->name];
                    if(is_array($v)) $v = json_encode($v);
                    $item->value = $v;
                    $item->save();
                }
            }
            return true;
        }
        return false;
    }



    /**
     * lấy thông tin input và data
     * @param array $args
     * 
     * @return array
     */
    public function getOptionGroup(array $args = [])
    {
        
        $params = new Arr($args);
        if(!$params->option || !$params->group) return null;
        $optionParams = [
            'slug' => $params->option
        ];
        if($params->ref_id){
            $optionParams['ref'] = $params->ref;
            $optionParams['ref_id'] = $params->ref_id;
        }else{
            $optionParams['ref_id'] = 0;
        }
        
        if(!($option = $this->first($optionParams))) return null;
        $this->activeDataGroup();
        if($params->group){
            $params->slug = $params->group;
        }
        $params->option_id = $option->id;
        $params->remove('option', 'ref', 'ref_id', 'group');

        return $this->groupRepository->first($params->all());
    }



    /**
     * lấy thông tin input và data
     * @param array $args
     * 
     * @return array
     */
    public function getOptionGroups(array $args = [])
    {
        
        $params = new Arr($args);
        if(!$params->option || !$params->group) return [];
        $optionParams = [
            'slug' => $params->option
        ];
        if($params->ref_id){
            $optionParams['ref'] = $params->ref;
            $optionParams['ref_id'] = $params->ref_id;
        }else{
            $optionParams['ref_id'] = 0;
        }
        
        if(!($option = $this->first($optionParams))) return [];
        $this->activeDataGroup();
        $params->option_id = $option->id;
        $params->remove('option', 'ref', 'ref_id', 'group');
        return $this->groupRepository->get($params->all());
    }

    /**
     * lấy thong tin data group
     *
     * @param array $args
     * @return \App\Models\Option
     */
    public function getOptionData(array $args = [])
    {
        return $this->with(['groups' => function($query){
            $query->with(['datas' => function($q){
                $q->orderBy('priority', 'ASC');
            }]);
        }])->first($args);
    }

    /**
     * lấy thong tin data group
     *
     * @param array $args
     * @return \App\Models\Option
     */
    public function getOptionList(array $args = [])
    {
        return $this->with(['groups' => function($query){
            $query->with(['datas' => function($q){
                $q->orderBy('priority', 'ASC');
            }]);
        }])->get($args);
    }

    /**
     * lấy input data theo group
     *
     * @param array $args
     * @return \App\Models\Option
     */
    public function getOptionGroupData(array $args = [])
    {
        if($args){
            return $this->with([
                'groups' => function($query){
                    $query->with('datas');
                }
            ])->first($args);
        }
        return null;
    }
    
    /**
     * kiểm tra theme có option hay ko
     *
     * @param integer $theme_id
     * @return boolean
     */
    public function hasThemeOption(int $theme_id)
    {
        $total = $this->join('option_groups', 'option_groups.option_id', '=', 'options.id')
                        ->count(['ref'=>'theme', 'ref_id' => $theme_id]);
        return $total > 0;
    }


}