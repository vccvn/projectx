<?php

namespace App\Validators\Auth;

use App\Validators\Base\BaseValidator;

use App\Repositories\Users\UserRepository;

use App\Repositories\Web\SettingRepository;

class Register extends BaseValidator
{
    public function extends()
    {
        $this->addRule('unique_attr', function($name, $value, $parameters){
            $data = [$name => $value];
            if(is_array($parameters) && count($parameters)){
                foreach ($parameters as $attr) {
                    if($a = trim($attr)){
                        $data[$attr] = $this->{$attr};
                    }
                }
            }
            $this->repository->removeStaffQuery();
            $result = $this->repository->first($data);
            $this->repository->staffQuery();

            if($result){
                if($this->id && $this->id == $result->id){
                    return true;
                }
                return false;
            }
            return true;
        });
        $this->addRule('phone_exists', function($name, $value){
            if(!$value) return true;
            if($user = $this->repository->first(['phone_number'=>$value])){
                if($this->id){
                    if($this->id == $user->id){
                        return true;
                    }
                }
                return false;
            }
            return true;
        });

        $this->addRule('username', function($attr, $value){
            return preg_match('/^[A-z]+[A-z0-9_\.]*$/si', $value);
        });

    }
    /**
     * ham lay rang buoc du lieu
     */
    public function rules()
    {
        $rules = [
            'name'                => 'required|max:191',
            'email'               => 'required|email|unique_attr',
            'phone_number'        => 'phone_number|phone_exists',
            'avatar'              => 'mimes:jpg,jpeg,png,gif',
            'username'            => 'required|username|unique_attr|min:4|max:64',
            'password'            => 'required|string|min:6|confirmed'
        ];

        return $this->parseRules($rules);
    }

    public function messages()
    {
        return [
            'name.max'                             => 'Họ tên dài vựa quá số ký tự',
            'name.required'                        => 'Bạn chưa nhập họ và tên',
            

            'username.required'                    => 'Bạn chưa nhập tên Đăng nhập',
            'username.min'                         => 'Tên người dùng phải có ít nhất 2 ký tự',
            'username.username'                    => 'Tên đăng nhập không hợp lệ',
            'username.unique_attr'                 => 'Bạn không thể dùng username này',
            
            'email.required'                       => 'Bạn chưa nhập email',
            'email.email'                          => 'Email không hợp lệ',
            'email.unique_attr'                    => 'Do vấn đề bảo mật, Bạn không thể sử dụng email',
            
            'password.required'                    => 'Bạn chưa nhập mật khẩu',
            'password.min'                         => 'Mật khẩu phải có ít nhất 6 ký tự',
            'password.confirmed'                   => 'Mật khẩu không khớp',
            
            'phone_number.required'                => 'Số điện thoại không được bỏ trống',
            'phone_number.phone_number'            => 'Số điện thoại không hơp lệ',
            'phone_number.phone_exists'            => 'Số điện thoại Đã được sử dụng',
            '*.phone_number'                       => 'Số điện thoại không hơp lệ',

            'status.required'                      => 'Trạng thái không hợp lệ',
            

            'avatar.required'                      => 'Ảnh đại diện không được bỏ trống',
            'avatar.mimes'                         => 'Ảnh đại diện không đúng dịnh dạng',

        ];
    }
}