<?php
namespace App\Masks\Crazy3D;

use Crazy\Magic\MaskCollection;

class TemplateCollection extends MaskCollection
{
    /**
     * lấy tên class mask tương ứng
     *
     * @return string
     */
    public function getMask()
    {
        return TemplateMask::class;
    }
    // xem Collection mẫu ExampleCollection
}
