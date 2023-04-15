<?php
namespace App\Masks\Crazy3D;

use Crazy\Magic\MaskCollection;

class ProjectCollection extends MaskCollection
{
    /**
     * lấy tên class mask tương ứng
     *
     * @return string
     */
    public function getMask()
    {
        return ProjectMask::class;
    }
    // xem Collection mẫu ExampleCollection
}
