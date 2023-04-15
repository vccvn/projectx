<?php
if(!function_exists('number_matrix')){
    /**
     * number_matrix
     * 
     */
    function number_matrix($number=100000)
    {
        for ($i=0; $i < $number; $i++) { 
            $s = '';
            for ($j=0; $j < 60; $j++) { 
                $s.= rand(0, 1) . ' ';
            }

            $s.= "\r\n";
            echo $s;
        }
    }
}