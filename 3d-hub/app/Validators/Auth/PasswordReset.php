<?php

namespace App\Validators\Auth;

use App\Validators\Base\BaseValidator;

class PasswordReset extends BaseValidator
{
    /**
     * thêm rules
     */
    public function extends()
    {
        $this->addRule('is_token', function($prop, $value){
            if($this->repository->checkToken($value)) return true;
            return false;
        });
    }
    /**
     * ham lay rang buoc du lieu
     */
    public function rules()
    {
    
        return [
            'token'            => 'required|is_token',
            'password'         => 'required|min:6|confirmed'
        ];
    }

    public function messages()
    {
        return [
            'token.required'                       => 'Token không hợp lệ',
            'token.is_token'                       => 'Token không hợp lệ',
            'password.required'                    => 'Mật khẩu không được bỏ trống',
            'password.min'                         => 'Mật khẩu quá ngắn.',
            'password.confirmed'                   => 'Mật khẩu không hợp lệ',
            
        ];
    }
}