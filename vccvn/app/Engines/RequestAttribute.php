<?php
namespace App\Engines;

use Crazy\Helpers\Arr;

Class RequestAttribute extends Arr{
    
    public function __construct()
    {
        $this->data = get_attribute_request_data();
    }

    /**
     * kiểm tra trong danh sách có giá trị của thuov65 tính đang cần kiểm tra hay không
     *
     * @param string $name
     * @param mixed $value
     * @return void
     */
    public function check($name, $value = null)
    {
        $thisValue = $this->get($name);
        if(is_array($thisValue)){
            return in_array($value, $thisValue);
        }
        return $thisValue == $value;
    }


}