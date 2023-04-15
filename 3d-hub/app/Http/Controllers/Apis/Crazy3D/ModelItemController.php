<?php

namespace App\Http\Controllers\Apis\Crazy3D;

use App\Http\Controllers\Apis\ApiController;
use App\Repositories\Crazy3D\CategoryRepository;
use App\Repositories\Crazy3D\ModelItemRepository;
// use App\Repositories\Crazy3D\ModelItemRepository as Crazy3DModelItemRepository;
use Illuminate\Http\Request;
use Crazy\Helpers\Arr;

// use App\Repositories\Crazy\ModelItemRepository;

class ModelItemController extends ApiController
{
    protected $module = 'modelitems';

    protected $moduleName = 'ModelItem';

    protected $flashMode = true;

    /**
     * repository chinh
     *
     * @var ModelItemRepository
     */
    public $repository;
    
    /**
     * repository chinh
     *
     * @var CategoryRepository
     */
    public $categoryRepository;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(ModelItemRepository $repository, CategoryRepository $categoryRepository)
    {
        $this->repository = $repository->mode('mask');
        // $this->repository;
        $this->categoryRepository = $categoryRepository->addDefaultParam('deleted', 0);
        $this->init();
    }

    public function update3D(Request $request)
    {
        extract($this->apiDefaultData);
        if(!$request->id || !($model = $this->repository->first(['id'=> $request->id]))){
            $message = 'Model không tồn tại';
        }
        elseif(!$request->size && !$request->settings){
            $message = 'Không có thông tin';
        }else{
            $d = $model->__data__;
            if(!is_array($d)){
                try {
                    $d = json_decode($d, true);
                } catch (\Throwable $th) {
                    $d = [];
                }
            }
            if($request->size && is_array($request->size)) $d['size'] = $request->size;
            if($request->settings && is_array($request->settings)) {
                if(!isset($d['settings'])){
                    $d['settings'] = [];
                }
                $s = $request->settings;
                if(array_key_exists('meshes', $s)){
                    $d['settings']['meshes'] = $s['meshes'];
                }
                if(array_key_exists('props', $s)){
                    $d['settings']['props'] = $s['props'];
                }
                if(array_key_exists('options', $s)){
                    $d['settings']['options'] = $s['options'];
                }
                if(!($m = $this->repository->update($model->id, ['__data__'=>$d]))){
                    $message = 'Lỗi không xác định';
                }
                else{
                    // return $d;
                    $status = true;
                    $data = $m;
                }
                
            }
            
        }
        
        

        return $this->json(compact(...$this->apiSystemVars));
    }

    public function updateThumbnail(Request $request)
    {
        extract($this->apiDefaultData);
        if(!$request->id || !($model = $this->repository->first(['id'=> $request->id]))){
            $message = 'Model không tồn tại';
        }
        elseif(!$request->thumbnail){
            $message = 'Không có ảnh';
        }elseif(!($file = $this->saveBase64Image($request->thumbnail, 'thumbnail', 'static/sources/models/'.$model->secret_id))){
            $message = 'Upload Không thành công';
        }
        elseif(!($model->thumbnail = $file->filename) || !($model->save()))
        {
            $message = 'Lỗi không xác định';
        }
        else{
            $status = true;
            $data = $model;
        }
        
        

        return $this->json(compact(...$this->apiSystemVars));
    }

    
    public function getItemCategories(Request $request)
    {
        return $this->getData($request, [
            '@withItems' => 6,
            
        ], $this->categoryRepository->mode('mask'));
    }
}
