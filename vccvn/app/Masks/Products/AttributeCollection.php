<?php
namespace App\Masks\Products;

use Crazy\Magic\MaskCollection;

class AttributeCollection extends MaskCollection
{
    /**
     * lấy tên class mask tương ứng
     *
     * @return string
     */
    public function getMask()
    {
        return AttributeMask::class;
    }
    // xem Collection mẫu ExampleCollection
}
