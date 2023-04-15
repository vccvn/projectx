<?php
if(!function_exists('test_array')){
    /**
     * test_array
     * 
     */
    function test_array()
    {
        $a = [1, 2, 3];
        $b = ["2",'1',  "3"];
        echo 'a == b is ';
        echo $a == $b ? 'true': 'false';
        echo "\n";
    }
}