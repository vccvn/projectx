<?php

namespace App\Validators\Products;

use App\Validators\Base\BaseValidator;

class WarehouseValidator extends BaseValidator
{
    public function extends()
    {
        // Thêm các rule ở đây
        $this->addRule('check_total', function($prop, $value){
            if(!is_numeric($value) || $value <= 0) return false;
            if(is_string($this->type) && strtolower($this->type) == 'export'){
                if($this->repository->countProduct($this->product_id, $this->id) - $value < 0) return false;
            }
            return true;
            
        });

        $this->addRule('check_type', function($prop, $value){
            return in_array(strtolower($value), ['import', 'export']);
        });
    }

    /**
     * ham lay rang buoc du lieu
     */
    public function rules()
    {
    
        return [
            'product_id'                    => 'required|exists:products,id',
            'type'                          => 'check_type',
            'total'                         => 'check_total',
            'note'                          => 'mixed'
        ];
    }

    /**
     * các thông báo
     */
    public function messages()
    {
        $totalMessage = strtolower($this->type) == 'export' ? (
            'Số lượng sản phẩm xuất kho ít nhất là 1 và không được lớn hơn số sản phẩm trong kho'
        ): 'Số lượng sản phẩm nhập kho không hợp lệ';
        
        return [
            'product_id.required'               => 'Thông tin sản phẩm không được bỏ trống',
            'product_id.unique_prop'            => 'Mỗi khách hàng chỉ được đánh giá một lần cho mỗi sản phẩm',
            'product_id.ezists'                 => 'Sản phẩm không tồn tại',
            'type.check_type'                   => 'Hành động không hợp lệ',
            'total.check_total'                 => $totalMessage
        ];
    }
}