<?php

namespace App\Http\Controllers\Admin\Business;

use App\Http\Controllers\Admin\AdminController;
use App\Models\Post;
use App\Repositories\Crazy3D\ModelItemRepository;
use App\Validators\Crazy3D\ModelItemUploadValidator;
use App\Validators\Crazy3D\ModelItemValidator;
use App\Validators\Files\FileValidator;
use Illuminate\Http\Request;
use Crazy\Helpers\Arr;


class Model3DController extends AdminController
{
    protected $module = '3d.models';

    protected $moduleName = 'Model3D';

    protected $flashMode = true;

    /**
     * repository chinh
     *
     * @var ModelItemRepository
     */
    public $repository;
    
    /**
     * @var array $supportExtensions
     */
    protected $supportExtensions = [];
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(ModelItemRepository $repository)
    {
        $this->repository = $repository;
        $this->init();
        
        $this->activeMenu('3d.models');
        // $this->addHeaderButtons('create');
        $this->supportExtensions = get_3d_support_extensions();
    }


    public function prepareGetCrudForm(Request $request)
    {
        $this->flashMode = true;
    }

    public function afterSave(Request $request)
    {
        $this->flashMode = true;
        # code...
    }

    /**
     * Hiển thị danh sách các kết quar tim dc
     * @param Request $request
     * @return View
     */
    public function getIndex(Request $request)
    {
        $this->repository->mode('mask');
        $data = [];
        $data['results'] = $this->getResults($request);
        return $this->viewModule($this->index, $data);
    }

    /**
     * Hiển thị danh sách các kết quar tim dc
     * @param Request $request
     * @return View
     */
    function getList(Request $request) {
        
        $this->activeMenu($this->moduleMenuKey.'.list');
        $this->repository->mode('mask');
        $data = [];
        $data['results'] = $this->getResults($request);
        // $arrData = new Arr($data);
        // $this->callViewEvent('beforeGetListView', $request, $arrData);
        
        // co the code them =))))))

        return $this->viewModule($this->list, $data);
    }

    
    /**
     * Hiển thị danh sách các kết quar tim dc
     * @param Request $request
     * @return View
     */
    function getDetail(Request $request, $id = null) {
        $this->repository->mode('mask');
        
        if($id && $detail = $this->repository->getDetail(['id'=>$id])){
            $data = [];
            $data['detail'] = $detail;
            // $arrData = new Arr($data);
            // $this->callViewEvent('beforeGetDetailView', $request, $arrData);
            return $this->viewModule($this->detail, $data);
        }

        // co the code them =))))))
        return $this->showError($request, 404, "Mục này không tồn tại hoặc đã bị xóa");
    }


    /**
     * Hiển thị danh sách Dã bị xóa tạm thời
     * @param Request $request
     * @return View
     */
    function getTrash(Request $request) {
        $this->repository->mode('mask');
        $this->activeMenu($this->moduleMenuKey.'.trash');
        $this->repository->resetDefaultParams('deleted');
        $data = [];
        $data['results'] = $this->getResults($request,['deleted'=>1]);
        
        
        return $this->viewModule($this->trash, $data);
    }

    public function beforeGetUpdateForm($request, $config, $inputs, $data, $attrs)
    {
        add_css_link('static/manager/css/model-form.min.css');
        // dd($data);
        add_js_data('model_data', $data);
        add_js_data('model_config', [
            'urls' => [
                'preview' => $this->getModuleRoute('preview'),
                'editor' => route($this->routeNamePrefix.'3d.items.edit', ['secret_id'=>$data->secret_id])
            ]
        ]);
        

        add_js_src('static/manager/js/r3d.bundle.js');
        add_js_src('static/manager/js/model-form.js');
        set_admin_template_data('modals', 'preview-modals');

        // dd($data);
    }

    public function getUploadForm(Request $request)
    {
        add_js_data('model_config', [
            'urls' => [
                'first_update' => route($this->routeNamePrefix.'3d.models.first-update'),
        
                'preview' => $this->getModuleRoute('preview'),
                'editor' => route($this->routeNamePrefix.'3d.items.edit', ['secret_id'=>'SECRET_ID'])
            ]
        ]);
        return $this->viewModule('upload');
    }

    /**
     * tải file lên bằng dropzone
     * @param Request $request
     * @return json
     */
    public function doUpload(Request $request)
    {

        extract($this->apiDefaultData);
        $secret_id = substr(md5(uniqid().time()), 10, 10);
        $this->repository->setValidatorClass(ModelItemUploadValidator::class);
        $validator = $this->repository->validator($request);
        $p = 'static/sources/models/'.$secret_id;
        if(!$validator->success()){
            $message = "Đã có lỗi xảy ra. Vui lòng kiểm tra lại!";
            $errors = $validator->errors();
        }elseif(!($file = $this->uploadFile($request, 'file', null, $p))){
            $message = "Đã có lỗi xảy ra. Không thể upload file";
        }
        // chết đoạn này à cai nà chỉ luu db thoi
        else{
            $pp = public_path($p);
            // $f = $request->file('file');
            $ext = strtolower($file->extension);
            $n = substr($file->original_filename, 0,strlen($file->original_filename)-1-strlen($ext) );
            $filename = $file->filename;
            $path = asset($p).'/';
            $s = true;
            $zip_file = null;
            if($ext == 'zip'){
                // dd();
                if(!$this->filemanager->extract($file->filepath, $pp)){
                    // $this->filemanager->delete($pp);
                    $s = false;
                    $message = 'Không thể giải nén';
                }
                else if(!($d = $this->find3DFile($pp, $p . '/'))){
                    $this->filemanager->delete($pp);
                    $s = false;
                    $message = 'Không tìm thấy file 3D';
                }
                else{
                    $path = asset($d['path']).'/';
                    $filename = $d['file'];
                    $ext = $d['ext'];
                    $zip_file = $filename;
                }
            }
            
            $e = strtolower($ext);
            if($e == 'glb') $e = 'gltf';

            $d = [
                'name' => $n,
                'path' => $path,
                'file' => $filename,
                'secret_id' => $secret_id,
                'user_id' => $request->user()->id,
                'zip_file' => $zip_file,
                'type' => $e,
                '__data__' => [
                    'size' => [
                        '__isObject' => true,
                    ],
                    'load_options' => [
                        'useRoughnessMipmapper' => true,
                        'materialNeedsUpdate' => true
                    ],
                    'settings' => [
                        '__isObject' => true,
                    ]
                ]
            ];

            if($s){
                if($model = $this->repository->create($d)){
                    $status = true;
                    $data = $this->repository->mode('mask')->detail($model->id);

                }else{
                    $message = "Đã có lỗi xảy ra. Vui lòng kiểm tra lại!";
                    $this->filemanager->delete($pp);
                }
            }
            // $data = $file->all();
            
        }
        
        return $this->json(compact(...$this->apiSystemVars));
    }
    
    public function find3DFile($dir, $rootPath = '')
    {
        $rp = rtrim($rootPath, '/') . '/';
        $list = $this->filemanager->getList($dir);
        foreach ($list as $item) {
            if($item->type == 'file'){
                if(in_array($e = strtolower($item->extension), $this->supportExtensions)){
                    return ['path' => $rootPath, 'file' => $item->name, 'ext' => $e];
                }
            }elseif($d = $this->find3DFile($item->path, $rp . $item->name)){
                return $d;
            }
        }
        return null;
    }


    public function FirstUpdate(Request $request)
    {
        extract($this->apiDefaultData);
        if(!$request->id || !($item = $this->repository->first(['id' => $request->id, 'user_id'=>$request->user()->id]))){
            $message = "Không tìm thấy model";
        }else{
            $d = $item->__data__;
            if(!is_array($d)){
                try {
                    $d = json_decode($d, true);
                } catch (\Throwable $th) {
                    $d = [
                        '__isObject' => true
                    ];
                }
            }
            if(is_array($request->size)){
                $item->__data__ = array_merge($d, ['size'=>$request->size]);

            }
            if($request->thumbnail && $file = $this->saveBase64Image($request->thumbnail, 'thumbnail', 'static/sources/models/'.$item->secret_id)){
                $item->thumbnail = $file->filename;
            }
            if(!$item->save()){
                $message = "Lỗi không xác định";
            }
            else{
                $status = true;
                $data = $this->repository->mode('mask')->detail($item->id);
            }
            
            
        }
        return $this->json(compact(...$this->apiSystemVars));
    }

    public function beforeDelete($model)
    {
        $this->filemanager->delete(public_path('static/sources/models/'.$model->id));
    }

    public function preview(Request $request)
    {
        if($request->secret_id && $model = $this->repository->mode('mask')->first(['secret_id' => $request->secret_id])){
            return $this->viewModule('preview', ['model'=>$model]);
        }
        $this->showError($request, 404);
    }
}
