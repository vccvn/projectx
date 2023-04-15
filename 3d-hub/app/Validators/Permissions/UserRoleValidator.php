<?php

namespace App\Validators\Permissions;

use App\Validators\Base\BaseValidator;


use App\Repositories\Users\StaffRepository;

class UserRoleValidator extends BaseValidator
{
    public function extends()
    {
        $this->addRule('check_users', function($attr, $value){
            if(!$value) return true;
            if(!is_array($value)) return false;
            if(!count($value)) return true;
            $staffs = new StaffRepository();
            $staffs->staffQuery();
            foreach ($value as $user_id) {
                if(!$staffs->first(['id'=>$user_id])) return false;
            }
            return true;

        });
    }
    /**
     * ham lay rang buoc du lieu
     */
    public function rules()
    {
        $rules = [
            'role_id'             => 'required|exists:permission_roles,id',
            'users'               => 'check_users'
        ];
        return $rules;
    }

    public function messages()
    {
        return [
            'role_id.required'                     => 'Thông tin quyền không hợp lệ',
            'role_id.exists'                       => 'Thông tin quyền không hợp lệ',
            'users.check_users'                    => 'Thông tin người dùng không hợp lệ'
        ];
    }
}