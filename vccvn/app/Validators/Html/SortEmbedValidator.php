<?php

namespace App\Validators\Html;

use App\Repositories\Html\AreaRepository;
use App\Validators\Base\BaseValidator;

class SortEmbedValidator extends BaseValidator
{
    public function extends()
    {
        $this->addRule('check_data', function($prop, $value){
            if(!$value) return true;
            $items = array_keys($value);
            // lấy ra mảng gồm các id
            return $this->repository->count(['id' => $items]) == count($items)? true : false;
        });

        $this->addRule('check_area_id', function($prop, $value){
            if(!$value) return false;
            return app(AreaRepository::class)->findBy('id', $value)? true : false;
        });
    }

    /**
     * ham lay rang buoc du lieu
     */
    public function rules()
    {
    
        return [
            'data.*.area_id'                       => 'check_area_id',
            'data.*.embeds'                        => 'check_data'
        ];
    }

    /**
     * các thông báo
     */
    public function messages()
    {
        return [
            'data.*.embeds.check_data'               => 'Dữ liệu không hợp lệ',
            'data.*.area_id.check_area_id'           => 'Mã vùng không hợp lệ'
        ];
    }
}