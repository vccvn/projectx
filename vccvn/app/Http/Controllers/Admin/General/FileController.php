<?php

namespace App\Http\Controllers\Admin\General;

use Illuminate\Http\Request;
use App\Http\Controllers\Admin\AdminController;

use App\Repositories\Files\FileRepository;

use App\Repositories\Metadatas\MetadataRepository;
use Crazy\Helpers\Arr;

class FileController extends AdminController
{
    protected $module = 'files';

    protected $moduleName = 'Nội dung';
    
    protected $flashMode = true;


    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(FileRepository $FileRepository, MetadataRepository $MetadataRepository)
    {
        $this->repository = $FileRepository;

        $this->metadatas = $MetadataRepository;

        $this->init();
        
    }

    /**
     * tải file lên bằng dropzone
     * @param Request $request
     * @return json
     */
    public function dzUpload(Request $request)
    {

        extract($this->apiDefaultData);
        $date = date('Y/m/d');
        $validator = $this->repository->validator($request);
        
        if(!$validator->success()){
            $message = "Đã có lỗi xảy ra. Vui lòng kiểm tra lại!";
            $errors = $validator->errors();
        }elseif(!($file = $this->uploadImage($request, 'file', null, get_content_path('files/'.$date), true, 120, 120))){
            $message = "Đã có lỗi xảy ra. Không thể upload file";
        }
        // chết đoạn này à cai nà chỉ luu db thoi
        elseif(!($result = $this->repository->save(array_merge($file->all(), [
            'upload_by' => $request->user()->id,
            'sid' => md5(microtime().uniqid()),
            'date_path' => $date,
            'description' => $request->description,
            'privacy' => $request->privacy??'public',
            'ref' => $request->ref??'gallery',
            'ref_id' => $request->ref_id??0
        ])))){
            $message = "Lỗi không xác định";
        }else{
            $status = true;
            $data = $result->toFormData();
        }
        
        return $this->json(compact(...$this->apiSystemVars));
    }
    
    


    /**
     * lay danh sach file anh 
     * @param Request $request
     * @return json
     */
    public function getImageData(Request $request)
    {
        $this->repository->mode('mask');
        return $this->getAjaxData($request,['ref'=>'gallery','filetype' => 'image', '@order_by'=>['id'=>'DESC']]);
    }

    
    /**
     * tải file lên bằng dropzone
     * @param Request $request
     * @return json
     */
    public function dzUploadMedia(Request $request)
    {

        extract($this->apiDefaultData);
        $date = date('Y/m/d');
        $validator = $this->repository->validator($request, 'Files\Media');
        if(!$validator->success()){
            $message = "Đã có lỗi xảy ra. Vui lòng kiểm tra lại!";
            
            $errors = $validator->errors();
        }elseif(!($file = $this->uploadMedia($request, 'file', null, get_content_path('files/'.$date), true, 120, 120))){
            $message = "Đã có lỗi xảy ra. Không thể upload file";
        }
        // chết đoạn này à cai nà chỉ luu db thoi
        elseif(!($result = $this->repository->save(array_merge($file->all(), [
            'upload_by' => $request->user()->id,
            'sid' => md5(microtime().uniqid()),
            'date_path' => $date,
            'description' => $request->description,
            'privacy' => $request->privacy??'public',
            'ref' => $request->ref??'gallery',
            'ref_id' => $request->ref_id??0
        ])))){
            $message = "Lỗi không xác định";
        }else{
            $status = true;
            $data = $result->toFormData();
        }
        
        return $this->json(compact(...$this->apiSystemVars));
    }
    
    


    /**
     * lay danh sach file anh 
     * @param Request $request
     * @return json
     */
    public function getMediaData(Request $request)
    {
        $this->repository->mode('mask');
        $args = [
            'ref'=>'gallery',
            '@order_by'=>['id'=>'DESC']
        ];
        $f = [];
        if($request->filetype){
            
            if(is_array($request->filetype)){
                $f = $request->filetype;
            }elseif(count($ts = explode(',', $request->filetype)) >= 2 && count($ft = array_filter(array_map('trim', $ts), function($v){return in_array($v, ['image', 'audio', 'video']);}))){
                $f = $ft;
            }
            elseif($request->filetype != 'all' && $request->filetype != '*' ){
                $f = $request->filetype;
            }
            
        }else{
            $f = 'image';
        }
        if($f){
            $args['filetype'] = $f;
        }
        return $this->getAjaxData($request,$args);
    }
}
