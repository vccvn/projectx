<?php
namespace App\Masks\Orders;

use Crazy\Magic\MaskCollection;

class ItemAttributeCollection extends MaskCollection
{
    /**
     * lấy tên class mask tương ứng
     *
     * @return string
     */
    public function getMask()
    {
        return ItemAttributeMask::class;
    }
    // xem Collection mẫu ExampleCollection
}
