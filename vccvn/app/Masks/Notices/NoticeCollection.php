<?php
namespace App\Masks\Notices;

use Crazy\Magic\MaskCollection;

class NoticeCollection extends MaskCollection
{
    /**
     * lấy tên class mask tương ứng
     *
     * @return string
     */
    public function getMask()
    {
        return NoticeMask::class;
    }
    // xem Collection mẫu ExampleCollection
}
