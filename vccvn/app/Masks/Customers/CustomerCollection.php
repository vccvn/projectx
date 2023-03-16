<?php
namespace App\Masks\Customers;

use Crazy\Magic\MaskCollection;

class CustomerCollection extends MaskCollection
{
    /**
     * lấy tên class mask tương ứng
     *
     * @return string
     */
    public function getMask()
    {
        return CustomerMask::class;
    }
    // xem Collection mẫu ExampleCollection
}
