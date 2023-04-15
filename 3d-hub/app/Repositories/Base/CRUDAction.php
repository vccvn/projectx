<?php
/**
 * @author DoanLN
 * @copyright 2018-2019
 */

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
        }elseif(class_exists($validatorClass)){
            $this->validatorClass = $validatorClass;
        }
        return $this;
    }

    


    /**
     * @override
     * lay doi tuong validator
     * @param Request $request
     * @param string $validatorClass
     * @return App\Validators\Base\BaseValidator
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
     * @override
     * lay doi tuong validator
     * @return ExampleValidator
     */
    public function validator(Request $request, $validatorClass = null)
    {
        $validator = $this->getValidator($request, $validatorClass);
        $validator->check();
        return $validator;
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
    public function beforeUpdate(array $data)
    {
        return $data;
    }
    

    /**
     * luu du lieu
     * @param  array   $data        mang du lieu
     * @param  integer $id          id cua ban ghi
     * @return Model
     */
    public function save(array $data, $id=null)
    {
        if($id && $m = $this->_model->find($id)){
            $model = $m;
            $data = $this->beforeUpdate($data);
        }else{
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
        $model->save();
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

            return $model;
        }
        return false;
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
        if($result && $result->canDelete()) {
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
