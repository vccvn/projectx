<?php

namespace App\Validators\Permissions;

use App\Validators\Base\BaseValidator;

use App\Repositories\Permissions\RouteRepository;

use App\Repositories\Permissions\RoleRepository;

class ModuleValidator extends BaseValidator
{
    protected $routes = null;
    public function checkRef2()
    {
        return in_array(strtolower($this->type), ['uri', 'name', 'prefix']);
    }
    public function extends()
    {
        $this->routes = new RouteRepository();
        $this->addRule('module_type', function($attr, $value){
            if(!$value) return true;
            return in_array(strtolower($value), ['default', 'uri', 'name', 'prefix']);
        });
        $this->addRule('parent_id', function($attr, $value){
            if(!$value) return true;
            if(strtolower($this->type) == 'default'){
                return $this->repository->find($value)?true:false;
            }
            return false;
        });
        $this->addRule('module_ref', function($attr, $value){
            $t = $this->checkRef2();
            if(!$value){
                if(!$t){
                    return true;
                }
                return false;
            }
            if($t){
                return $this->routes->getRoute($this->type, $value)?true:false;
            }
            return true;
        });

        $this->addRule('check_roles', function($attr, $value){
            if(!$value) return true;
            if(is_array($value)){
                if(count($value)){
                    $roleRep = new RoleRepository();
                    foreach ($value as $id) {
                        if(!$roleRep->count(['id'=>$id]))  return false;
                    }
                    return true;
                }
                return true;
            }
            return false;;
        });

        $this->addRule('ref_unique', function($attr, $value){
            $t = $this->checkRef2();
            if(!$value){
                if(!$t){
                    return true;
                }
                return false;
            }
            if($t){
                if($this->routes->getRoute($this->type, $value)){
                    if($result = $this->repository->first(['type' => $this->type, 'ref'=> $value])){
                        if($this->id && $this->id == $result->id){
                            return true;
                        }
                        return false;
                    }
                    return true;
                }
                return false;
            }
            return true;
        });
    }
    /**
     * ham lay rang buoc du lieu
     */
    public function rules()
    {
        $rules = [
            'name'                => 'required|max:191',
            'type'                => 'module_type',
            // 'parent_id'           => 'parent_id',
            'ref'                 => 'module_ref|ref_unique',
            'roles'               => 'check_roles',
            'description'         => 'max:2000',
        ];
        if(!$this->type || strtolower($this->type) == 'default'){
            $rules['parent_id'] = 'parent_id';
        }

        return $this->parseRules($rules);
    }

    public function messages()
    {
        return [
            'name.max'                             => 'Tên vượt quá số ký tự',
            
            'name.required'                        => 'Bạn chưa nhập tên module',
            
            'type.module_type'                     => 'Loại module không hợp lệ',
            
            'parent_id.parent_id'                  => 'Module cha không hợp lệ',

            'roles.check_roles'                    => 'Danh sách quyền không hợp lệ',

            'ref.module_ref'                       => 'Mục tham chiếu không hợp lệ'
        ];
    }
}