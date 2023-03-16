<?php

namespace App\Http\Controllers\CPanel;

use Illuminate\Http\Request;

use App\Repositories\Users\UserRepository;

use Crazy\Helpers\Arr;

class FileEditorController extends ManagerController
{
    protected $module = 'filemanager';
    protected $moduleBlade = 'filemanager';
    protected $moduleName = 'Filemanager';

    /**
     * @var Filemanager
     */
    public $filemanager = null;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->repositoy = null;
        $this->activeMenu();
        $this->filemanager = new Filemanager();
    }


    public function getIndex(Request $request)
    {
        $user = $request->user();
        $path = $request->p;
        $rp = ($path ? '/' . ltrim($path, '/') : '');
        if(strpos($path, '..') >= 0 ) return $this->notFound();
        $fp = env('HOSTING_BASE_PATH', '/var/www/home').'/' . $user->secret_key . '/home' . $rp;
        if(file_exists($fp)){
            if(is_dir($fp)) return $this->viewFolder($fp, $rp, $path);
            return $this->viewFile($fp, $rp, $path);
        }

        return $this->notFound();
    }

    public function createFile(Request $request)
    {
        if($file = $request->filename){
            if(($extension = $request->extension) && $extension != "*"){
                $e = strtolower($extension);
                $fs = explode('.', $file);
                if(count($fs) < 2){
                    $file.= '.' . $e;
                }
                else{
                    $ex = strtolower(array_pop($fs));
                    if($ex != $e){
                        $file.='.'.$e;
                    }
                }
            }
            $user = $request->user();
            $path = $request->p;
            $rp = ($path ? '/' . ltrim($path, '/') : '');
            if(count(explode('../', $path)) >= 2 ) return $this->notFound();
            $fp = env('HOSTING_BASE_PATH', '/var/www/home').'/' . $user->secret_key . '/home' . $rp;
            $content = $request->content;
            return $this->filemanager->save($fp . '/' .$file, $content)?"success":"false";
        }
        return "false";
        
    }

    public function mesage($message = '')
    {
        return $this->viewModule('message', compact('message'));
    }

    public function notFound()
    {
        return $this->mesage('File không tồn tại');
    }

}
