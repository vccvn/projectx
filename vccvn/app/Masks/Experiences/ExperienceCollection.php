<?php
namespace App\Masks\Experiences;

use Crazy\Magic\MaskCollection;

class ExperienceCollection extends MaskCollection
{
    /**
     * lấy tên class mask tương ứng
     *
     * @return string
     */
    public function getMask()
    {
        return ExperienceMask::class;
    }
    // xem Collection mẫu ExampleCollection
}
