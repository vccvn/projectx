<?php
namespace App\Masks\Products;

use Crazy\Magic\MaskCollection;

class ProductCollection extends MaskCollection
{
    /**
     * lấy tên class mask tương ứng
     *
     * @return string
     */
    public function getMask()
    {
        return ProductMask::class;
    }
    // xem Collection mẫu ExampleCollection
}
