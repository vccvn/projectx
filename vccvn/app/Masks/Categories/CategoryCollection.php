<?php
namespace App\Masks\Categories;

use Crazy\Magic\MaskCollection;

class CategoryCollection extends MaskCollection
{
    /**
     * lấy tên class mask tương ứng
     *
     * @return string
     */
    public function getMask()
    {
        return CategoryMask::class;
    }
    // xem Collection mẫu ExampleCollection
}
