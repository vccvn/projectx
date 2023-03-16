<?php
namespace App\Masks\Sliders;

use Crazy\Magic\MaskCollection;

class SliderCollection extends MaskCollection
{
    /**
     * lấy tên class mask tương ứng
     *
     * @return string
     */
    public function getMask()
    {
        return SliderMask::class;
    }
    // xem Collection mẫu ExampleCollection
}
