<?php
namespace App\Masks;

use Crazy\Magic\MaskCollection as Collection;

class MaskCollection extends Collection
{
    /**
     * lấy tên class mask tương ứng
     *
     * @return string
     */
    public function getMask()
    {
        return Mask::class;
    }
    // xem Collection mẫu ExampleCollection
}
