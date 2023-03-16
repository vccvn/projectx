<?php
if(!function_exists('check_curl')){
    /**
     * check_curl
     * 
     */
    function check_curl()
    {
        echo 'Curl: ', function_exists('curl_version') ? 'Enabled' : 'Disabled';
    }
}