<?php
namespace App\Masks\Users;

use Crazy\Magic\MaskCollection;

class AuthLogCollection extends MaskCollection
{
    /**
     * lấy tên class mask tương ứng
     *
     * @return string
     */
    public function getMask()
    {
        return AuthLogMask::class;
    }
    // xem Collection mẫu ExampleCollection
}
