<?php
if(!function_exists('check_variable_type')){
    /**
     * check_variable_type
     * 
     */
    function check_variable_type()
    {
        $a = function (){

        };
        echo gettype($a);
        
    }
}