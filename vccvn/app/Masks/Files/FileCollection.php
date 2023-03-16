<?php
namespace App\Masks\Files;

use Crazy\Magic\MaskCollection;

class FileCollection extends MaskCollection
{
    /**
     * lấy tên class mask tương ứng
     *
     * @return string
     */
    public function getMask()
    {
        return FileMask::class;
    }
    // xem Collection mẫu ExampleCollection
}
