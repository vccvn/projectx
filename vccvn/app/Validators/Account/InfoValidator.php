<?php

namespace App\Validators\Account;

class InfoValidator extends BaseValidator
{
    public function extends()
    {
        parent::extends();
        
        $this->addRule('check_gender', function($attr, $value){
            if(!$value) return true;
            return in_array($value, ['male', 'female']);
        });
    }

    /**
     * ham lay rang buoc du lieu
     */
    public function rules()
    {
    
        $rules = [
            'first_name'          => 'required|max:191',
            'last_name'           => 'required|max:191',
            'gender'              => 'required|check_gender',
            'birthday'            => 'required|arrdate:str',
            'address'             => 'mixed',
            'avatar'              => 'mimes:jpg,jpeg,png,gif',
            'avatar_data'         => 'base64_file:image',
            
            
        ];
        return $this->parseRules($rules);
    }

    /**
     * các thông báo
     */
    public function messages()
    {
        return [
            'name.max'                             => 'Họ tên dài vựa quá số ký tự',
            'name.required'                        => 'Bạn chưa nhập họ và tên',
            
            
            'first_name.required'                  => 'Tên không được bỏ trống',
            
            'last_name.required'                   => 'Họ và đệm không được bỏ trống',
            
            'gender.required'                      => 'Giới tính không được bỏ trống',
            'gender.chevk_gender'                  => 'Giới tính không hợp lệ',
            
            'birthday.required'                    => 'Ngày sinh không được bỏ trống',
            'birthday.strdate'                     => 'Ngày sinh không hợp lệ',
            
            'address.max'                          => 'Địa chỉ không hợp lệ',

        ];
    }
}