<?php
if(!function_exists('lineToArray')){
    /**
     * lineToArray
     * 
     */
    function lineToArray($input, $output)
    {
        $fileManager = new Filemanager(base_path());
        if($fileManager->exists($input)){
            $content = $fileManager->getContent($input);
            preg_match_all('/\<i\s*class\=\"(.*)\"/i', $content, $match);
            $fileManager->save($output, json_encode($match[1]));
        }
    }
}