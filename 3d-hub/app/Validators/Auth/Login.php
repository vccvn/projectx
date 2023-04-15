<?php

namespace App\Validators\Auth;

use App\Validators\Base\BaseValidator;


class Login extends BaseValidator
{
    /**
     * ham lay rang buoc du lieu
     */
    public function rules()
    {
    
        return [
            'username'            => 'required',
            'password'            => 'required',
        ];

        // return $this->parseRules($rules);
    }

    public function messages()
    {
        return [
            'username.required'                    => 'Bạn chưa nhập tên Đăng nhập',
            'password.required'                    => 'Bạn chưa nhập mật khẩu',


        ];
    }
}