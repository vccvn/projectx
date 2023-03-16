<?php

namespace App\Validators\Account;

class PasswordValidator extends BaseValidator
{
    public function extends()
    {
        parent::extends();
    }

    /**
     * ham lay rang buoc du lieu
     */
    public function rules()
    {
    
        return [
            'current_password' => 'required|password_match',
            'password' => 'required|string|min:6|confirmed'
            
        ];
    }

    /**
     * các thông báo
     */
    public function messages()
    {
        return [
            '*.required' => 'Không được bỏ trống trường này',
            'current_password.password_match' => 'Mật khẩu không hợp lệ',
            'password.confirmed' => 'Mật khẩu mới không khớp'
        ];
    }
}