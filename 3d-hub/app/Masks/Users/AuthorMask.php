<?php
namespace App\Masks\Users;

use App\Models\User;
use Crazy\Magic\Mask;

class AuthorMask extends Mask
{

    // xem thêm ExampleMask
    protected function init(){
        $this->allow('getAvatar');
    }

    /**
     * lấy data từ model sang mask
     * @param User $user Tham số không bắt buộc phải khai báo. 
     * Xem thêm ExampleMask
     */
    // public function toMask()
    // {
    //     $data = $this->getAttrData();
    //     // thêm data tại đây.
    //     // Xem thêm ExampleMask
    //     return $data;
        
    // }

    
    // khai báo thêm các hàm khác bên dưới nếu cần
}