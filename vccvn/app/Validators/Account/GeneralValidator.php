<?php

namespace App\Validators\Account;


class GeneralValidator extends BaseValidator
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
            'name'                => 'required|max:191',
            'phone_number'        => 'required|phone_number|phone_exists',
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
            
            'phone_number.required'                => 'Số điện thoại không được bỏ trống',
            'phone_number.phone_number'            => 'Số điện thoại không hơp lệ',
            'phone_number.phone_exists'            => 'Số điện thoại Đã được sử dụng',            

        ];
    }
}