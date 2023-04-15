<?php
namespace App\Masks\Users;

use Crazy\Magic\MaskCollection;

class UserCollection extends MaskCollection
{
    /**
     * lấy tên class mask tương ứng
     *
     * @return string
     */
    public function getMask()
    {
        return UserMask::class;
    }
    // xem Collection mẫu ExampleCollection
}
