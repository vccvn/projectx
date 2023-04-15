<?php

namespace App\Http\Controllers\Manager;

use App\Repositories\Files\FileRepository;
use Illuminate\Http\Request;

use App\Repositories\Themes\ThemeRepository;

use Crazy\Helpers\Arr;

class ThemeController extends ManagerController
{
    protected $module = 'themes';

    protected $moduleName = 'Giao diện';
    
    /**
     * route chuyển hướng sau khi lưu
     * @var string $redirectRoute
     */
    // protected $redirectRoute = 'themes.list';

    /**
     * @var string $themeZipDir
     */
    protected $themeZipDir = null;


    /**
     * theme repository
     *
     * @var ThemeRepository
     */
    public $repository = null;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(ThemeRepository $ThemeRepository, FileRepository $fileRepository)
    {
        $this->repository = $ThemeRepository;
        $this->fileRepository = $fileRepository;
        $this->init();

        $this->themeZipDir = base_path('themes/zip');
    }


    /**
     * them  thong tin tuoc khi luu
     * @param Request $request
     * @param Arr $data
     * 
     * @return void
     */
    public function beforeCreate(Request $request, Arr $data)
    {
        $slug = $this->repository->slug($data->name, null, $data->version);
        $data->slug = $slug;
        $data->owner_id = $request->user()->id;
    }

    
    /**
     * them  thong tin tuoc khi luu
     * @param Request $request
     * @param Arr $data
     * 
     * @return void
     */
    public function beforeSave(Request $request, Arr $data)
    {
        if($request->id && $theme = $this->repository->find($request->id)){
            $slug = $theme->slug;
        }else{
            $slug = $data->slug;
        }
        if($zip = $this->uploadFile($request, 'zip', $slug, $this->themeZipDir)){
            $data->zip = $zip->filename;
        }
        else{
            $data->remove('zip');
        }
        $this->uploadImageAttachFile($request, $data, 'image', 'static/themes');
    }

    /**
     * luu thu vien anh
     *
     * @param Request $request
     * @param \App\Models\Theme $result
     * @return void
     */
    public function afterSave(Request $request, $result)
    {
        //nếu có gallery
        if($request->id == $result->id){
            $this->fileRepository->deleteRefFileIgnoreList('theme', $result->id, is_array($request->gallery_ids)?$request->gallery_ids:[]);
            // tam thoi
            $this->extract($request);
        }
        if($request->gallery_data){
            $this->fileRepository->saveBase64List($request->gallery_data, 'theme', $result->id, $request->user()->id);
        }
    }

    /**
     * xóa file sau khi xoa theme
     * @param Model
     * @return void
     */
    public function afterDelete($theme)
    {
        if($theme){
            if($path = $theme->getZipPath()) unlink($path);
            
            $filemanager = $this->getFilemanager();
            $filemanager->delete(base_path('themes/containers/'.$theme->slug));

            if(is_dir($assets = public_path('assets/'.$theme->slug))){
                $filemanager->delete($assets);
            }
            if(is_dir($views = resource_path('views/clients/'.$theme->secret_id))){
                $filemanager->delete($views);
            }
        }
    }

    /**
     * tải thêm xuống máy tính
     * @param Request $request
     * @param string $slug
     * 
     * @return reponse
     * 
     */
    public function download(Request $request, $slug)
    {
        $this->repository->resetDefaultParams();
        if($theme = $this->repository->findBy('slug', $slug)){
            if($path = $theme->getZipPath()){
                return response()->download($path, $theme->zip);
            }
        }
        return $this->showError($request, 404, 'Đường dẫn không hợp lệ');
    }


    /**
     * giải nén file
     * @param Request $request
     * 
     * @return reponse
     */
    public function extract(Request $request)
    {
        extract($this->apiDefaultData);
        if(!$request->id || !($theme = $this->repository->findBy($this->primaryKeyName, $request->id)) || !($filemanager = $this->getFilemanager($this->themeZipDir)))
        {
            $message = "Theme không tồn tại hoặc đã bị xóa. Vui lòng kiểm tra lại!";
        }
        elseif(!$filemanager->extract($theme->zip, $themeDir = base_path('themes/containers/'.$theme->slug)))
        {
            $message = "Giải nén không thành công! Vui lòng thử lại sau giây lát.";
        }
        elseif(!is_dir($assets = $themeDir . '/assets') || !is_dir($views = $themeDir . '/views'))
        {
            $filemanager->delete($themeDir);
            $message = "Cấu trúc thư mục không hợp lệ";
        }
        elseif(!$filemanager->copyFolder($assets, public_path('assets/'.$theme->slug)) || !$filemanager->copyFolder($views, resource_path('views/clients/'.$theme->secret_id)))
        {
            $filemanager->delete($themeDir);
            $message = "Lỗi không thể cài đặt theme";
        }
        elseif(!$theme->available && !$this->repository->update($theme->id, ['available' => 1]))
        {
            $message = "Không thể cập nhật trạng thái có thể sử dụng!";
        }
        else
        {
            $this->repository->createMetaData($request->id);
            $status = true;
            $message = "Đã giải nén thảnh công!";
            $filemanager->delete($assets);
            $filemanager->delete($views);
            $filemanager->delete($themeDir.'/config');
            // $filemanager->delete($themeDir.'/components');
        }
        return $this->json(compact(...$this->apiSystemVars));
    }

    


}
