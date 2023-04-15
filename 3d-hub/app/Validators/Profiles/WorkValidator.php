<?php

namespace App\Validators\Profiles;

use App\Validators\Base\BaseValidator;


class WorkValidator extends BaseValidator
{
    /**
     * ham lay rang buoc du lieu
     */
    public function rules()
    {
    
        return [
            'title'               => 'required|string|max:191',
            'work_group'          => 'mixed',
            'description'         => 'mixed'
        ];

        // return $this->parseRules($rules);
    }

    public function messages()
    {
        return [
            'title.required'                        => 'Tên công việc không được bỏ trống',
            'title.string'                          => 'tên công việc không hợp lệ',
            'title.max'                             => 'tên công việc hơi... dài!'
        ];
    }
}