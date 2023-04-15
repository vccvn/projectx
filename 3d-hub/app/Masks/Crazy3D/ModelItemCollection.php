<?php
namespace App\Masks\Crazy3D;

use Crazy\Magic\MaskCollection;

class ModelItemCollection extends MaskCollection
{
    /**
     * lấy tên class mask tương ứng
     *
     * @return string
     */
    public function getMask()
    {
        return ModelItemMask::class;
    }
    // xem Collection mẫu ExampleCollection
}
