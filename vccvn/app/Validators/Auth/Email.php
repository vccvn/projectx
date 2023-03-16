<?php

namespace App\Validators\Auth;

use App\Validators\Base\BaseValidator;

use App\Repositories\Users\UserRepository;

class Email extends BaseValidator
{
    /**
     * thêm rules
     */
    public function extends()
    {
        
    }
    /**
     * ham lay rang buoc du lieu
     */
    public function rules()
    {
    
        return [
            'email'            => 'required|email'
        ];
    }

    public function messages()
    {
        return [
            'email.required'                       => 'Bạn chưa nhập email',
            'email.email'                          => 'Email không hợp lệ',
            'email.user_email'                     => 'Email này đã bị khóa',

        ];
    }
}