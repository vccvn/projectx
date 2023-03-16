<?php
namespace App\Masks\Packages;

use Crazy\Magic\MaskCollection;

class WebAccountPackageCollection extends MaskCollection
{
    /**
     * lấy tên class mask tương ứng
     *
     * @return string
     */
    public function getMask()
    {
        return WebAccountPackageMask::class;
    }
    // xem Collection mẫu ExampleCollection
}
