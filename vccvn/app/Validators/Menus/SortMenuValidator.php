<?php

namespace App\Validators\Menus;

use App\Validators\Base\BaseValidator;

class SortMenuValidator extends BaseValidator
{
    public function extends()
    {
        $this->addRule('check_data', function($prop, $value){
            $items = array_keys($value);
            // lấy ra mảng gồm các id
            return $this->repository->count(['id' => $items]) == count($items)? true : false;
        });
    }
    public function rules()
    {
        return [
            'data'                            => 'check_data'
        ];
    }

    public function messages()
    {
        return [
            'data.check_data'               => 'Dữ liệu không hợp lệ'
            
        ];
    }
}