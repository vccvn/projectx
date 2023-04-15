<?php

namespace App\Validators\Options;

use App\Validators\Base\BaseValidator;

class SortSettingItemValidator extends BaseValidator
{
    public function extends()
    {
        $this->addRule('check_data', function($prop, $value){
            $items = array_keys($value);
            return $this->repository->count(['id' => $items]) == count($items)? true : false;
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