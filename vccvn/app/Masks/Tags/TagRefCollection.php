<?php
namespace App\Masks\Tags;

use Crazy\Magic\MaskCollection;

class TagRefCollection extends MaskCollection
{
    /**
     * lấy tên class mask tương ứng
     *
     * @return string
     */
    public function getMask()
    {
        return TagRefMask::class;
    }
    // xem Collection mẫu ExampleCollection
}
