<?php
namespace App\Masks\Transactions;

use Crazy\Magic\MaskCollection;

class TransactionCollection extends MaskCollection
{
    /**
     * lấy tên class mask tương ứng
     *
     * @return string
     */
    public function getMask()
    {
        return TransactionMask::class;
    }
    // xem Collection mẫu ExampleCollection
}
