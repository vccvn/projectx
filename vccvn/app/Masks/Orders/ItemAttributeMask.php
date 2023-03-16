<?php
namespace App\Masks\Orders;

use Crazy\Magic\Mask;

class ItemAttributeMask extends Mask
{

    /**
     * sẽ được gọi sau khi thiết lập xong
     *
     * @return void
     */
    protected function onLoaded()
    {
        $this->text = $this->text_value??$this->{$this->value_type.'_value'};
    }
    

    


    
    // khai báo thêm các hàm khác bên dưới nếu cần
}