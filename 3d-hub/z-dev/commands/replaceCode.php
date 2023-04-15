<?php
if(!function_exists('replaceCode')){
    /**
     * replaceCode
     * 
     */
    function replaceCode($file = null)
    {
        if(file_exists($f = base_path($file))){
            $c = file_get_contents($f);

            $content = preg_replace('/\"[0-9]{1,2}\"\,[\r\n\t\s]*\"/', '"code": "', $c);
            $fs = explode('.', $file);
            $ext = array_pop($fs);
            $fn = implode('.', $fs) . '-replaced.' . $ext;
            $a = file_put_contents($p = base_path($fn), $content);
            if($a){
                echo "Đã thay đồi thành công!\n$p\n";
            }
            else{
                echo "fail\n";
            }
        }
    }
}

if(!function_exists('replaceCodeX')){
    /**
     * replaceCode
     * 
     */
    function replaceCodeX($file = null)
    {
        if(file_exists($f = base_path($file))){
            $c = file_get_contents($f);

            $content = preg_replace('/\{[\r\n\t\s]*\"code\": \"([^"]*)\"/', "\"$1\": {\n    \"code\": \"$1\"", $c);
            $fs = explode('.', $file);
            $ext = array_pop($fs);
            $fn = implode('.', $fs) . '-replaced-x.' . $ext;
            $a = file_put_contents($p = base_path($fn), $content);
            if($a){
                echo "Đã thay đồi thành công!\n$p\n";
            }
            else{
                echo "fail\n";
            }
        }
    }
}