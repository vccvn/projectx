<?php

namespace App\Validators\Profiles;

use App\Validators\Base\BaseValidator;

class SortSkillValidator extends BaseValidator
{
    protected $user_id = 0;
    public function extends()
    {
        $this->user_id = $this->user()->id;
        // Thêm các rule ở đây
        $this->addRule('check_data', function($prop, $value){
            $items = array_keys($value);
            return $this->repository->count(['id' => $items, 'profile_id' => $this->user_id]) == count($items)? true : false;
        });
    }

    /**
     * ham lay rang buoc du lieu
     */
    public function rules()
    {
    
        return [
            'data'                            => 'check_data'
        ];
    }

    /**
     * các thông báo
     */
    public function messages()
    {
        return [
            'data.check_data'               => 'Dữ liệu không hợp lệ'
            
        ];
    }
}