<?php

namespace App\Masks\Orders;

use App\Masks\Payments\MethodMask;
use App\Models\Orders;
use Crazy\Magic\Mask;

class OrderMask extends Mask
{
    public static $status_list = [];
    public static $payment_methods = [];

    // xem thêm ExampleMask
    /**
     * thêm các thiết lập của bạn
     * ví dụ thêm danh sách cho phép truy cập vào thuộc tính hay gọi phương thức trong model
     * hoặc map vs các quan hệ dữ liệu
     *
     * @return void
     */
    protected function init()
    {
        if (!static::$status_list) {
            static::$status_list = get_order_status_list();
        }
        if (!static::$payment_methods) {
            static::$payment_methods = get_order_payment_methods();
        }
        $this->map([
            'details' => OrderItemCollection::class,
            'billing' => OrderAddressMask::class,
            'shipping' => OrderAddressMask::class,
            'paymentMethod' => MethodMask::class
        ]);
        $this->allow('canCancel', 'isTransferPayment', 'isStatus', 'getDatetime');
    }

    public function getStatusLabel()
    {
        if (static::$status_list) {
            foreach (static::$status_list as $key => $status) {
                if ($this->status == $status['code']) return $status['label'];
            }
        }
        return "Không xác định";
    }
    public function getPaymentMethodText()
    {
        if ($this->paymentMethod) {
            return $this->paymentMethod->name;
        }
        return "Không xác định";
    }

    public function is($status)
    {
        return $this->isStatus($status);
    }


    /**
     * kiểm tra phương thức thanh toán
     *
     * @param string|int $method
     * @return boolean
     */
    public function isPaymentMethod($method = null)
    {
        if (is_null($method)) return false;
        if($this->paymentMethod){
            return $this->paymentMethod->method == $method;
        }
        return false;
    }
}
