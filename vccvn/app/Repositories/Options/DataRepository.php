<?php

namespace App\Repositories\Options;

use App\Repositories\Base\BaseRepository;
use Illuminate\Support\Str;
use Crazy\Helpers\Arr;
use App\Repositories\Options\GroupRepository;

class DataRepository extends BaseRepository
{


    protected $paginate = false;
    /**
     * group repository
     *
     * @var App\Repositories\Options\GroupRepository
     */
    protected $groupRepository = null;

    protected $defaultData = [
        'group_id' => 0, 
        'name' => null, 
        'label' => null, 
        'type' => 'text', 
        'value_type' => 'text', 
        'value' => null, 
        'priority' => 0, 
        'props' => []
    ];

    protected $defaultSortBy = ['priority' => 'ASC'];


    /**
     * get model
     * @return string
     */
    public function getModel()
    {
        return \App\Models\OptionData::class;
    }

    public function getGroupRep()
    {
        if(!$this->groupRepository){
            $this->groupRepository = app()->make(GroupRepository::class);
        }
        return $this->groupRepository;
    }


    /**
     * lấy thông tin các cột cần kiểm tra
     *
     * @return array
     */
    public function getCheckColimns()
    {
        $columns = ['name', 'group_id'];
        if(!$this->getOwnerID()){
            $columns[] = 'owner_id';
        }
        return $columns;
    }



    
    /**
     * tạo ra môt group group nếu chưa tồn tại
     *
     * @param array $data dữ liệu của một bản ghi
     * @param bool $check_group_exists
     * @return App\Models\OptionData|null
     */
    public function createOrUpdate(array $data = [], $check_group_exists = null)
    {
        $checkColumns = $this->getCheckColimns();
        // thông tim đầu vào
        $inputs = new Arr(array_merge($this->defaultData, $data));
        // nếu có yêu cầu kiểm tra owner_id mà trong input không có
        if(in_array('owner_id', $checkColumns) && !$inputs->isset('owner_id')) return null;
        // nếu yêu cầu kiểm tra group
        if($check_group_exists){
            $groupRepository = $this->getGroupRep();
            if(!$inputs->group_id || !$groupRepository->findBy('id', $inputs->group_id)){
                return null;
            }
        }
        // nếu thiếu name
        if(!$inputs->name && !$inputs->label) return null;
        // nếu không có slug thì gán label cho slug
        elseif(!$inputs->name) $inputs->name = Str::slug($inputs->label, '_');
        // nếu không có label thì gán name cho label
        elseif(!$inputs->label) $inputs->label = $inputs->name;
        // để cho chắc chắn là name sẽ luôn đúng định dạng
        $inputs->name = Str::slug($inputs->name, '_');
        // tham số để kiểm tra xem tồn tại hay không
        $params = $inputs->copy($checkColumns);
        // kiểm tra xem tồn tại hay chưa
        $props = $inputs->cutWithout(['name', 'label', 'value', 'type', 'value_type', 'priority', 'props', 'owner_id', 'group_id']);
        if($inputs->props && is_array($inputs->props)){
            $inputs->props = array_merge($inputs->props, $props);
        }
        else{
            $inputs->props = $props;
        }
        $d = $inputs->all();
        if(!($optionData = $this->first($params))){
            // nếu chưa tồn tại thì tạo mới
            $optionData = $this->create($d);
            $this->updatePriority($optionData->id, $optionData->priority);
            return $optionData;
        }else{
            unset($d['value']);
            return $this->update($optionData->id, $d);
        }
    }

    /**
     * tạo ra môt Option data nếu chưa tồn tại
     *
     * @param int $group_id 
     * @param array $list dữ liệu của một bản ghi
     * @param bool $check_group_exists
     * @return App\Models\OptionData[]
     */
    public function createListData(int $group_id, array $list = [], $check_group_exists = true) : array
    {
        if(!$this->checkInputs($group_id, $list, $check_group_exists)) return [];
        $output = [];
        $i = 1;
        foreach ($list as $name => $data) {
            if(is_array($data)){
                $data['group_id'] = $group_id;
                if(!isset($data['name']) || !$data['name'])$data['name'] = $name;
                $data['priority'] = $i;
                if($optionData = $this->createOrUpdate($data, !$check_group_exists)) $output[] = $optionData;
                $i++;
            }
        }
        return $output;
    }

    /**
     * tạo ra môt list Option data nếu chưa tồn tại
     *
     * @param int $owner_id 
     * @param int $group_id 
     * @param array $list dữ liệu của một bản ghi
     * @param bool $check_group_exists
     * @return App\Models\OptionData[]
     */
    public function createListWithOwnerID(int $owner_id = 0, int $group_id = 0, array $list = [], $check_group_exists = true) : array
    {
        if(!$this->checkInputs($group_id, $list, $check_group_exists)) return [];
        $output = [];
        foreach ($list as $key => $data) {
            if(is_array($data)){
                $data['group_id'] = $group_id;
                $data['owner_id'] = $owner_id;
                if(!is_numeric($key)){
                    if(!isset($data['name'])) $data['name'] = $key;
                }
                if($optionData = $this->createOrUpdate($data, false)) $output[] = $optionData;
            }
        }
        return $output;
    }

    /**
     * Kiểm tra thong tin dầu vào để tạo list
     *
     * @param int $group_id 
     * @param array $list dữ liệu của một bản ghi
     * @param bool $check_group_exists
     * @return bool
     */
    public function checkInputs(int $group_id = 0, array $list = [], $check_group_exists = true) : bool
    {
        if(!$group_id || !count($list)) return false; 
        if($check_group_exists){
            $groupRepository = $this->getGroupRep();
            if(!$groupRepository->findBy('id', $group_id)){
                return false;
            }
        }
        return true;
    }

    /**
     * xữ lý dữ liệu trước khi update
     *
     * @param array $data
     * @return array
     */
    public function beforeUpdate(array $data, $id = null)
    {
        foreach ($this->defaultData as $key => $value) {
            if(isset($data[$key])){
                if($key == 'value') unset($data[$key]);
            }
        }
        return $data;
    }

    
    /**
     * sap xep lai thu tu
     * @param integer $item_id
     * @param integer $priority
     * @return void
     */
    public function updatePriority($id, $priority=0)
    {
        // nếu tìm không thấy item_id thì trả về false luôn
        if(!($groupItem = $this->find($id))) return false;
        $c = $this->countBy('group_id',$groupItem->group_id);
        if($groupItem->priority==0 || $priority == 0){
            if($groupItem->priority==0){
                $groupItem->priority = $c;
                $groupItem->save();
                return true;
            }
            return $this->updatePriority($id, $c);
        }
        // nếu thứ tữ khác 0 và khác thứ tự cụ
        if($priority != $groupItem->priority){
            // nếu thứ tự lớn hơn tổng số thì gán thứ tự bằng tổng số
            if($priority > $c) $priority = $c;
            
            // xử lý trường hợp thay đổi vị trí trong khoảng 0 < priority < max

            $query = $this->newRepo()->where('group_id',$groupItem->group_id)->where('id', '!=', $groupItem->id);
            
            // vị trí bắt đầu
            $begin = ($priority<$groupItem->priority)?$priority:$groupItem->priority;
            // vị trí kết thúc
            $end = ($priority>$groupItem->priority)?$priority:$groupItem->priority;    
            
            $query->whereBetween('priority',[$begin,$end]);
            
            if($list = $query->get()){
                if($priority > $groupItem->priority){
                    foreach($list as $item){
                        $item->priority = $item->priority - 1;
                        $item->save();
                    }
                    
                }
                else{
                    foreach($list as $item){
                        $item->priority = $item->priority + 1;
                        $item->save();
                    }
                }   
            }
            $groupItem->priority = $priority;
            $groupItem->save();
            return true;
        }
        return false;
    }

    /**
     * sửa thứ tự hiển thị
     *
     * @param int $group_id
     * @return void
     */
    public function repairPriority($group_id)
    {
        if(( $max = count($list = $this->orderBy('priority','DESC')->get(['group_id' => $group_id])) ) > 0){
            // nếu có danh sách sẽ duyệt qua và sap91 xep71 từ cao đến thấp 
            foreach($list as $item){
                if($item->priority>$max){
                    $item->priority = $max;
                    $item->save();
                }
                $max--;
            }
        }
    }

    /**
     * sap xep 
     *
     * @param integer $group_id
     * @param array $items
     * @return bool
     */
    public function sortItems(int $group_id, array $items = [])
    {
        $status = true;
        if(count($list = $this->get(['group_id' => $group_id]))){
            foreach ($list as $item) {
                if(!array_key_exists($item->id, $items)){
                    $item->delete();
                }elseif ($item->priority != $items[$item->id]) {
                    $item->priority = $items[$item->id];
                    $item->save();
                }
            }
        }else{
            $status = false;
        }
        return $status;
    }
}