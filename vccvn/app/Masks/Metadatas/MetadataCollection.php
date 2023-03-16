<?php
namespace App\Masks\Metadatas;

use Crazy\Magic\MaskCollection;

class MetadataCollection extends MaskCollection
{
    /**
     * lấy tên class mask tương ứng
     *
     * @return string
     */
    public function getMask()
    {
        return MetadataMask::class;
    }
    // xem Collection mẫu ExampleCollection
}
