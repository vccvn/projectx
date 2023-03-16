<?php
namespace App\Masks\Posts;

use Crazy\Magic\MaskCollection;

class PostCollection extends MaskCollection
{
    /**
     * lấy tên class mask tương ứng
     *
     * @return string
     */
    public function getMask()
    {
        return PostMask::class;
    }
    // xem Collection mẫu ExampleCollection
}
