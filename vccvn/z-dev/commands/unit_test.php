<?php
if(!function_exists('unit_test')){
    /**
     * unit_test
     * 
     */
    function unit_test($func = null)
    {
        if(!$func) echo 'bạn chưa nhập tên function';
        elseif(function_exists($func)) echo "function $func có được hỗ trợ";
        else echo "function $func không tòn tại";
        echo "\n";
    }
}