<?php
namespace App\Masks\Sliders;

use Crazy\Magic\MaskCollection;

class ItemCollection extends MaskCollection
{
    /**
     * lấy tên class mask tương ứng
     *
     * @return string
     */
    public function getMask()
    {
        return ItemMask::class;
    }
    // xem Collection mẫu ExampleCollection
}
