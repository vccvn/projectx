<?php
namespace App\Masks\Examples;

use Crazy\Magic\MaskCollection;

class ExampleCollection extends MaskCollection
{
    /**
     * lấy tên class mask tương ứng
     *
     * @return string
     */
    public function getMask()
    {
        return ExampleMask::class;
    }
}
