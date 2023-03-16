<?php
namespace App\Masks\Payments;

use Crazy\Magic\MaskCollection;

class MethodCollection extends MaskCollection
{
    /**
     * lấy tên class mask tương ứng
     *
     * @return string
     */
    public function getMask()
    {
        return MethodMask::class;
    }
    // xem Collection mẫu ExampleCollection
}
