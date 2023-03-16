<?php
namespace App\Masks\Affiliates;

use Crazy\Magic\MaskCollection;

class AffiliateCollection extends MaskCollection
{
    /**
     * lấy tên class mask tương ứng
     *
     * @return string
     */
    public function getMask()
    {
        return AffiliateMask::class;
    }
    // xem Collection mẫu ExampleCollection
}
