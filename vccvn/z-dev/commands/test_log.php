<?php
if(!function_exists('test_log')){
    /**
     * test_log
     * 
     */
    function test_log($text="haga")
    {
        $file = new Filemanager();
        $file->setDir(base_path('z-dev/tests'));
        $file->save(date('Y-m-d-H-i-s').'.txt', $text);
    }
}