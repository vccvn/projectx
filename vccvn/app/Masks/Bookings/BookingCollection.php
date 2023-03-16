<?php
namespace App\Masks\Bookings;

use Crazy\Magic\MaskCollection;

class BookingCollection extends MaskCollection
{
    /**
     * lấy tên class mask tương ứng
     *
     * @return string
     */
    public function getMask()
    {
        return BookingMask::class;
    }
    // xem Collection mẫu ExampleCollection
}
