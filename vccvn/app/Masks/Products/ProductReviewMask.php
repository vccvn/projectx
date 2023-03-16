<?php
namespace App\Masks\Products;

use App\Models\ProductReview;
use Crazy\Magic\Mask;

class ProductReviewMask extends Mask
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
        $this->allow([
            'getAvatar', 'getFeatureImage'
        ]);
    }

    /**
     * lấy data từ model sang mask
     * @param ProductReview $productReview Tham số không bắt buộc phải khai báo. 
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
        $this->review_name = $this->name?$this->name:(
            $this->customer_name?$this->customer_name:(
                $this->user_name
            )
        );
        $this->review_email = $this->email?$this->email:(
            $this->customer_email?$this->customer_email:(
                $this->user_email
            )
        );
        
    }
    public function timeFormat($format = 'd/m/Y')
    {
        return date($format, strtotime($this->created_at));
    }
    
    // khai báo thêm các hàm khác bên dưới nếu cần
}