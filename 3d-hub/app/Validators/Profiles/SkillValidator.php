<?php

namespace App\Validators\Profiles;

use App\Validators\Base\BaseValidator;
use App\Repositories\Profiles\WorkRepository;

class SkillValidator extends BaseValidator
{
    public function extends()
    {
        // Thêm các rule ở đây
        $this->addRule('check_work', function($prop, $value){
            if(!$value) return true;
            return (new WorkRepository())->find($value)?true:false;
        });

    }

    /**
     * ham lay rang buoc du lieu
     */
    public function rules()
    {
    
        return [
            'work_id'                 => 'check_work',
            'type'                    => 'in_list:hard,soft',
            'name'                    => 'required|unique_prop:work_id,type',
            'description'             => 'mixed'
        ];
    }

    /**
     * các thông báo
     */
    public function messages()
    {
        return [
            'work_id.check_word'      => 'Công việc không hợp lệ',
            'type.in_list'            => 'Loại kỹ năng không hợp lệ',
            'name.required'           => 'Tên kỹ năng không được bỏ trống',
            'name.unique_prop'        => 'Ten kỹ năng không hợp lệ'
        ];
    }
}