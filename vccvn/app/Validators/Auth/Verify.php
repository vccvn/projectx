<?php

namespace App\Validators\Auth;

use App\Validators\Base\BaseValidator;

use App\Repositories\Users\UserRepository;

class Verify extends BaseValidator
{
    /**
     * thêm rules
     */
    public function extends()
    {
        $this->addRule('not_verify', function ($prop, $value)
        {
            return $this->repository->count(['email' => $value, 'status' => 0]) == 1;
        });
    }
    /**
     * ham lay rang buoc du lieu
     */
    public function rules()
    {
    
        return [
            'email'            => 'required|email|not_verify'
        ];
    }

    public function messages()
    {
        return [
            'email.required'                       => 'Bạn chưa nhập email',
            'email.email'                          => 'Email không hợp lệ',
            'email.user_email'                     => 'Email này đã bị khóa',
            'email.email'                          => 'Email không hợp lệ',
            
        ];
    }
}