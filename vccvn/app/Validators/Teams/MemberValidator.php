<?php

namespace App\Validators\Teams;

use App\Validators\Base\BaseValidator;

class MemberValidator extends BaseValidator
{
    public function extends()
    {

    }

    /**
     * ham lay rang buoc du lieu
     */
    public function rules()
    {
    
        return [
            
            'team_id'                          => 'required|exists:teams,id',
            'member_id'                        => 'required|exists:users,id|unique_prop:team_id',
            'is_leader'                        => 'binary',
            'job'                              => 'mixed',

        ];
    }

    /**
     * các thông báo
     */
    public function messages()
    {
        return [
            
            'team_id.required'                 => 'Nhóm không được bỏ trống',
            'team_id.exists'                   => 'Nhóm không tồn tại',
            'member_id.required'               => 'Thành viên không được bỏ trống',
            'member_id.exists'                 => 'Thành viên không tồn tại',
            'member_id.unique_prop'            => 'Thành viên đã tồn tại',
            'is_leader.check_leader'           => 'Mỗi nhóm chỉ được có một nhóm trưởng'

        ];
    }
}