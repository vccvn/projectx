<?php

namespace App\Validators\Account;

class AccountValidator extends BaseValidator
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
            'email'                                => 'required|email|unique_attr',
            'username'                             => 'required|username|unique_attr|min:4|max:64',
            'current_password'                     => 'required|password_match'
        ];
    }

    /**
     * các thông báo
     */
    public function messages()
    {
        return [
            
            'username.required'                    => 'Bạn chưa nhập tên Đăng nhập',
            'username.min'                         => 'Tên người dùng phải có ít nhất 2 ký tự',
            'username.username'                    => 'Tên đăng nhập không hợp lệ',
            'username.unique_attr'                 => 'Bạn không thể dùng username này',
            
            'email.required'                       => 'Bạn chưa nhập email',
            'email.email'                          => 'Email không hợp lệ',
            'email.unique_attr'                    => 'Do vấn đề bảo mật, Bạn không thể sử dụng email',
            
            'current_password.required'            => 'Bạn chưa nhập mật khẩu',
            'current_password.password_match'      => 'Mật khẩu không khớp',
        ];
    }
}