<?php
if(!function_exists('downloadFile')){
    /**
     * downloadFile
     *
     */
    function downloadFile($url, $filename=null)
    {
        # code...
        $a = file_get_contents($url);
        echo $a;
        if($a){
            file_put_contents(base_path().'/storage/'.$filename) or die("Can't download file");
            echo "Tai thanh cong";
        }
    }
}
