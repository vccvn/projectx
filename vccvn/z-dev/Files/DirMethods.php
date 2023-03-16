<?php
// namespace Crazy\Files;

// use Crazy\Helpers\Any;

trait DirMethods{
    protected $_dir = null;

    protected $basePath = null;
    public function dirInit()
    {
        $this->_dir = dirname(dirname(dirname(__FILE__)));
        $this->basePath = $this->_dir;
    }

    public function acceptPath($dir = null)
    {
        return $this->_dir.($dir?'/'.ltrim($dir):'');
    }

    public function publicPath()
    {
        return $this->basePath.'/public'.($dir?'/'.ltrim($dir):'');
    }
    /**
     * thiết lập dường dẫn để quản lý file
     * @param string $dir
     * @param boolean $make_dir_if_not_exists
     * 
     * @return object instance
     */
    public function setDir($dir = null, $make_dir_if_not_exists = false)
    {
        if($dir && is_string($dir)){
            $dir = rtrim(rtrim($dir,"\\"),'/');
            // nếu không bắt dầu từ thư mục gốc
            if(!$this->checkDirAccepted($dir)) $dir = $this->publicPath($dir);
            $dir = rtrim(rtrim($dir,"\\"),'/');
            
            if(is_dir($dir)){
                // $this->_dir = $dir;
            }elseif($make_dir_if_not_exists){
                // nếu thư mục không tồn tại và có yêu cầu tạo thư mục
                $this->makeDir($dir, 777, true);
                // $this->_dir = $dir;
            }

            $this->_dir = $dir;
        }
        return $this;
    }

    /**
     * lay duong dan hien tai
     * @return string
     */
    public function getDir()
    {
        return $this->_dir;
    }


    /**
     * thiết lập dường dẫn để quản lý file
     * @param string $dir
     * @param boolean $make_dir_if_not_exists
     * 
     * @return object instance
     */
    public function dir($dir = null, $make_dir_if_not_exists = false)
    {
        $f = clone $this;
        $f->setDir($dir, $make_dir_if_not_exists);
        return $f;
    }

    /**
     * tạo dường dẫn mới
     * @param string $dir
     * @param int $mode 
     * @param boolean $recursive
     * 
     * @return boolean
     */
    public function makeDir(string $dir, $mode = 777, $recursive = false)
    {
        if($dir && is_string($dir)){
            // nếu không bắt dầu từ thư mục gốc
            if(!$this->checkDirAccepted($dir)) $dir = $this->publicPath($dir);
            
            $dlist = explode('/', str_replace("\\", "/", str_replace(rtrim(rtrim($this->basePath,"\\"),'/'), '', $dir)));

            $xdir = rtrim(rtrim($this->basePath,"\\"),'/');

            if(count($dlist)){
                foreach($dlist as $subPath){
                    if(strlen($subPath)){
                        if(!is_dir($xdir.='/'.$subPath)){
                            @mkdir($xdir, $mode, $recursive);
                        }
                    }
                }
            }
            return true;
        }
        return false;
    }

    /**
     * kiểm tra xem dường dẫn có dc cho phép hay ko
     * @param string $dir
     * 
     * @return boolean
     */
    public function checkDirAccepted(string $dir)
    {
        $base = rtrim(rtrim($this->basePath,"\\"),'/');
        if(count($p = explode($base, $dir)) == 2) return true;
        return false;
    }

    /**
     * kiểm tra xem dường dẫn có dc cho phép hay ko
     * @param string $dir
     * 
     * @return boolean
     */
    public function canDelete(string $dir)
    {
        $dir = rtrim(str_replace("\\", "/", $dir),'/');
        $ban_list = [
            rtrim(str_replace("\\", "/", $this->basePath), '/'),
            rtrim(str_replace("\\", "/", $this->publicPath('')), '/'),
        ];
        if(in_array($dir, $ban_list)) return false;
        return true;
    }

    /**
     * chuyển dường dẫn hiện tại
     * 
     * @param string $dir
     * @param boolean $make_dir_if_not_exists
     * 
     * @return object
     */
    public function cd($dir = null, $make_dir_if_not_exists = false)
    {
        if($this->checkDirAccepted($dir)) return $this->setDir($dir);
        $fullDir = $this->_dir.'/'.trim($dir, '/');
        if(!is_dir($fullDir) && $make_dir_if_not_exists){
            $this->makeDir($fullDir, 777, false);
        }
        $this->_dir = $fullDir;
        return $this;
    }
    /**
     * neu url
     */
    protected function joinPath($main, $sub)
    {
        return rtrim($main, '/') . '/' . ltrim($sub, '/');
    }

    /**
     * lấy danh sách file và thư mục
     * 
     * @param 
     */

    public function getList($dir=null,$ext=null,$sort = false){
        if(!$dir) $dir = $this->_dir;
        $list = [];
        $abc = [];
        $result = [];
        $e = is_string($ext)?strtolower($ext):null;
        if($e){
            $e = explode(',',$e);
            $b = [];
            for($i = 0; $i < count($e); $i++){
                $ei = trim($e[$i]);
                if($ei){
                    $b[] = $ei;
                }
            }
            $e = $b;
        }
        if (is_string($dir) && is_dir($dir)) {
            try{
                if ($dh = opendir($dir)) {
                    while (($file = readdir($dh)) !== false) {
                        $t = 1;
                        if($e){
                            $fs = explode('.',$file);
                            $ex = strtolower($fs[count($fs)-1]);
                            if(in_array($ex,$e)){
                                $t=1;
                            }else{
                                $t = 0;
                            }
                            if($t && $file!='..' && $file!='.'){
                                $path = $this->joinPath($dir,$file);
                                $sd = strtolower($file);
                                $abc[] = $sd;
                                $list[$sd] = new Arr([
                                    'type' => 'file',
                                    'name' => $file,
                                    'path' => $path,
                                    'extension' => $ex
                                ]);
                            }
                        }else{
                            if($file!='..' && $file!='.'){
                                $path = $this->joinPath($dir,$file);
                                $fs = explode('.',$file);
                                $ex = strtolower($fs[count($fs)-1]);
                                $type = is_dir($path)?'folder':'file';
                                $sd = strtolower($file);
                                $abc[] = $sd;
                                $list[$sd] = new Arr([
                                    'type' => $type,
                                    'name' => $file,
                                    'extension' => $ex,
                                    'path' => $path
                                ]);
                            }
                            
                        }
                        
                    }
                    closedir($dh);
                }
            }catch(exception $e){
                // $this->errors[__METHOD__] = $e->getMessage();
            }
        }
        if($list && $abc){
            if($sort){
                sort($abc);
            }
            $t = count($abc);
            $type_list = [
                'folder' => [],
                'file' => []
            ];
            
            for($i = 0; $i < $t; $i++){
                $item = $list[$abc[$i]];
                $type_list[$item->type][] = $item;
            }
            foreach($type_list as $list_type){
                foreach($list_type as $it){
                    $result[] = $it;
                }
            }
        }
        return $result;
    }


    /**
     * xóa tất cả
     * @param string $dirname
     */
    public function delete($dirname=null){
        if(is_string($dirname)){
            $tt = $this->checkDirAccepted($dirname);
            if(is_file($dirname) && $tt) return unlink($dirname);
            elseif(is_dir($dirname) && $tt && $this->canDelete($dirname)){
                return $this->removeDir($dirname);
            }else{
                $dirname = $this->joinPath($this->_dir,$dirname);
                if(is_file($dirname)) return unlink($dirname);
                elseif(is_dir($dirname) && $this->canDelete($dirname)){
                    return $this->removeDir($dirname);
                }
            }
            return false;
        }
        else{
            return $this->deleteFile();
        }
    }

    /**
     * xoa
     */
    protected function removeDir($dirname)
    {
        try{
            if($list = $this->getList($dirname)){
                foreach($list as $item){
                    $d = $item->path;
                    if(is_dir($d)) $this->delete($d);
                    else unlink($d);
                }
            }
            return rmdir($dirname);
        }
        catch(exception $e){
            // $this->errors[__METHOD__] = $e->getMessage();
            return false;
        }
        
    }

    /**
     * sao chep thu muc
     */
    public function copyFolder($src,$dst, $check_src = true, $check_dst = true) { 
        
        if(is_string($src) && is_string($dst) && $src != $dst){
            if(!$this->checkDirAccepted($src)) $src = $this->joinPath($this->_dir,$src);
            if(!$this->checkDirAccepted($dst)) $dst = $this->joinPath($this->_dir,$dst);
            if(!is_dir($src)) return false;
            if(!is_dir($dst)) $this->makeDir($dst, 0777);
            if($list = $this->getList($src)){
                foreach ($list as $file) {
                    if($file->type == 'folder'){
                        $this->copyFolder($src.'/'.$file->name, $dst.'/'.$file->name);
                    }else{
                        copy($src.'/'.$file->name, $dst.'/'.$file->name);
                    }
                    
                }
            }
            return true;
        }
        else{
            return false;
        }
    } 
    
}