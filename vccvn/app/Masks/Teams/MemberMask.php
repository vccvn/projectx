<?php
namespace App\Masks\Teams;

use App\Models\TeamMember;
use Crazy\Magic\Mask;

class MemberMask extends Mask
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
     * @param TeamMember $teamMember Tham số không bắt buộc phải khai báo. 
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
        // $this->image = get_user_avatar($this->avatar);
        $this->avatar = get_user_avatar($this->avatar);
        
    }
    
    
    // khai báo thêm các hàm khác bên dưới nếu cần
}