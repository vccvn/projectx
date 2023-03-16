<?php
namespace App\Masks\Testimonials;

use Crazy\Magic\MaskCollection;

class TestimonialCollection extends MaskCollection
{
    /**
     * lấy tên class mask tương ứng
     *
     * @return string
     */
    public function getMask()
    {
        return TestimonialMask::class;
    }
    // xem Collection mẫu ExampleCollection
}
