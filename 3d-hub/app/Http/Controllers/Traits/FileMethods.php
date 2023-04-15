<?php

namespace App\Http\Controllers\Traits;

use Crazy\Helpers\Arr;
use Illuminate\Http\Request;

use Crazy\Files\Filemanager;
use Crazy\Files\Image;
use Storage;
use File;
/**
 * các thuộc tính và phương thức của form sẽ được triển trong ManagerController
 */
trait FileMethods
{

    /**
     * @var Filemanager $filemanager
     */
    protected $filemanager = null;

    protected $makeThumbnail = false;
    
    public function fileInit()
    {
        $this->filemanager = new Filemanager();
    }

    public function getFilemanager($dir = null)
    {
        return new Filemanager($dir);
    }

    /**
     * luu file tai thu muc public
     * @param string $dir
     * @param string $filename
     * @param mixed $content
     * @param string $mime_type
     * @return Arr|null
     */
    public function saveFile($dir = null, $filename = null, $content = null, $mime_type = null)
    {
        if($filename){
            $file = new Filemanager($dir);
            return $file->save($filename, $content, $mime_type);
        }
        return null;
    }

    /**
     * luu file tai thu muc public
     * @param string $dir
     * @param string $filename
     * @param mixed $content
     * @param string $mime_type
     * @return Arr|null
     */
    public function savePublicFile($dir = null, $filename = null, $content = null, $mime_type = null)
    {
        return $this->saveFile(public_path($dir), $filename, $content, $mime_type);
    }


    /**
     * upload file
     * @param Request $request
     * @param string $field
     * @param string $filenameWithoutExtension
     * @param string $path
     */
    public function uploadFile(Request $request, $field = 'file', $filenameWithoutExtension = null, $path = null)
    {
         
        if($request->hasFile($field)){
            if(!$path) $path = 'static'.DIRECTORY_SEPARATOR.'uploads'.DIRECTORY_SEPARATOR.$this->module;
            $this->filemanager->setDir($path, true);
            $destinationPath = $this->filemanager->getDir();
            if(!is_dir($destinationPath)){
                $this->filemanager->makeDir($destinationPath, 0755);
            }
            $file = $request->file($field);
            $extension = strtolower($file->getClientOriginalExtension());
            $original_filename = $file->getClientOriginalName();

            // neu co ten file cu
            if($fn = $this->getFilenameWithoutExtension($filenameWithoutExtension, $extension)){
                $attachment = $fn;
            }
            else{
                $attachment = $this->getFilenameWithoutExtension($original_filename, $extension) .'-' . uniqid();
            }
            
            if($extension == 'jpeg') $extension = 'jpg';
            $filename = $attachment.'.'.$extension;
            $mime = $file->getClientMimeType();
            $ftype = explode('/', $mime);
            $filetype = $ftype[0];
             // chờ chut
            //  $destinationPath = $destinationPath.DIRECTORY_SEPARATOR.$filename;
            //    dd(base_path('public/static'));
            
            $file->move($destinationPath, $filename);
            
            
            // den day là cus3 laravel
            $filepath = rtrim($destinationPath, '/').'/'.ltrim($filename,'/');
            
            // $this->filemanager->chmod($filepath, 0755);  
            $size = filesize($filepath)/1024;
            return new Arr(compact('filename', 'original_filename', 'filepath', 'extension', 'mime', 'size', 'filetype'));
        }
        return false;
    }
    

    /**
     * lưu một file ảnh sau khi crop
     *
     * @param string $image_path
     * @param integer $width
     * @param integer $height
     * @param string $path
     * @return bool
     */
    public function saveImageCrop($image_path, $filename, $width = 500, $height = 500, $path = null)
    {
        
        $thumb = new Image($image_path);
        if($thumb->check()){
            if($thumb->getWidth() < $width && $thumb->getHeight() < $height) return false;
            $thumb->resizeAndCrop($width, $height);
            if(!$path) $path = 'static'.DIRECTORY_SEPARATOR.'uploads'.DIRECTORY_SEPARATOR.$this->module;
            // $path = rtrim($path, '/').'/thumbs';
            $this->filemanager->setDir($path, true);
            $destinationPath = $this->filemanager->getDir();
            if($thumb->save($path . '/' . $filename)){
                return true;
            }
        }
        return false;
        
    }

    /**
     * save base64 file data
     * @param string $base64
     * @param string $filenameWithoutExtension
     * @param string $path
     */
    public function saveBase64File($base64, $filenameWithoutExtension = null, $path = null, $extension = null)
    {
        if($file = $this->filemanager->getBase64Data($base64)){
            if(!$path) $path = 'static/uploads/'.$this->module;
            
            $this->filemanager->setDir($path, true);
            // neu co ten file cu
            if($fn = $this->getFilenameWithoutExtension($filenameWithoutExtension)){
                $attachment = $fn;
            }else{
                $attachment = str_slug(microtime(),'-');
            }
            $filename = $attachment.'.'. $file->extension;
            return $this->filemanager->save($filename, $file->data, $file->extension);
        
        }

        return false;
    }

    
    /**
     * save base64 file data
     * @param string $base64
     * @param string $filenameWithoutExtension
     * @param string $path
     */
    public function saveBase64Image($base64, $filenameWithoutExtension = null, $path = null, $extension = null)
    {
        if($file = $this->filemanager->getBase64Data($base64)){
            if(!$path) $path = 'static/uploads/'.$this->module;
            
            $this->filemanager->setDir($path, true);
            // neu co ten file cu
            if($fn = $this->getFilenameWithoutExtension($filenameWithoutExtension)){
                $attachment = $fn;
            }else{
                $attachment = str_slug(microtime(),'-');
            }
            $filename = $attachment.'.'. $file->extension;
            if($save = $this->filemanager->save($filename, $file->data, $file->extension)){
                if($extension && $extension != $file->extension){
                    $p = $this->filemanager->getDir();
                    $image = new Image($save->path);
                    $fn2 = $attachment.'.'. $extension;
                    if($image->save($pth = $p.'/' . $fn2, $extension)){
                        $save->filename = $fn2;
                        $save->path = $pth;
                        $this->filemanager->delete($filename);
                    }
                }
                return $save;
            }
            
            return null;
        
        }

        return false;
    }

    /**
     * lấy tên file ko có phần mở rộng
     * @param string $filenameWithoutExtension
     * @return string|null
     */
    public function getFilenameWithoutExtension($filenameWithoutExtension = null, $extension = null)
    {
        if($filenameWithoutExtension){
            $of = explode('.',$filenameWithoutExtension);
            $ext = array_pop($of);

            if(($extension && strtolower($extension) == strtolower($ext)) || $mime = $this->filemanager->getMimeType($ext)){
                $filename = implode('.',$of);
            }else{
                $filename = $filenameWithoutExtension;
            }
            
            
            if($filename) return $filename;
        }
        return null;
    }
    

    /**
     * kiem tra path
     * @param string
     */
    public function checkPath($path = null)
    {
        $path = rtrim(rtrim($path,"\\"),'/');
        $base = rtrim(rtrim(base_path(''),"\\"),'/');
        if(count($p = explode($base, $path)) == 2) return true;
        return false;
    }

    /**
     * upload image or base 64
     * @param Request $request
     * @param string $field 
     * @param string $field
     * @param string $filenameWithoutExtension
     * @param string $path
     * 
     * @return string filename
     */
    public function saveImageFileData(Request $request, $field = 'image', $filenameWithoutExtension = null, $path = null, $width = null, $height = null)
    {
        $file = null;
        if($this->makeThumbnail){
            if($request->hasFile($field) && $fileUpload = $this->uploadFile($request,$field, $filenameWithoutExtension, $path)){
                // gan cho avatar gia tri moi
                $file = $fileUpload->filename;
    
                // nếu nhu có dử liệu file  ở dạng base 64, không yêu cầu giử nguyên kích thước, và upload thành công
                if($request->input($field.'_data') && $fileSaved = $this->saveBase64Image($request->input($field.'_data'), $filenameWithoutExtension, $path.'/thumbs', $fileUpload->extension)){
                    if(!file_exists(public_path($path.'/thumbs/'.$file))){
                        $b = new Image($fileSaved->path);
                        $b->save(public_path($path.'/thumbs/'.$file), $fileUpload->mime);
                    }
                }
                elseif(is_numeric($width) && is_numeric($height) && $width > 0 && $height > 0){
                    $this->saveImageCrop($fileUpload->filepath, $file, $width, $height, $path .'/thumbs');
                }
                
            }
            // nếu nhu có dử liệu file  ở dạng base 64, không yêu cầu giử nguyên kích thước, và upload thành công
            elseif($request->input($field.'_data') && $fileSaved = $this->saveBase64File($request->input($field.'_data'), $filenameWithoutExtension, $path)){
                // gan cho abatar gia tri moi
                $file = $fileSaved->filename;
                if(is_numeric($width) && is_numeric($height) && $width > 0 && $height > 0){
                    $this->saveImageCrop($fileUpload->path, $file, $width, $height, $path .'/thumbs');
                }else{
                    $this->filemanager->copyFile($fileUpload->path, public_path($path .'/thumbs'));
                }
            }
            
        }else{
            // nếu nhu có dử liệu file  ở dạng base 64, không yêu cầu giử nguyên kích thước, và upload thành công
            if($request->input($field.'_data') && !$request->input($field.'_keep_original') && $fileSaved = $this->saveBase64File($request->input($field.'_data'), $filenameWithoutExtension, $path)){
                // gan cho abatar gia tri moi
                $file = $fileSaved->filename;
                
            }
            elseif($request->hasFile($field) && $fileUpload = $this->uploadFile($request,$field, $filenameWithoutExtension, $path)){
                
                $file = $fileUpload->filename;
                if(is_numeric($width) && is_numeric($height) && $width > 0 && $height > 0){
                    $this->saveImageCrop($fileUpload->filepath, $file, $width, $height, $path);
                }
            }
            
        }
        
        // ngược lại nếu có file và upload thành công
        
        return $file;
    }

    /**
     * upload attach file
     * @param Request $request
     * @param Arr $data
     * @param string $field
     * @param string $path
     * 
     * @return void
     */
    public function uploadImageAttachFile(Request $request, Arr $data, string $field = 'image', $path = null, $width = null, $height = null)
    {
        if($request->id && $fn = $this->repository->getAttachFilename($request->id)){
            $filename = $this->getFilenameWithoutExtension($fn);
        }
        elseif($request->hasFile($field)){
            $file = $request->file($field);
            $extension = strtolower($file->getClientOriginalExtension());
            $original_filename = $file->getClientOriginalName();
            $filename = str_slug($this->getFilenameWithoutExtension($original_filename, $extension)) .'-' . uniqid();
            $fn = null;
        }
        else{
            $fn = null;
            $filename = null;
        }
        // neu 1 tromg 2 uploaf thanh cong
        if($image = $this->saveImageFileData($request, $field, $filename, $path, $width, $height)){
            // nếu ảnh cũ khác ảnh mới thì xóa ảnh cũ
            if($fn && $fn!=$image){
                $this->repository->deleteAttachFile($request->id);
            }
            $data->{$field} = $image;
        }else{
            $data->remove($field);
        }
    }


    
    /**
     * upload attach file
     * @param Request
     * @param Arr $data
     * @param string $field
     * @param string $path
     * 
     * @return void
     */
    public function uploadAttachFile(Request $request, Arr $data, string $field = 'image', $path = null)
    {
        $filename = $field;
        // neu 1 tromg 2 uploaf thanh cong
        if($image = $this->uploadFile($request, $field, $filename, $path)){
            // nếu ảnh cũ khác ảnh mới thì xóa ảnh cũ
            $data->{$field} = $image->filename;
        }else{
            $data->remove($field);
        }
        // dd($data->all());
    }



    /**
     * upload image or base 64
     * @param Request $request
     * @param string $field
     * @param string $filenameWithoutExtension 
     * @param string $path
     * @param string $resize
     * @param int $width
     * @param int $height
     * 
     * @return Arr|null filename
     */
    public function uploadImage(Request $request, $field = 'image', $filenameWithoutExtension = null, $path = null, $resize = false, $width=null, $height = null)
    {
        $file = null;
        
        // ngược lại nếu có file và upload thành công
        if($request->hasFile($field) && $fileUpload = $this->uploadFile($request,$field, $filenameWithoutExtension, $path)){
            // gan cho abatar gia tri moi
            $file = $fileUpload;
            if($resize && $width && $height){
                if(!$path) $path = 'static/uploads/'.$this->module;
                $path .= "/{$width}x{$height}";
                $this->filemanager->setDir($path, true);
                // $this->filemanager->chmod($path, 777);
                $dir = $this->filemanager->getDir();

                 
                // $destinationPath = $this->filemanager->getDir();
                $image = new Image($fileUpload->filepath);
                $image->resizeAndCrop($width, $height);
                // die($dir.'/'.$file->filename);
                $image->save($dir.'/'.$file->filename);
            }
    

        }
        return $file;
    }

    public function makeSocialImage(Arr $data, $folder = null)
    {
        if($data->feature_image && $folder){
            $image = new Image(public_path('static/'.$folder.'/'.$data->feature_image));
            $sw = $this->socialImageWidth;
            $sh = $this->socialImageHeight;
            $imgW = $image->getWidth();
            $imgH = $image->getHeight();
            if($imgW > $sw && $imgH > $sh){
                $image->resizeAndCrop($sw, $sh);
                $this->featureImageWidth = $sw;
                $this->featureImageHeight = $sh;
            }
            elseif($imgW > 400 && $imgW < 500){
                $sw = 480;
                $sh = 250;
                $image->resizeAndCrop($sw, $sh);
                $this->featureImageWidth = $sw;
                $this->featureImageHeight = $sh;
            }
            elseif($imgW >= 500){
                $sw = 526;
                $sh = 275;
                $image->resizeAndCrop($sw, $sh);
                $this->featureImageWidth = $sw;
                $this->featureImageHeight = $sh;
            }
            else{
                $this->featureImageWidth = $image->getWidth();
                $this->featureImageHeight = $image->getHeight();
            }
            
            $image->save(public_path('static/'.$folder.'/social/'.$data->feature_image));
        }
    }

}
