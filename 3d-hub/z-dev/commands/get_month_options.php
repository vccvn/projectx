<?php

if(!function_exists('get_month_options')){
    /**
     * lấy option các tháng cho thẻ select
     * @param string $lang 
     * @param bool $increment Thứ tự tăng hay giảm
     * @return array
     */
    function get_month_options($lang = 'vi', $increment = true)
    {
        
        $en = [
            'Month', 'January', 'February', 'March', 'April', 'May', 'June',
            'July', 'August', 'September', 'October', 'November', 'December'
        ];
        $vi = ['Tháng'];
        for($i = 1; $i < 13; $i++){
            $vi[$i] = 'Tháng '.$i;
        }
        $months = strtolower($lang) == 'en' ? $en : $vi;
        $data = [$months[0]];
        if(!$increment) {
            for($i = 12; $i > 0; $i--){
                $data[$i.''] = $months[$i];
            }
        }else{
            for($i = 1; $i < 13; $i++){
                $data[$i.''] = $months[$i];
            }
        }
        return $data;
    }
}