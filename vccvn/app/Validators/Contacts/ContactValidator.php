<?php

namespace App\Validators\Contacts;

use App\Validators\Base\BaseValidator;

class ContactValidator extends BaseValidator
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
            'name'                                    => 'required|max:191',
            'email'                                   => 'required|email',
            'phone_number'                            => 'phone_number',
            'address'                                 => 'mixed',
            'subject'                                 => 'mixed|max:191',
            'message'                                 => 'required',
            
        ];
    }

    /**
     * các thông báo
     */
    public function messages()
    {
        return [
            
            'name.required' => 'Bạn chưa nhập họ tên',
            'email.required' => 'Bạn chưa nhập email',
            'message.required' => 'Bạn chưa nhập nội dung',
            
            'email.email' => 'Email không hợp lệ',
            'phone_number.phone_number' => 'Số điện thoại không hợp lệ',
        ];
    }
}