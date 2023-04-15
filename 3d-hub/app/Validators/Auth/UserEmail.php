<?php

namespace App\Validators\Auth;

use App\Validators\Base\BaseValidator;

use App\Repositories\Users\UserRepository;

class UserEmail extends BaseValidator
{
    /**
     * thêm rules
     */
    public function extends()
    {
        $this->addRule('user_email', function($prop, $value){
            $users = new UserRepository();
            if($users->findBy('email', $value)) return true;
            return false;
        });
    }
    /**
     * ham lay rang buoc du lieu
     */
    public function rules()
    {
    
        return [
            'email'            => 'required|email|user_email'
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