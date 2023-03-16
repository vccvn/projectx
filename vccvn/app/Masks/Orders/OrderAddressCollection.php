<?php
namespace App\Masks\Orders;

use Crazy\Magic\MaskCollection;

class OrderAddressCollection extends MaskCollection
{
    /**
     * lấy tên class mask tương ứng
     *
     * @return string
     */
    public function getMask()
    {
        return OrderAddressMask::class;
    }
    // xem Collection mẫu ExampleCollection
}
