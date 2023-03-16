<?php
namespace App\Repositories\Base;

use App\Models\Model;
use App\Validators\Base\ExampleValidator;

use ReflectionClass;

use Illuminate\Http\Request;


/**
 * Các phuong thức để crud
 */
trait CRUDAction
{
    /**
     * @var $validatorClass
     * full class name 
     */
    protected $validatorClass = 'Base\ExampleValidator';
    
    protected $validateAttrs = [];
    
    protected $validatorNamespace = 'App\Validators';

    protected $actor = null;


    protected $crudAction = null;

    protected $currentID = 0;

    public function setActor($actor = null)
    {
        if(is_string($actor) && in_array($a = strtolower($actor), ['admin', 'manager', 'client'])){
            $this->actor = $a;
        }
        return $this;
    }

    public function getActor()
    {
        return $this->actor;
    }

    /**
     * dat validator class
     * @param string
     * @return object instance
     */
    public function setValidatorClass($validatorClass)
    {
        if(class_exists($this->validatorNamespace."\\".$validatorClass)){
            $this->validatorClass = $this->validatorNamespace."\\".$validatorClass;
        }elseif(class_exists($this->validatorNamespace."\\".$validatorClass.'Validator')){
            $this->validatorClass = $this->validatorNamespace."\\".$validatorClass.'Validator';
        }elseif(class_exists($validatorClass)){
            $this->validatorClass = $validatorClass;
        }elseif(class_exists($validatorClass.'Validator')){
            $this->validatorClass = $validatorClass.'Validator';
        }
        return $this;
    }

    


    /**
     * lay doi tuong validator
     * @param Request $request
     * @param string $validatorClass
     * @return ExampleValidator
     */
    public function getValidator(Request $request, $validatorClass = null)
    {
        if($validatorClass){
            $this->setValidatorClass($validatorClass);
        }

        if($this->validatorClass){
            $c = null;

            if(class_exists($this->validatorClass)){
                $c = $this->validatorClass;
            }elseif(class_exists($class = $this->validatorNamespace . '\\' . $this->validatorClass)){
                $c = $class;
            }
            else{
                $c = 'App\Validators\Base\ExampleValidator';
            }
            $rc = new ReflectionClass($c);
            return $rc->newInstanceArgs( [$request, $this] );
        }
        return new ExampleValidator($request, $this);
    }

    /**
     *
     * lay doi tuong validator
     * @return ExampleValidator
     */
    public function validator(Request $request, $validatorClass = null)
    {
        $validator = $this->getValidator($request, $validatorClass);
        $validator->check();
        return $validator;
    }

    /**
     * lay du lieu da duoc validate
     * @param Request $request
     * @param string|array $ruleOrvalidatorClass
     * @param array $messages
     * @return array
     */
    public function validate(Request $request, $ruleOrvalidatorClass = null, $messages = [])
    {
        return $this->getValidator(
            $request, 
            is_string($ruleOrvalidatorClass)?$ruleOrvalidatorClass:null
        )->validate(
            is_array($ruleOrvalidatorClass)?$ruleOrvalidatorClass:[], 
            is_array($messages)?$messages:[]
        );
    }

    /**
     * lay du lieu da duoc validate
     * @param Request $Request
     * @param string|array $ruleOrvalidatorClass
     * @param array $messages
     * @return array
     */
    public function getValidateData(Request $request, $ruleOrvalidatorClass = null, $messages = [])
    {
        return $this->validate($request, $ruleOrvalidatorClass, $messages);
    }


    public function setValidatoAttrs(...$attrs)
    {
        if(is_array($attrs) && count($attrs)){
            foreach ($attrs as $attr) {
                if(is_string($attr)){
                    if($attr == '*'){
                        $this->validateAttrs = '*';
                        return;
                    }
                    $this->validateAttrs[] = $attr;
                }elseif(is_array($attr)){
                    $this->validateAttrs = array_merge($this->validateAttrs, $attr);
                }
            }
        }
    }

    public function getValidateAttrs()
    {
        if(is_array($this->validateAttrs) && count($this->validateAttrs)){
            return $this->validateAttrs;
        }
        return null;
    }

    /**
     * Chuẩn hóa dữ liệu trước khi tạo mới
     * @param  array  $data mang du lieu
     * @return array
     */
    public function beforeCreate(array $data)
    {
        return $data;
    }
    /**
     * Chuẩn hóa dữ liệu trước khi Cập nhật
     * @param  array  $data mang du lieu
     * @return array
     */
    public function beforeUpdate(array $data, $id = null)
    {
        return $data;
    }
    

    /**
     * luu du lieu
     * @param  array  $data mang du lieu
     * @param  integer $id id cua ban ghi
     * @return Model
     */
    public function save(array $data, $id=null)
    {
        if($id && $m = $this->_model->find($id)){
            $model = $m;
            $this->crudAction = 'update';
            $this->currentID = $id;
            $data = $this->beforeUpdate($data, $id);

        }else{
            $this->crudAction = 'create';
            $model = $this->model();
            if($this->defaultValues){
                $data = array_merge($this->defaultValues, $data);
            }
            $data = $this->beforeCreate($data);
        }

        if(is_array($d = $this->beforeSave($data))){
            $data = $d;
        }


        if(!$data && !$id) return false;
        $data = $this->parseData($data);
        $model->fill($data);
        // dd($model);
        $model->save();
        if($id && $id == $model->id){
            $this->afterUpdate($model);
        }else{
            $this->afterCreate($model);
        }
        $this->afterSave($model);
        $this->crudAction = null;
        $this->currentID = 0;
            
        return $model;
    }



    /**
     * chuẩn hóa data trước khi lưu
     */
    public function parseData($data = [])
    {
        $escape = [];
        if(count($data)){
            foreach ($data as $key => $value) {
                if((is_array($value) || is_object($value)) && (!$this->_model->casts || !array_key_exists($key, $this->_model->casts))){
                    $escape[$key] = json_encode($value, JSON_UNESCAPED_UNICODE);
                }
                else{
                    $escape[$key] = $value;
                }
            }
        }
        return $escape;
    }

    /**
     * xử lý data trước khi luu
     * @param array $data dữ liệu truyền vào
     * 
     * @return array trả về mảng dữ liệu
     */
    public function beforeSave($data)
    {
        return $data;
    }

    /**
     * tao bản ghi mới
     * @param array
     * 
     * @return false|\App\Http\Resources\ExampleResource|\App\Models\Model
     */
    public function create(array $data = [])
    {
        if($model = $this->save($data)){
            // do something
            
            // $this->afterCreate($model);
            return $model;
        }
        return false;
    }

    /**
     * cập nhật dử liệu bản ghi
     * @param int $id
     * @param array $data
     */
    public function update(int $id, array $data = [])
    {
        if(!$this->find($id)) return false;
        if($model = $this->save($data, $id)){
            // do something

            // $this->afterUpdate($model);
            return $model;

        }
        return false;
    }

    /**
     * tạo bản ghi nếu chưa tồn tại
     *
     * @param array $data
     * @return \App\Models\Model
     */
    public function createIfNotExists(array $data = [], array $columns = [])
    {
        $params = $data;
        if($columns){
            $params = array_copy($data, $columns);
        }
        if(!$params){
            if($data) return $this->create($data);
            return null;
        }
        if(!($d = $this->first($params))){
            $d = $this->create($data);
        }
        return $d;
    }
    /**
     * tạo bản ghi nếu tồn tại thì update
     *
     * @param array $data
     * @param array $columns
     * @return \App\Models\Model
     */
    public function createOrUpdate(array $data = [], array $columns = [])
    {
        $params = $data;
        if($columns){
            $params = array_copy($data, $columns);
        }
        if($params && $d = $this->first($params)){
            return $this->update($d->{$this->$this->_primaryKeyName}, $data);
        }
        return $this->create($data);
    }
    
    
    /**
     * Delete
     *
     * @param int|int[] $id
     * @return bool
     */
    public function delete($id = null)
    {
        if(!$id){
            // 
            if(count($this->params) || count($this->actions)){
                return $this->query()->delete();
            }
            return false;
        }
        // nếu xóa nhiều
        if(is_array($id)){
            $ids = [];
            $list = $this->get([$this->_primaryKeyName => $id]);
            if(count($list)){
                foreach ($list as $item) {
                    if(!$item->canDelete()) continue;
                    $ids[] = $item->id;
                    $item->delete();
                }
            }
            return $ids;
        }
        $result = $this->find($id);
        if($result) {
            if($result->canDelete()){
                $result->delete();
                return true;
            }
            
        }

        return false;
    }

    
    /**
     * Delete
     *
     * @param int|int[] $id
     * @return bool
     */
    public function forceDelete($id = null)
    {
        if(!$id){
            $ids = [];
            $list = $this->get();
            if(count($list)){
                foreach ($list as $item) {
                    if(!$item->canForceDelete()) continue;
                    $ids[] = $item->id;
                    $item->forceDelete();
                }
            }
            return $ids;
        }
        // nếu xóa nhiều
        if(is_array($id)){
            $ids = [];
            $list = $this->get([$this->_primaryKeyName => $id]);
            if(count($list)){
                foreach ($list as $item) {
                    if(!$item->canForceDelete()) continue;
                    $ids[] = $item->id;
                    $item->forceDelete();
                }
            }
            return $ids;
        }
        $result = $this->find($id);
        if($result) {
            if($result->canForceDelete()){
                $result->forceDelete();
                return true;
            }
            
        }

        return false;
    }

    

    /**
     * trash
     *
     * @param $id
     * @return bool
     */
    public function moveToTrash($id)
    {
        $result = $this->find($id);
        if($result && $result->canMoveToTrash()) {
            return $result->moveToTrash();
        }

        return false;
    }
    

    /**
     * trash
     *
     * @param $id
     * @return bool
     */
    public function softDelete($id)
    {
        $result = $this->find($id);
        if($result && $result->canMoveToTrash()) {
            return $result->moveToTrash();
        }

        return false;
    }

    /**
     * khôi phục bản ghi
     * @param int $id
     */
    public function restore($id)
    {
        $result = $this->find($id);
        if($result) {
            return $result->restore();
        }

        return false;
    }

    /**
     * xóa vĩnh viễn bản ghi
     * @param int $id
     */
    public function erase($id)
    {
        $result = $this->find($id);
        if($result && $result->canErase()) {
            return $result->erase();
        }

        return false;
    }

    /**
     * kiểm tra cho cho phep chuyen vao thung ra hay ko
     * @param int $id
     */
    public function canMoveToTrash($id = null)
    {
        if($id && $model = $this->find($id)) return $model->canMoveToTrash();
        return false;
    }

    /**
     * kiểm tra cho cho phep chuyen vao thung ra hay ko
     * @param int $id
     */
    public function canDelete($id = null)
    {
        if($id && $model = $this->find($id)) return $model->canDelete();
        return false;
    }

}
