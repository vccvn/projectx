<?php

namespace App\Validators\Clients;

use App\Validators\Base\BaseValidator;

class ClientValidator extends BaseValidator
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
            'name'                                 => 'required|string|max:191',
            'address'                              => 'mixed',
            'email'                                => 'required|email|unique_prop',
            'phone_number'                         => 'phone_number',
            'avatar'                               => 'mimes:jpg,jpeg,png,gif',
        ];
    }

    /**
     * các thông báo
     */
    public function messages()
    {
        return [
            'name.max'                             => 'Họ tên dài vựa quá số ký tự',
            'name.required'                        => 'Bạn chưa nhập họ và tên',
            
            'email.required'                       => 'Bạn chưa nhập email',
            'email.email'                          => 'Email không hợp lệ',
            'email.unique_prop'                    => 'Email đã tồn tại',
            
            'phone_number.required'                => 'Số điện thoại không được bỏ trống',
            'phone_number.phone_number'            => 'Số điện thoại không hơp lệ',
            '*.phone_number'                       => 'Số điện thoại không hơp lệ',

            'avatar.required'                      => 'Ảnh đại diện không được bỏ trống',
            'avatar.mimes'                         => 'Ảnh đại diện không đúng dịnh dạng',


        ];
    }
}