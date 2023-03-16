<?php
namespace App\Masks;

use App\Models\Model;
use Crazy\Magic\Mask as BaseMask;

class Mask extends BaseMask{

    /**
     * lấy data từ model sang mask
     * @param Model $model Tham số không bặt buộc phải khai báo. 
     * Xem thêm ExampleMask
     */
    public function toMask()
    {
        $data = $this->getAttrData();
        // thêm data tại đây.
        // Xem thêm ExampleMask
        return $data;
        
    }

    // xem thêm ExampleMask
    // protected function init(){}

    // khai báo thêm các hàm khác bên dưới nếu cần
}