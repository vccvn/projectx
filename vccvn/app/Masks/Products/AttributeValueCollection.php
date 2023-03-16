<?php
namespace App\Masks\Products;

use Crazy\Magic\MaskCollection;

class AttributeValueCollection extends MaskCollection
{
    /**
     * lấy tên class mask tương ứng
     *
     * @return string
     */
    public function getMask()
    {
        return AttributeValueMask::class;
    }
    // xem Collection mẫu ExampleCollection
}
