<?php

namespace App\Repositories\Html;

use App\Masks\Html\ComponentCollection;
use App\Masks\Html\ComponentMask;
use App\Repositories\Base\BaseRepository;
use App\Repositories\Components\ComponentRepository as Components;
use App\Validators\Html\ComponentValidator;
use Crazy\Helpers\Arr;

class ComponentRepository extends BaseRepository
{
    /**
     * class chứ các phương thức để validate dử liệu
     * @var string $validatorClass 
     */
    protected $validatorClass = ComponentValidator::class;
    protected $maskClass = ComponentMask::class;
    protected $maskCollectionClass = ComponentCollection::class;

    /**
     * component repository
     *
     * @var \App\Repositories\Components\ComponentRepository
     */
    protected $componentRepository = null;
    /**
     * get model
     * @return string
     */
    public function getModel()
    {
        return \App\Models\HtmlComponent::class;
    }


    public function init()
    {
        $this->setJoinable([
            ['join', 'components', 'components.id', '=', 'html_components.component_id']
        ])->setSelectable(['html_components.*', 'components.name']);
    }

    public function setComponentRepository($componentRepository)
    {
        $this->componentRepository = $componentRepository;
        $componentRepository->removeDefaultParam();
        return $this;
    }


    /**
     * lấy component repo
     *
     * @return \App\Repositories\Components\ComponentRepository
     */
    public function getComponentRepository()
    {
        if(!$this->componentRepository) {
            $this->componentRepository = app(Components::class);
            $this->componentRepository->removeDefaultParam();
        }
        return $this->componentRepository; 
    }

    
    
    /**
     * lấy thông tin các cột cần kiểm tra
     *
     * @return array
     */
    public function getCheckColimns()
    {
        $columns = ['component_id', 'area_id'];
        if(!$this->getOwnerID()){
            $columns[] = 'owner_id';
        }
        return $columns;
    }


    /**
     * khoi tao neu chua dc tao tu truoc
     *
     * @param array $data
     * @return void
     */
    public function createDataIfNotExists($data = [], $columns = [])
    {
        $checkColumns = $this->getCheckColimns();
        // thông tim đầu vào
        $inputs = new Arr($data);
        
        if(in_array('owner_id', $checkColumns) && !$inputs->isset('owner_id')) return null;
        if(!$inputs->component_id) return null;
        if(!$inputs->area_id) return null;
        if(!$inputs->data) $inputs->data = [];
        $params = $inputs->copy($checkColumns);
        if(!($optionGroup = $this->first($params))){
            $optionGroup = $this->create($inputs->all());
        }
        return $optionGroup;
    }
    /**
     * khoi tao neu 
     *
     * @param array $data
     * @return void
     */
    public function firstCreate($data)
    {
        $checkColumns = $this->getCheckColimns();
        // thông tim đầu vào
        $inputs = new Arr($data);
        
        if(in_array('owner_id', $checkColumns) && !$inputs->isset('owner_id')) return null;
        if(!$inputs->component_id) return null;
        if(!$inputs->area_id) return null;
        if(!$inputs->data) $inputs->data = [];
        $optionGroup = $this->create($inputs->all());
        return $optionGroup;
    }

    
    
    /**
     * sap xep lai thu tu
     * @param integer $id
     * @param integer $priority
     * @return void
     */
    public function updatePriority($id, $priority=0)
    {
        // nếu tìm không thấy id thì trả về false luôn
        if(!($result = $this->findBy('id', $id))) return false;
        $c = $this->count();
        if($result->priority==0 || $priority == 0){
            if($result->priority==0){
                $result->priority = $c;
                $result->save();
                return true;
            }
            return $this->updatePriority($id, $c);
        }
        // nếu thứ tữ khác 0 và khác thứ tự cụ
        if($priority != $result->priority){
            // nếu thứ tự lớn hơn tổng số thì gán thứ tự bằng tổng số
            if($priority > $c) $priority = $c;
            
            // xử lý trường hợp thay đổi vị trí trong khoảng 0 < priority < max

            $query = $this->newRepo()->where('id', '!=', $result->id)->where('area_id', $result->area_id);
            
            // vị trí bắt đầu
            $begin = ($priority<$result->priority)?$priority:$result->priority;
            // vị trí kết thúc
            $end = ($priority>$result->priority)?$priority:$result->priority;    
            
            $query->whereBetween('priority',[$begin,$end]);
            
            if($list = $query->get()){
                if($priority > $result->priority){
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
            $result->priority = $priority;
            $result->save();
            return true;
        }
        return false;
    }

    
    /**
     * sửa thứ tự hiển thị
     *
     * @param int $area_id
     * @return void
     */
    public function repairPriority($area_id)
    {
        if(( $max = count($list = $this->orderBy('priority','DESC')->get(['area_id' => $area_id])) ) > 0){
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
     * @param array $components
     * @param integer $area_id
     * @param integer $parent_id
     * @return bool
     */
    public function sortComponents(array $components = [], int $area_id, $parent_id = 0)
    {
        $i = 0;
        if(is_array($components)){
            foreach ($components as $key => $component) {
                if(is_array($component) && isset($component['id'])){
                    $d = compact('area_id', 'parent_id');
                    $d['priority'] = isset($component['priority']) && is_numeric($component['priority']) ? $component['priority'] : $i;
                    if($this->update($component['id'], $d)){
                        if(isset($component['children']) && is_array($component['children'])){
                            $this->sortComponents($component['children'], $area_id, $component['id']);
                        }
                        $i++;
                    }
                    
                }
            }
        }
        return $i;
    }

    public function getComponentInputs($component_id, $id = 0)
    {
        $return = [];
        $componentRepository = $this->getComponentRepository();
        if($component = $componentRepository->findBy('id', $component_id)){
            $inputs = $component->inputs;
            if(is_string($inputs)){
                $inputs = json_decode($inputs, true);
            }
            
            if(!is_array($inputs)) $inputs = [];
            if($inputs){
                $data = [];
                $inputData = $component->data;
                if($inputData){
                    foreach ($inputs as $key => $input) {
                        $name = $input['name']??$key;
                        if(isset($inputData[$name])){
                            $data[$name] = $inputData[$name];
                            $inputs[$key]['value'] = $inputData[$name];
                        }
                    }
                }
                if($id && $htmlComponent = $this->findBy('id', $id)){
                    $htmlInputData = $htmlComponent->data;
                    if($htmlInputData){
                        foreach ($inputs as $key => $input) {
                            $name = $input['name']??$key;
                            if(isset($htmlInputData[$name])){
                                $data[$name] = $htmlInputData[$name];
                                $inputs[$key]['value'] = $htmlInputData[$name];
                            }
                        }
                    }
                }
                $return = compact('inputs', 'data');
            }
        }
        return $return;
    }

}