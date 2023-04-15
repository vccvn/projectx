<?php

if(!function_exists('compilejs')){
    /**
     * compilejs
     * 
     */
    function compilejs($config = null)
    {
        if(!$config){
            echo "Bạn chưa nhập file config";
            return;
        }
        $file = new Filemanager(base_path());
        if(!($cf = $file->getJson($config, true))){
            echo "File không tồn tại";
            return;
        }
        $file->cd($cf->path);
        $list = [];
        $cnt = "";
        if($cf->sources){
            foreach($cf->sources as $f){
                $cnt .= $file->getContent($f);
            }
        }

        $container = $file->getContent('container.js');
        $output = str_replace('//[BODY]', $cnt, $container);
        $app = $file->save($cf->compile, $output);
        echo "compile hoàn tất! \n".$app->path."\n";
    }
}