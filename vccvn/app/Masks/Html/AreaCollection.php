<?php
namespace App\Masks\Html;

use Crazy\Magic\MaskCollection;

class AreaCollection extends MaskCollection
{
    /**
     * lấy tên class mask tương ứng
     *
     * @return string
     */
    public function getMask()
    {
        return AreaMask::class;
    }
    // xem Collection mẫu ExampleCollection
}
