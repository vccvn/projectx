<?php

namespace App\Validators\Notices;

use App\Validators\Base\BaseValidator;


use App\Repositories\Users\UserRepository;


class NoticeValidator extends BaseValidator
{
    public function extends()
    {
        $this->addRule('notice_type', function($prop, $value){
            if(is_null($value)) return true;
            return in_array(strtolower($value), ['personal', 'group', 'all', 'staff']);
        });

        $this->addRule('user_exists', function($prop, $value){
            if(strtolower($this->type) != 'personal') return true;
            
            return ($value && (new UserRepository())->find($value))?true:false;
        });

        $this->addRule('user_group', function($prop, $value){
            if(strtolower($this->type) != 'group') return true;

            if($list = get_user_config('type_list')){
                return isset($list[$value]);
            }
            return in_array(strtolower($value), ['user', 'admin', 'mod', 'content', 'owner', 'staff']);
        });

        

        
    }
    /**
     * ham lay rang buoc du lieu
     */
    public function rules()
    {
    
        return [
            'type'                => 'required|notice_type',
            'to_id'               => 'user_exists',
            'to_group'            => 'user_group',
            'title'               => 'required|string|max:191',
            'message'            => 'mixed',
            
        ];

        // return $this->parseRules($rules);
    }

    public function messages()
    {
        return [
            'type.required'                        => 'Loại Thông báo không được bỏ trống',
            'type.notice_type'                     => 'Loại Thông báo không hợp lệ',
            'to_id.user_exists'                    => 'Người dùng không tồn tại',
            'title.required'                       => 'Tiêu đề Thông báo không được bỏ trống',
            'title.string'                         => 'Tiêu đề Thông báo không hợp lệ',
            'title.max'                            => 'Tiêu đề Thông báo hơi... dài!',
            
        ];
    }
}