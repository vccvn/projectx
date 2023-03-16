<?php

namespace App\Validators\Account;

class SecurityValidator extends BaseValidator
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
    
        $rules = [
            'email'                                => 'required|email|unique_attr',
            'username'                             => 'required|username|unique_attr|min:4|max:64',
            'phone_number'                         => 'required|phone_number|phone_exists',
            'current_password'                     => 'required|password_match'
        ];
        $password = $this->password;
        
        if(!$this->id || strlen($this->password)){
            $rules['password'] = 'required|string|min:6|confirmed';
        }

        return $this->parseRules($rules);
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
            
            'phone_number.required'                => 'Số điện thoại không được bỏ trống',
            'phone_number.phone_number'            => 'Số điện thoại không hơp lệ',
            'phone_number.phone_exists'            => 'Số điện thoại Đã được sử dụng',

            'current_password.required'            => 'Bạn chưa nhập mật khẩu',
            'current_password.password_match'      => 'Mật khẩu không khớp',

            
            'password.required'                    => 'Bạn chưa nhập mật khẩu',
            'password.min'                         => 'Mật khẩu phải có ít nhất 6 ký tự',
            'password.confirmed'                   => 'Mật khẩu không khớp',
            
        ];
    }
}