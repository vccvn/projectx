<?php

namespace App\Validators\Account;

class CustomerValidator extends BaseValidator
{
    public function extends()
    {
        // parent::extends();
        $this->addRule('unique_attr', function($name, $value, $parameters){
            $data = [$name => $value];
            if(is_array($parameters) && count($parameters)){
                foreach ($parameters as $attr) {
                    if($a = trim($attr)){
                        $data[$attr] = $this->{$attr};
                    }
                }
            }
            if($result = $this->repository->first($data)){
                if(($user = $this->user()) && ($customer = $this->repository->findBy('user_id', $user->id)) && $customer->id == $result->id){
                    return true;
                }
                return false;
            }
            return true;
        });
    }

    /**
     * ham lay rang buoc du lieu
     */
    public function rules()
    {
    
        return [
            
            'name'                                 => 'required|string|max:191',
            'address'                              => 'mixed',
            'email'                                => 'required|email|unique_attr',
            'phone_number'                         => 'phone_number',
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
            'email.unique_attr'                    => 'Email đã tồn tại',
            
            'phone_number.required'                => 'Số điện thoại không được bỏ trống',
            'phone_number.phone_number'            => 'Số điện thoại không hơp lệ',
            '*.phone_number'                       => 'Số điện thoại không hơp lệ',

        ];
    }
}