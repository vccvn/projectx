<?php
namespace App\Masks\Tags;

use Crazy\Magic\MaskCollection;

class TagCollection extends MaskCollection
{
    /**
     * lấy tên class mask tương ứng
     *
     * @return string
     */
    public function getMask()
    {
        return TagMask::class;
    }
    // xem Collection mẫu ExampleCollection
}
