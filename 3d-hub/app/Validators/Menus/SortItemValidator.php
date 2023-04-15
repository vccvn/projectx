<?php

namespace App\Validators\Menus;

use App\Validators\Base\BaseValidator;

class SortItemValidator extends BaseValidator
{
    public function getItemIDs($list, $data = [])
    {
        if(is_array($list)){
            foreach ($list as $key => $item) {
                if(isset($item['id']) && $item['id']){
                    $data[] = $item['id'];
                }
                if(isset($item['children']) && count($item['children'])){
                    $data = $this->getItemIDs($item['children'], $data);
                }
            }
        }
        return $data;
    }

    public function extends()
    {
        // Thêm các rule ở đây
        $this->addRule('check_data', function($prop, $value){
            $listID = $this->getItemIDs($value);
            return $this->repository->count(['id' => $listID]) == count($listID);
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