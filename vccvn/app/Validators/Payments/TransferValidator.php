<?php

namespace App\Validators\Payments;

use App\Repositories\Orders\OrderRepository;
use App\Validators\Base\BaseValidator;

class TransferValidator extends BaseValidator
{
    /**
     * order repo
     *
     * @var \App\Repositories\Orders\OrderRepository
     */
    protected $orderRepository;
    public function extends()
    {
        $this->orderRepository = new OrderRepository();
        // Thêm các rule ở đây
        $this->addRule('check_order', function($prop, $value){
            return $this->orderRepository->count(['status' => 200, 'payment_method' => 1, 'id' => $value]) == 1;
        });

    }

    /**
     * ham lay rang buoc du lieu
     */
    public function rules()
    {
        return [
            'order_id'                          => 'required|check_order',
            'image'                             => 'required|mimes:jpg,jpeg,png,gif',
        ];
    }

    /**
     * các thông báo
     */
    public function messages()
    {
        return [
            'order_id.required'                 => 'Mã đơn hàng không được bỏ trống',
            'order_id.check_order'              => 'Mã đơn hàng không hợp lệ',
            'image.mimes'                       => 'File không hợp lệ',


        ];
    }
}
