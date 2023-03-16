<?php
namespace App\Masks\Orders;

use App\Models\OrderItem;
use Crazy\Magic\Mask;

class OrderItemMask extends Mask
{

    // xem thêm ExampleMask
    /**
     * thêm các thiết lập của bạn
     * ví dụ thêm danh sách cho phép truy cập vào thuộc tính hay gọi phương thức trong model
     * hoặc map vs các quan hệ dữ liệu
     *
     * @return void
     */
    // protected function init(){
    //     # code...
    // }

    /**
     * lấy data từ model sang mask
     * @param OrderItem $orderItem Tham số không bắt buộc phải khai báo. 
     * Xem thêm ExampleMask
     */
    // public function toMask()
    // {
    //     $data = $this->getAttrData();
    //     // thêm data tại đây.
    //     // Xem thêm ExampleMask
    //     return $data;
        
    // }

    /**
     * sẽ được gọi sau khi thiết lập xong
     *
     * @return void
     */
    protected function onLoaded()
    {
        $this->image = get_product_image($this->product_image);
        $this->link = get_product_url($this->model);
        $this->attributes = new ItemAttributeCollection($this->getAttrs());
        $this->total_price = $this->quantity * $this->final_price;


    }
    public function getPrice()
    {
        return $this->final_price;
    }
    public function getPriceFormat()
    {
        return get_currency_format($this->final_price);
    }

    public function getTotal()
    {
        return $this->quantity * $this->final_price;
    }

    public function getTotalFormat()
    {
        return get_currency_format($this->getTotal());
    }

    
    // khai báo thêm các hàm khác bên dưới nếu cần
}