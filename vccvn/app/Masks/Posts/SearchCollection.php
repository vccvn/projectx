<?php
namespace App\Masks\Posts;

use Crazy\Magic\MaskCollection;

class SearchCollection extends MaskCollection
{
    /**
     * lấy tên class mask tương ứng
     *
     * @return string
     */
    public function getMask()
    {
        return SearchMask::class;
    }
    // xem Collection mẫu ExampleCollection
}
