<?php

namespace App\Validators\Forms;

use App\Validators\Base\BaseValidator;

class FormValidator extends BaseValidator
{
    public function extends()
    {
        $this->addRule('check_slug', function($attr, $value){
            if(!$value) $value = str_slug($this->name);
            return $this->checkUniqueProp($attr, $value);

        });
    }

    /**
     * ham lay rang buoc du lieu
     */
    public function rules()
    {
    
        return [
            
            'name' => 'required|unique_prop',
            'slug' => 'check_slug',
            'inputs' => 'required|array',
            'inputs.*' => 'prop_input',

        ];
    }

    /**
     * các thông báo
     */
    public function messages()
    {
        return [
            
            'name.required' => 'Tên Form Không được bỏ trống',
            'name.unique_prop' => 'Tên Form Dã được sử dụng',
            'slug.check_slug' => 'slug Không hợp lệ',
            'inputs.required' => 'inputs Không hợp lệ',
            'inputs.*.prop_input' => 'Trường này không hợp lệ',
            'deleted.mixed' => 'deleted Không hợp lệ',

        ];
    }
}