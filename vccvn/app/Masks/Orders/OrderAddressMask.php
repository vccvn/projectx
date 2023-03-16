<?php
namespace App\Masks\Orders;

use App\Masks\Locations\DistrictMask;
use App\Masks\Locations\RegionMask;
use App\Masks\Locations\WardMask;
use App\Models\OrderAddress;
use Crazy\Magic\Mask;

class OrderAddressMask extends Mask
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
            'getFullAddressText' => 'getfulladdresstext'
        ]);
        $this->map([
            'region' => RegionMask::class,
            'district' => DistrictMask::class,
            'ward' => WardMask::class
        ]);
    }

    /**
     * lấy data từ model sang mask
     * @param OrderAddress $orderAddress Tham số không bắt buộc phải khai báo. 
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
    // protected function onLoaded()
    // {
    //     # code...
    // }
    
    
    // khai báo thêm các hàm khác bên dưới nếu cần
}