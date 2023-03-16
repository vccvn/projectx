<?php
namespace App\Masks\Affiliates;

use App\Masks\Products\ProductMask;
use App\Models\AffiliateProductUrl;
use Crazy\Magic\Mask;

class ProductUrlMask extends Mask
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
            'priceFormat', 'getLogo'
        ]);
        $this->map([
            'affiliate' => AffiliateMask::class,
            'product'   => ProductMask::class
        ]);
    }

    /**
     * lấy data từ model sang mask
     * @param AffiliateProductUrl $affiliateProductUrl Tham số không bắt buộc phải khai báo. 
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
        $this->logo_url = $this->getLogo();
    }
    
    // khai báo thêm các hàm khác bên dưới nếu cần
}