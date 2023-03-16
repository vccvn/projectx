<?php
namespace App\Masks\Packages;

use App\Models\WebAccountLimitedUpgradePayment;
use App\Models\WebAccountPackage;
use Crazy\Magic\Mask;

class WebAccountLimitedUpgradePaymentMask extends Mask
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
        $this->map([
            'package' => WebAccountPackageMask::class
        ]);
    }

    /**
     * lấy data từ model sang mask
     * @param WebAccountLimitedUpgradePayment $webAccountLimitedUpgradePayment Tham số không bắt buộc phải khai báo. 
     * Xem thêm ExampleMask
     */
    // public function toMask()
    // {
    //     // dd($this->model);
    //     // $data = $this->getAttrData();
    //     // // thêm data tại đây.
    //     // // Xem thêm ExampleMask
    //     // return $data;
        
    // }

    /**
     * sẽ được gọi sau khi thiết lập xong
     *
     * @return void
     */
    protected function onLoaded()
    {
        
    }
    
    
    // khai báo thêm các hàm khác bên dưới nếu cần
}