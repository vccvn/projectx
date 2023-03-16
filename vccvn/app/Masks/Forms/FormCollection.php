<?php
namespace App\Masks\Forms;

use Crazy\Magic\MaskCollection;

class FormCollection extends MaskCollection
{
    /**
     * lấy tên class mask tương ứng
     *
     * @return string
     */
    public function getMask()
    {
        return FormMask::class;
    }
    // xem Collection mẫu ExampleCollection
}
