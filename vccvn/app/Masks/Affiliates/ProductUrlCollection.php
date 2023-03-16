<?php
namespace App\Masks\Affiliates;

use Crazy\Magic\MaskCollection;

class ProductUrlCollection extends MaskCollection
{
    /**
     * lấy tên class mask tương ứng
     *
     * @return string
     */
    public function getMask()
    {
        return ProductUrlMask::class;
    }
    // xem Collection mẫu ExampleCollection
}
