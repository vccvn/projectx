<?php

namespace App\Validators\Sliders;

use App\Validators\Base\BaseValidator;

class SortItemValidator extends BaseValidator
{
    public function extends()
    {
        // Thêm các rule ở đây
        $this->addRule('check_data', function($prop, $value){
            $items = array_keys($value);
            // lấy ra mảng gồm các id
            return $this->repository->count(['id' => $items]) == count($items)? true : false;
        });
    }

    /**
     * ham lay rang buoc du lieu
     */
    public function rules()
    {
    
        return [
            'items'                            => 'check_data'
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