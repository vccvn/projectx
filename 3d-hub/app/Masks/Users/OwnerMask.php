<?php
namespace App\Masks\Users;

use App\Models\User;
use Crazy\Helpers\Arr;
use Crazy\Magic\Mask;

class OwnerMask extends Mask
{

    // xem thêm ExampleMask
    protected function init(){
        $this->allow('getAvatar');
        $this->map(['userWebSetting', 'profile' => ProfileMask::class]);
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

    public function getProfile()
    {
        
        $data = new Arr([
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'username' => $this->username,
            'phone_number' => $this->phone_number,
            'avatar' => $this->getAvatar()
        ]);
        if($this->profile){
            $p = $this->profile;
            $data->profile_id = $p->profile_id;
            $data->first_name = $p->profile_id;
            $data->last_name = $p->profile_id;
            $data->address = $p->profile_id;
            $data->gender = $p->gender;
            $data->birthday = $p->birthday;
            

        }
    }
    
    // khai báo thêm các hàm khác bên dưới nếu cần
}