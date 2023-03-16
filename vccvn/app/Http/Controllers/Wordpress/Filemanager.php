<?php

namespace App\Http\Controllers\Wordpress;

use Crazy\Files\Filemanager as FM;

class Filemanager extends FM
{
    public $contentDir = '';
    public function setContentDir($path = null)
    {
        $this->contentDir = rtrim(env('WORDPRESS_CONTENT_PATH', '/var/www/vccvn/public/wp-content'), '/') . (is_string($path) && $path && $path != '/' ? '/' . rtrim($path, '/') : '');
    }

    public function checkContentDir()
    {
        if(!$this->contentDir){
            if(($user = auth()->user()) && $user->secret_key){
                $this->setContentDir($user->secret_key);
            }
        }
        
    }
    /**
     * kiểm tra xem dường dẫn có dc cho phép hay ko
     * @param string $dir
     *
     * @return boolean
     */
    public function checkDirAccepted(string $dir)
    {
        $path = env('WORDPRESS_CONTENT_PATH', '/var/www/vccvn/public/wp-content');
        $base = rtrim(rtrim($path,"\\"),'/');
        if(count(explode($base, $dir)) == 2) return true;
        return false;
    }

    
    /**
     * tạo dường dẫn mới
     * @param string $dir
     * @param int $mode 
     * @param boolean $recursive
     * 
     * @return boolean
     */
    public function makeDir(string $dir, $mode = 0755, $recursive = false)
    {
        $this->checkContentDir();
        if($dir && is_string($dir)){
            $mng = app(static::class); // tao doi tuong moi tranh bi conflict
            $date = date('Y-m-d');
            
            // nếu không bắt dầu từ thư mục gốc
            if(!$this->checkDirAccepted($dir)) {
                $user = request()->user();
                if(!$user) return false;
                $dir = $this->contentDir . '/' . ltrim($dir); 
            }
            $parseDir = rtrim(str_replace("\\",  "/",  $dir), '/');
            // chia thành các part

            $dlist = explode('/', $parseDir);
            $end = array_pop($dlist);
            $parent = implode('/', $dlist);
            if(!is_dir($parseDir)){
                if(!$this->mkdir($parseDir, $mode, $recursive)){
                    $msg = "Crazy Make dir $parseDir fail!";
                    $mng->append("\n".$msg, storage_path('crazy/logs/'.$date.'.log'));
                    chmod($parent, 0755);
                    if(!$this->mkdir($parseDir, $mode, $recursive)){
                        $msg = "Crazy re-Make dir $parseDir fail!";
                        $mng->append("\n".$msg, storage_path('crazy/logs/'.$date.'.log'));
                    }
                }
            }

            
            return true;
        }
        return false;
    }
}
