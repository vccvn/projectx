<?php

namespace App\Validators\Orders;

use App\Validators\Base\BaseValidator;
use App\Repositories\Orders\OrderRepository;

class FeedbackValidator extends BaseValidator
{
    public function extends()
    {
        // Thêm các rule ở đây
        $this->addRule('check_order', function($prop, $value){
            return ((new OrderRepository())->count(['id' => $value, 'customer_id' => $this->customer_id]) >= 1);
        });
        $this->addRule('check_type', function($prop, $value){
            return in_array(strtolower($value), ['feedback', 'complain', 'return']);
        });
    }

    /**
     * ham lay rang buoc du lieu
     */
    public function rules()
    {
    
        return [
            'customer_id'                       => 'required|exists:customers,id',
            'order_id'                          => 'required|check_order',
            'type'                              => 'required|check_type',
            'title'                             => 'required|string|max:191',
            'description'                       => 'mixed'
        ];
    }

    /**
     * các thông báo
     */
    public function messages()
    {
        return [
            'customer_id.required'              => 'Thông tin sản Khách hàng được bỏ trống',
            'customer_id.ezists'                => 'Khách hàng không tồn tại',
            'order_id.required'                 => 'Mã đơn hàng không được bỏ trống',
            'order_id.check_order'              => 'Mã đơn hàng không hợp lệ',
            'product_id.ezists'                 => 'Sản phẩm không tồn tại',
            'type.required'                     => 'Loại phẩn hồi không dược bỏ trống',
            'type.check_type'                   => 'Loại phản hồi không hợp lệ',
            'title.required'                    => 'Tiêu đề không được bỏ trống',
            'title.string'                      => 'Tiêu đề không hợp lệ',
            'title.max'                         => 'Tiêu đề không được vượt quá 160 ký tự',
        ];
    }
}