<?php

namespace App\Validators\Profiles;

use App\Validators\Base\BaseValidator;

class ProfileSkillValidator extends BaseValidator
{
    public function extends()
    {
        // Thêm các rule ở đây
        $this->addRule('unique_skill', function($prop, $value){
            $skills = $this->repository->get(['skill_id' => $value, 'profile_id' => $this->user()->id]);
            if($t = count($skills)){
                if(!$this->id || $t > 1) return false;
                foreach($skills as $skill){
                    if($this->id != $skill->id) return false;
                }
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
            'skill_id'                        => 'required|exists:skills,id|unique_skill',
            'percentage'                      => 'numeric|min:0|max:100',
            'show'                            => 'binary'
        ];
    }

    /**
     * các thông báo
     */
    public function messages()
    {
        return [
            'skill_id.required'               => 'Kỹ năng không được bỏ trống',
            'skill_id.exists'                 => 'Kỹ năng không hợp lệ',
            'skill_id.unique_skill'           => 'Kỹ năng đã tồn tại',
            'percentage.*'                    => 'Điểm kỹ năng không hợp lệ'
            
        ];
    }
}