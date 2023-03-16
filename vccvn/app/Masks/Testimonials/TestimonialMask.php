<?php
namespace App\Masks\Testimonials;

use App\Models\Testimonial;
use Crazy\Magic\Mask;

class TestimonialMask extends Mask
{

    // xem thêm ExampleMask
    /**
     * thêm các thiết lập của bạn
     * ví dụ thêm danh sách cho phép truy cập vào thuộc tính hay gọi phương thức trong model
     * hoặc map vs các quan hệ dữ liệu
     *
     * @return void
     */
    protected function init(){
        $this->allow('getAvatar');
    }

    /**
     * lấy data từ model sang mask
     * @param Testimonial $testimonial Tham số không bắt buộc phải khai báo. 
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
        $this->image = $this->getAvatar();
    }
    
    
    // khai báo thêm các hàm khác bên dưới nếu cần
}