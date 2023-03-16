<?php
namespace App\Masks\Users;

use App\Models\User;
use Crazy\Magic\Mask;

class UserMask extends Mask
{
    // xem thêm ExampleMask
    protected function init(){
        $this->allow('getAvatar');
    }
}