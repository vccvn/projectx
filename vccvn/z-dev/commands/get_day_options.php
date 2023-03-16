<?php
if(!function_exists('get_day_options')){
    /**
     * lấy ngày cho option của select
     * @param string $lang
     * @param boolean $increment
     * 
     * @return array
     */
    function get_day_options($lang='vi', $increment=true)
    {
        $label = strtolower($lang) == 'en' ? 'Day': 'Ngày';
        $data = [$label];
        if($increment){
            for ($i=1; $i < 32; $i++) { 
                $data[$i] = $i;
            }
        }else{
            for ($i=31; $i > 0; $i--) { 
                $data[$i] = $i;
            }
        }
        return $data;
    }
}