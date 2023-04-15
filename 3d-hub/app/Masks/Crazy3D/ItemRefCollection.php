<?php
namespace App\Masks\Crazy3D;

use Crazy\Magic\MaskCollection;

class ItemRefCollection extends MaskCollection
{
    /**
     * lấy tên class mask tương ứng
     *
     * @return string
     */
    public function getMask()
    {
        return ItemRefMask::class;
    }
    // xem Collection mẫu ExampleCollection
}
