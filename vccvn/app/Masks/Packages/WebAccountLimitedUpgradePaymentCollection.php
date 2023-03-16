<?php
namespace App\Masks\Packages;

use Crazy\Magic\MaskCollection;

class WebAccountLimitedUpgradePaymentCollection extends MaskCollection
{
    /**
     * lấy tên class mask tương ứng
     *
     * @return string
     */
    public function getMask()
    {
        return WebAccountLimitedUpgradePaymentMask::class;
    }
    // xem Collection mẫu ExampleCollection
}
