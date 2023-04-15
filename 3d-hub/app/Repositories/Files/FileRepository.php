<?php

namespace App\Repositories\Files;

use App\Repositories\Base\BaseRepository;

use Crazy\Files\Filemanager;
use Crazy\Files\Image;
use Crazy\Helpers\Arr;
use PDO;

class FileRepository extends BaseRepository
{
    
    /**
     * class chứ các phương thức để validate dử liệu
     * @var string $validatorClass 
     */
    protected $validatorClass = 'App\Validators\Files\FileValidator';

    /**
     * @var string $resource
     */
    protected $resourceClass = 'App\Http\Resources\FileResource';

    /**
     * @var string $collectionClass
     */
    protected $collectionClass = 'App\Http\Resources\FileCollection';

    /**
     * tên class mặt nạ. Thường có tiền tố [tên thư mục] + \ vá hậu tố Mask
     *
     * @var string
     */
    protected $maskClass = 'Files\FileMask';

    /**
     * tên collection mặt nạ
     *
     * @var string
     */
    protected $maskCollectionClass = 'Files\FileCollection';

    /**
     * @var Crazy\Files\Filemanager $filemanager thư viện quản lý file, thư mục và tập tin
     */
    protected $filemanager;

    /**
     * @var string $system
     */
    protected $system = 'both';

    /**
     * get model
     * @return string
     */
    public function getModel()
    {
        return \App\Models\File::class;
    }

    /**
     * chạy các thiết lập
     */
    public function init(){
        $this->filemanager = new Filemanager();
    }

    public function beforeFillter($request)
    {
        
    }

    /**
     * lưu file từ dử liệu base 64
     * @param string $base64 dữ liệu file được mã hóa base64
     * @param string $filenameWithoutExtension tên file không bao gồm phần mờ rộng
     * @param string $ref mục tham chiếu ví dụ: file / gallery / dynamic / post / v.v..
     * @param int $ref_id id mục tham chiếu
     * @param int $upload_by người upload
     * 
     * @return Crazy\Helpers\Arr|null
     */
    public function saveBase64($base64, $filenameWithoutExtension = null, $ref = 'file', $ref_id = 0, $upload_by = 0)
    {
        if($file = $this->filemanager->getBase64Data($base64)){
            $data_path = date('Y/m/d');
            $path = 'static/files/' . $data_path;
            $this->filemanager->setDir($path, true);
            if(!is_dir($this->filemanager->getDir())) return false;
            $original = null;
            // neu co ten file cu
            if($file->filename){
                $original = $file->filename;
            }
            if($fn = $this->getFilenameWithoutExtension($filenameWithoutExtension)){
                $attachment = $fn;
            }elseif ($original) {
                $attachment = $this->getFilenameWithoutExtension($original).'-' . uniqid();
            }
            else{
                $attachment = str_slug(microtime(),'-');
            }
            $filename = $attachment.'.'. $file->extension;
            if($saveFile = $this->filemanager->save($filename, $file->data, $file->extension)){
                return $this->save(array_merge($saveFile->all(), [
                    'upload_by' => $upload_by,
                    'sid' => md5(microtime().uniqid()),
                    'date_path' => $data_path,
                    'original_filename' => $original??$filename,
                    'privacy' => 'public',
                    'ref' => $ref,
                    'ref_id' => $ref_id
                ]));
            }
        }

        return false;
    }

    /**
     * lưu nhiều file
     * @param array $base64_list Mảng các giá trị data base64
     * @param string $ref mục tham chiếu
     * @param int $ref_id id tham chiếu
     * @param int $upload_by id người upload
     * 
     * @return array 
     */
    public function saveBase64List($base64_list = [], $ref = 'file', $ref_id = 0, $upload_by = 0) : array
    {
        $savedList = [];
        if(is_array($base64_list) && count($base64_list)){
            foreach ($base64_list as $data) {
                if($saved = $this->saveBase64($data,null,$ref, $ref_id, $upload_by)){
                    $savedList[] = $saved;
                }
            }
        }
        return $savedList;
    }

    /**
     * lưu ảnh từ một url
     *
     * @param [type] $url
     * @param string $ref
     * @param integer $ref_id
     * @param integer $upload_by
     * @param [type] $qid
     * @return void
     */
    public function saveFileByUrl($url, $rooturl = null, $ref = 'file', $ref_id = 0, $upload_by = 0, $qid = null)
    {
        if(!$qid) $qid = uniqid();
        $url = $this->parseUrl($url, $rooturl);
        $name = $qid.'-'.substr($url, strrpos($url, '/') + 1);
        $data_path = date('Y/m/d');
        $path = 'static/files/' . $data_path;
        $this->filemanager->setDir($path, true);
        if(!is_dir($this->filemanager->getDir())) return false;

        $original = $name;
        $image = new Image($url);
        $fp = public_path($path . '/'.$name);
        
        if(!$image->check()){
            $contents = @file_get_contents($url);
            @file_put_contents($fp, $contents);
            if(!file_exists($fp)) return null;
            $type = $this->filemanager->gettype($fp);
        }else{
            if(!$image->save($fp)) return false;
            $type = $image->getType();
            $name = $image->getStoredFilename();
        }
        $size = $this->filemanager->size($fp);
        $a = $this->filemanager->getMimeType($type);

        return $this->save([
            'filename' => $name,
            'type' => $a->type,
            'size' => $size,
            'extension' => $a->extension,
            'upload_by' => $upload_by,
            'sid' => md5(microtime().uniqid()),
            'date_path' => $data_path,
            'original_filename' => $original,
            'privacy' => 'public',
            'ref' => $ref,
            'ref_id' => $ref_id
        ]);

    }

    public function saveUrlList($urls, $rooturl = null, $ref = 'file', $ref_id = 0, $upload_by = 0, $qid = null)
    {
        if(!$qid) $qid = uniqid();
        $a = [];
        if(is_array($urls) && count($urls)){
            foreach ($urls as $url) {
                if($f = $this->saveFileByUrl($url, $rooturl, $ref, $ref_id, $upload_by, $qid)){
                    $a[] = $f;
                }
            }
        }
        return $a;
    }

    /**
     * lấy tên file ko có phần mở rộng
     * @param string $filenameWithoutExtension
     * @return string|null
     */
    public function getFilenameWithoutExtension($filenameWithoutExtension = null)
    {
        if($filenameWithoutExtension){
            $of = explode('.',$filenameWithoutExtension);
            $ext = array_pop($of);
            if($mime = $this->filemanager->getMimeType($ext)){
                $filename = implode('.',$of);
            }else{
                $filename = $filenameWithoutExtension;
            }
            
            
            if($filename) return $filename;
        }
        return null;
    }

    /**
     * xóa những file không có trong ds
     * @param string $ref
     * @param int $ref_id
     * @param array $ignore_list
     * @return boolean
     */
    public function deleteRefFileIgnoreList($ref = null, $ref_id = null, $ignore_list = [])
    {
        $args = [];
        if($ref){
            $args['ref'] = $ref;
            if(is_numeric($ref_id)){
                $args['ref_id'] = $ref_id;
            }
        }
        if(count($list = $this->get($args))){
            if(is_array($ignore_list) && count($ignore_list)){
                foreach ($list as $file) {
                    if(!in_array($file->id, $ignore_list)){
                        $file->delete();
                    }
                }
            }else{
                foreach ($list as $file) {
                    $file->delete();
                }
            }
        }
    }

    
    public function parseUrl($url, $rooturl = null)
    {
        $u = $url;
        if(strpos($url, 'http') === 0) return $u;
        if(substr($url, 0, 2) == '//'){
            if($rooturl){
                $prot = explode('://', $rooturl);
                if(count($prot) == 2){
                    $u = $prot[0]. ':'.$u;
                }else{
                    $u = 'http:'.$u;
                }
            }else{
                $u = 'http:'.$u;
            }
        }elseif (substr($url, 0, 1) == '/') {
            if($rooturl){
                $u = rtrim($rooturl, '/') . $u;
            }
        }
        return $u;
    }
    
}