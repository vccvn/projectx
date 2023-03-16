<?php
namespace App\Masks\Dynamics;

use Crazy\Magic\MaskCollection;

class DynamicCollection extends MaskCollection
{
    /**
     * lấy tên class mask tương ứng
     *
     * @return string
     */
    public function getMask()
    {
        return DynamicMask::class;
    }
    // xem Collection mẫu ExampleCollection
}
