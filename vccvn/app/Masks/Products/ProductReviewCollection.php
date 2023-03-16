<?php
namespace App\Masks\Products;

use Crazy\Magic\MaskCollection;

class ProductReviewCollection extends MaskCollection
{
    /**
     * lấy tên class mask tương ứng
     *
     * @return string
     */
    public function getMask()
    {
        return ProductReviewMask::class;
    }
    // xem Collection mẫu ExampleCollection
}
