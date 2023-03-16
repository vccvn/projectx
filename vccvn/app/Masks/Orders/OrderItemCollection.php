<?php
namespace App\Masks\Orders;

use Crazy\Magic\MaskCollection;

class OrderItemCollection extends MaskCollection
{
    /**
     * lấy tên class mask tương ứng
     *
     * @return string
     */
    public function getMask()
    {
        return OrderItemMask::class;
    }
    // xem Collection mẫu ExampleCollection
}
