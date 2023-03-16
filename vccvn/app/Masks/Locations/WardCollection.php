<?php
namespace App\Masks\Locations;

use Crazy\Magic\MaskCollection;

class WardCollection extends MaskCollection
{
    /**
     * lấy tên class mask tương ứng
     *
     * @return string
     */
    public function getMask()
    {
        return WardMask::class;
    }
    // xem Collection mẫu ExampleCollection
}
