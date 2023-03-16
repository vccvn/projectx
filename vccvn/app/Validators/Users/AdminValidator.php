<?php

namespace App\Validators\Users;

use App\Validators\Base\BaseValidator;

use App\Repositories\Web\SettingRepository;

class AdminValidator extends BaseValidator
{
    public function extends()
    {
        
        
    }
    /**
     * ham lay rang buoc du lieu
     */
    public function rules()
    {
        $id = $this->id;
        $password = $this->password;

        $rules = [
            'email'               => 'required|email|unique_prop',

        ];

        if(!$id || strlen($this->password)){
            $rules['password'] = 'required|min:6|confirmed';
        }
        return $rules; //$this->parseRules($rules);
    }

    public function messages()
    {
        return [
            'email.required'                       => 'Bạn chưa nhập email',
            'email.email'                          => 'Email không hợp lệ',
            'email.unique_prop'                    => 'Email đã tồn tại',
            'password.required'                    => 'Bạn chưa nhập mật khẩu',
            'password.min'                         => 'Mật khẩu phải có ít nhất 6 ký tự',
            'password.confirmed'                   => 'Mật khẩu không khớp'

        ];
    }
}
