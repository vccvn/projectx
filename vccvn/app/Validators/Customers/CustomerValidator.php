<?php

namespace App\Validators\Customers;

use App\Repositories\Users\UserRepository;
use App\Validators\Base\BaseValidator;

class CustomerValidator extends BaseValidator
{
    public function extends()
    {
        // Thêm các rule ở đây
        $this->addRule('check_user', function($prop, $value){
            if(!$value) return true;
            return ((new UserRepository())->staffQuery()->count(['id' => $value]) >= 1);
        });

        $this->addRule('check_balance', function($prop, $value){
            if(!$value) return true;
            return to_number($value) >= 0;
        });
    }

    /**
     * ham lay rang buoc du lieu
     */
    public function rules()
    {
    
        $id = $this->user_id;
        return [
            'user_id'                              => 'check_user',
            'name'                                 => $id?'mixed':'required|string|max:191',
            'address'                              => 'mixed',
            'email'                                => (!$id || $this->email) ?'email|unique_prop':'mixed',
            'phone_number'                         => 'phone_number',
            'balance'                              => 'check_balance'
        ];
    }

    /**
     * các thông báo
     */
    public function messages()
    {
        return [
            'user_id.check_user'                   => 'Người dùng không hợp lệ',
            'name.max'                             => 'Họ tên dài vựa quá số ký tự',
            'name.required'                        => 'Bạn chưa nhập họ và tên',
            
            'email.required'                       => 'Bạn chưa nhập email',
            'email.email'                          => 'Email không hợp lệ',
            'email.unique_prop'                    => 'Email đã tồn tại',
            
            'phone_number.required'                => 'Số điện thoại không được bỏ trống',
            'phone_number.phone_number'            => 'Số điện thoại không hơp lệ',
            '*.phone_number'                       => 'Số điện thoại không hơp lệ',
        ];
    }
}