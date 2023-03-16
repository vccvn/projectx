<?php
namespace App\Masks\Orders;

use Crazy\Magic\MaskCollection;

class OrderCollection extends MaskCollection
{
    /**
     * lấy tên class mask tương ứng
     *
     * @return string
     */
    public function getMask()
    {
        return OrderMask::class;
    }
    // xem Collection mẫu ExampleCollection
}
