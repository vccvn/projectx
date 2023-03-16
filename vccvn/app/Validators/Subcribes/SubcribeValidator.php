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
        $rules = [];
        if($this->phone_number){
            $rules['phone_number']                 = ($this->email?"":"required|"). 'phone_number';
        }
        $rules['email']                            = $this->phone_number ? 'email': 'required|email|unique_prop';
        return $rules;
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
            'phone_number.required'                => 'Số điện thoại không được bỏ trống',
            'phone_number.phone_number'            => 'Số điện thoại không hơp lệ',
            'phone_number.phone_exists'            => 'Số điện thoại Đã được sử dụng',
        ];
    }
}