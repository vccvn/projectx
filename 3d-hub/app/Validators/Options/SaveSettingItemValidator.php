<?php

namespace App\Validators\Options;

use App\Validators\Base\BaseValidator;

class SaveSettingItemValidator extends BaseValidator
{
    public function extends()
    {
        
        $this->addRule('name_unique', function($name, $value){
            if(!$value) return false;
            if($item = $this->repository->getSettingItem($this->route('group'), $value)){
                if($this->id){
                    if($this->id == $item->id){
                        return true;
                    }
                }
                return false;
            }
            return true;
        });

        $this->addRule('check_input_type', function($name, $value){
            if(!$value) return false;
            return array_key_exists($value, web_cfg('option_input_types'));
        });
        $this->addRule('check_value_type', function($name, $value){
            if(!$value) return true;
            return in_array($value, ['text', 'number', 'boolean']);
        });
    }

    /**
     * ham lay rang buoc du lieu
     */
    public function rules()
    {
    
        return [
            
            'name' => 'required|name_slug|name_unique',
            'label' => 'required',
            'type' => 'required|check_input_type',
            'value_type' => 'check_value_type',
            

        ];
    }

    /**
     * các thông báo
     */
    public function messages()
    {
        return [
            
            'name.required' => 'Tên (key) không được bỏ trống',
            'name.name_unique' => 'Tên (key) đã được sử dụng',
            'name.name_slug' => 'Tên (key) không hợp lệ',
            'label.required' => 'Nhãn Không được bỏ trống',
            'type.required' => 'Kiểu input không được bỏ trống',
            'type.check_input_type' => 'Kiểu input không hợp lệ',
            'value_type.check_value_type' => 'Kiểu giá trị Không hợp lệ',
            

        ];
    }
}