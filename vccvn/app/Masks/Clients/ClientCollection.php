<?php
namespace App\Masks\Clients;

use Crazy\Magic\MaskCollection;

class ClientCollection extends MaskCollection
{
    /**
     * lấy tên class mask tương ứng
     *
     * @return string
     */
    public function getMask()
    {
        return ClientMask::class;
    }
    // xem Collection mẫu ExampleCollection
}
