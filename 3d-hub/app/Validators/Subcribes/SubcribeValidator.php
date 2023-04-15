<?php

namespace App\Validators\Subcribes;

use App\Validators\Base\BaseValidator;

class SubcribeValidator extends BaseValidator
{
    public function extends()
    {
        // Thêm các rule ở đây
    }

    /**
     * ham lay rang buoc du lieu
     */
    public function rules()
    {
    
        return [
            'email'                                => 'required|email|unique_prop',

        ];
    }

    /**
     * các thông báo
     */
    public function messages()
    {
        return [
            'email.required'                       => 'Bạn chưa nhập email',
            'email.email'                          => 'Email không hợp lệ',
            'email.unique_prop'                    => 'Email này đã dùng để đăng ký rồi',

        ];
    }
}