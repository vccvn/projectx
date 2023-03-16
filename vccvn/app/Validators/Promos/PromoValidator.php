<?php

namespace App\Validators\Promos;

use App\Validators\Base\BaseValidator;
use App\Repositories\Products\ProductRepository;
use App\Repositories\Users\UserRepository;

class PromoValidator extends BaseValidator
{
    public function extends()
    {
        $this->addRule('check_down_price', function($prop, $value){
            if(!$value) return true;
            if(!is_numeric($value)) return false;
            return ($this->type == 1 && $value > 100) ? false : true;
        });

        $this->addRule('check_products', function($prop, $value){
            if(!$value) return true;
            if(!is_array($value)) return false;
            return (count($value) == (new ProductRepository())->count(['id' => $value]));
        });

        $this->addRule('check_users', function($prop, $value){
            if(!$value) return true;
            if(!is_array($value)) return false;
            return (count($value) == (new UserRepository())->count(['id' => $value]));
        });

        
    }
    /**
     * ham lay rang buoc du lieu
     */
    public function rules()
    {
    
        $rules = [
            'name'                            => 'required|string|max:191|unique_prop',
            'description'                     => 'max:500',
            'scope'                           => 'in_list:order,product,user',
            'type'                            => 'binary',
            'down_price'                      => 'check_down_price',
            'code'                            => 'max:32',
            'times'                           => 'datetimerange'
        ];
        if($this->scope == 'order'){
            $rules = array_merge($rules, [
                'limited_total'               => 'required|numeric|min:1'
            ]);
        }elseif($this->scope == 'user'){
            $rules = array_merge($rules, [
                'quantity_per_user'           => 'required|numeric|min:1',
                'user_list'                   => 'required|check_users'
            ]);
        }else{
            $rules = array_merge($rules, [
                'products'                    => 'check_products',
                
            ]);
        }

        
        
        return $rules;
        // return $this->parseRules($rules);
    }

    public function messages()
    {
        return [
            'name.required'                    => 'Tên chương trình khuyến mãi không được bỏ trống',
            'name.string'                      => 'Tên chương trình khuyến mãi không hợp lệ',
            'name.max'                         => 'Tên chương trình khuyến mãi hơi... dài!',
            'name.unique_prop'                 => 'Tên chương trình khuyến mãi bị trùng lặp',
            'description.max'                  => 'Mô tả hơi dài',
            'down_price.check_down_price'      => 'Mức khuyến mãi',
            'code.max'                         => 'Mã khuyến mãi không được vượt quá 32 ký tự',
            'products.check_products'          => 'Hình như có một vài sản phẩm không hợp lệ',
            'times.datetimerange'              => 'Thời gian khuyến mãi không hợp lệ',
            'limited_total.required'           => 'Vui lòng nhập số lượng khuyến mãi',
            'limited_total.numeric'            => 'Số lượng khuyến mãi phải là kiểu số',
            'limited_total.min'                => 'Số lượng khuyến mãi phải lớn hơn hoặc bằng 1',
            'quantity_per_user.required'       => 'Vui lòng nhập số lượng áp dụng cho mỗi người',
            'quantity_per_user.numeric'        => 'Số lượng áp dụng cho mỗi người phải là kiểu số',
            'quantity_per_user.min'            => 'Số lượng áp dụng cho mỗi người phải lớn hơn hoặc bằng 1',
            'user_list.*'                      => 'Danh sách người dùng ko hợp lệ'
        ];
    }
}