<?php

namespace App\Repositories\Components;

use App\Repositories\Base\BaseRepository;
use Crazy\Helpers\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class ComponentRepository extends BaseRepository
{
    
    protected $defaultData = [
        'type' => 'custom', 
        'ref' => null, 
        'ref_id' => 0, 
        'path' => null, 
        'name' => null, 
        'inputs' => [], 
        'data' => []
    ];

    /**
     * get model
     * @return string
     */
    public function getModel()
    {
        return \App\Models\Component::class;
    }

    /**
     * lấy các bảng được hỗ trợ
     * @param string
     */
    public function getRefSupport($ref)
    {
        $ref = strtolower($ref);
        if(in_array($ref, ['page'])) $ref = 'post';
        $tbl = null;
        if(in_array($ref, ['custon'])){
            return $ref;
        }
        elseif (Schema::hasTable($ref)) {
            $tbl = $ref;
        }elseif(Schema::hasTable($tb = str_plural($ref))){
            $tbl = $tb;
        }else{
            return false;
        }
        return $tbl;
    }

    /**
     * kiểm tra tham chiếu
     * @param string $ref
     * @param int $ref_id
     * 
     * @return boolean
     */
    public function checkRef($ref = null, $ref_id = 0)
    {

        if(!$ref || in_array($ref, ['custom'])){
            return true;
        }
        if($tb = $this->getRefSupport($ref))
        {
            if(!DB::table($tb)->where('id',$ref_id)->first()) return false;
            return true;
        }
        return false;
    }

    
    /**
     * lấy thông tin các cột cần kiểm tra
     *
     * @return array
     */
    public function getCheckColimns()
    {
        $columns = ['type', 'ref', 'ref_id', 'path'];
        // if(!$this->getOwnerID()){
        //     $columns[] = 'owner_id';
        // }
        return $columns;
    }



    
    /**
     * tạo ra môt group group nếu chưa tồn tại
     *
     * @param array $data dữ liệu của một bản ghi
     * @param bool $check_ref_exists
     * @return App\Models\Component|null
     */
    public function createOrUpdate(array $data = [], $check_ref_exists = null)
    {
        $checkColumns = $this->getCheckColimns();
        // thông tim đầu vào
        $inputs = new Arr(array_merge($this->defaultData, $data));
        // nếu có yêu cầu kiểm tra owner_id mà trong input không có
        if(in_array('owner_id', $checkColumns) && !$inputs->isset('owner_id')) return null;
        if($check_ref_exists && !$this->checkRef($inputs->ref, $inputs->ref_id)) return null;
        if(!$inputs->path) return null;
        elseif(!$inputs->name) $inputs->name = $inputs->path;
        $params = $inputs->copy($checkColumns);
        // kiểm tra xem tồn tại hay chưa
        if(!($component = $this->first($params))){
            // nếu chưa tồn tại thì tạo mới
            return $this->create($inputs->all());
        }else{
            return $this->update($component->id, $data);
        }
    }

    
    /**
     * tạo ra môt Option data nếu chưa tồn tại
     *
     * @param string $type
     * @param string $ref
     * @param int $ref_id 
     * @param array $list dữ liệu của một bản ghi
     * @param bool $check_ref_exists
     * @return App\Models\Component[]
     */
    public function createListData($type = 'custom', $ref = null, int $ref_id = 0, array $list = [], $check_ref_exists = true) : array
    {
        if($check_ref_exists && !$this->checkRef($ref, $ref_id)) return [];
        $output = [];
        foreach ($list as $path => $data) {
            $data = is_array($data)?$data:['name' => $data];
            if(!isset($data['type']))$data['type'] = $type;
            $data['ref'] = $ref;
            $data['ref_id'] = $ref_id;
            if ($data['type'] == 'blade' && !isset($data['path'])) {
                $data['path'] = $path;
            }
            if ($optionData = $this->createOrUpdate($data, !$check_ref_exists)) $output[] = $optionData;
        }
        return $output;
    }

    /**
     * tạo ra môt list Component data nếu chưa tồn tại
     *
     * @param int $owner_id 
     * @param string $type
     * @param string $ref
     * @param int $ref_id 
     * @param array $list dữ liệu của một bản ghi
     * @param bool $check_ref_exists
     * @return App\Models\Component[]
     */
    public function createListWithOwnerID(int $owner_id = 0, $type = 'custom', $ref = null, int $ref_id = 0, array $list = [], $check_ref_exists = true) : array
    {
        if($check_ref_exists && !$this->checkRef($ref, $ref_id)) return [];
        $output = [];
        foreach ($list as $path => $data) {
            $data = is_array($data)?$data:['name' => $data];
            if(!isset($data['type']))$data['type'] = $type;
            $data['ref'] = $ref;
            $data['ref_id'] = $ref_id;
            $data['owner_id'] = $owner_id;
            if ($data['type'] == 'blade' && !isset($data['path'])) {
                $data['path'] = $path;
            }
            if ($optionData = $this->createOrUpdate($data, !$check_ref_exists)) {
                $output[] = $optionData;
            }
        }
        return $output;
    }

    /**
     * lai bo tham so owner
     *
     * @return ComponentRepository
     */
    public function noOwner()
    {
        return $this->removeDefaultParam('owner');
    }
    /**
     * lấy thông tin component dưới dạng option (id => name)
     *
     * @param array $args
     * @return array
     */
    public function getComponentOptionData($args = [])
    {
        $this->noOwner();
        $this->where(function($query){
            $query->where('ref_id', 0)->orWhere(function($q){
                $theme = get_active_theme();
                $q->where('ref', 'theme')->where('ref_id', $theme?$theme->id:0);
            });
        })->orderBy('path', 'ASC');
        $components = $this->get($args);
        $data = [];
        if(count($components)){
            foreach ($components as $component) {
                $data[$component->id] = $component->name;
            }
        }
        return $data;
    }

    /**
     * lấy ra danh sách tên các trường có kiểu file
     *
     * @param int $id
     * @return array
     */
    public function getComponentDetail($id)
    {
        if(!$id || !($component = $this->find($id))) return [];
        $files = [];
        $data = $component->data?$component->data:[];
        if($component->inputs && is_array($component->inputs)){
            foreach ($component->inputs as $key => $input) {
                $name = (isset($input['name']) && $input['name']) ? $input['name'] : $key;
                if(isset($input['type']) && strtolower($input['type']) == 'file'){
                    $files[] = $name;
                }
                if(!$component->data){
                    $data[$name] = isset($input['value'])?$input['value']:(isset($input['default'])?$input['default']:"");
                }
            }
        }
        $component->data = $data;
        $component->files = $files;
        return $component;
    }

}