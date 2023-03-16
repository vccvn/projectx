<?php
namespace App\MasksSUB;

use Crazy\Magic\MaskCollection;

class NAMECollection extends MaskCollection
{
    /**
     * lấy tên class mask tương ứng
     *
     * @return string
     */
    public function getMask()
    {
        return MASKMask::class;
    }
    // xem Collection mẫu ExampleCollection
}
