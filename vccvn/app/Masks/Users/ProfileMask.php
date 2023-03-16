<?php
namespace App\Masks\Users;

use App\Models\Profile;
use Crazy\Helpers\Arr;
use Crazy\Magic\Mask;

class ProfileMask extends Mask
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
     * @param Profile $profile Tham số không bắt buộc phải khai báo. 
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
        $d = [];
        if($this->birthday){
            $d = strtodate($this->birthday);
        }
        $this->birthDate = new Arr($d);
    }
    
    public function getBirthdayFormat($format = 'd.m/Y')
    {
        return date($format, strtotime($this->birthday));
    }

    public function getAge()
    {
        return date('y') - ($this->birthdate->year ? $this->birthdate->year : 1990);
    }
    
    // khai báo thêm các hàm khác bên dưới nếu cần
}