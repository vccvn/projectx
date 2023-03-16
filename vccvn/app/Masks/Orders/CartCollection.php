<?php
namespace App\Masks\Orders;

use Crazy\Magic\MaskCollection;

class CartCollection extends MaskCollection
{
    /**
     * lấy tên class mask tương ứng
     *
     * @return string
     */
    public function getMask()
    {
        return CartMask::class;
    }
    // xem Collection mẫu ExampleCollection
}
