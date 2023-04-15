<?php

namespace App\Http\Controllers\Admin\Crazy3D;

use App\Engines\CrazyHashEngine;
use App\Http\Controllers\Admin\AdminController;
use App\Repositories\Crazy3D\ItemRefRepository;
use App\Repositories\Crazy3D\TemplateRepository;
use Illuminate\Http\Request;
use Crazy\Helpers\Arr;

// use App\Repositories\Templates\TemplateRepository;

class TemplateController extends AdminController
{
    protected $module = '3d.templates';

    protected $moduleName = 'Template';

    protected $flashMode = true;

    /**
     * repository chinh
     *
     * @var TemplateRepository
     */
    public $repository;

    /**
     * item ref repository
     *
     * @var ItemRefRepository
     */
    public $itemRefRepository = null;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(TemplateRepository $repository, ItemRefRepository $itemRefRepository)
    {
        $this->repository = $repository;
        $this->itemRefRepository = $itemRefRepository;
        $this->init();
    }
    public function beforeGetUpdateForm($request, $config, $inputs, $data, $attrs)
    {
        add_css_link('static/manager/css/3d-form.min.css');
        add_js_src('static/manager/js/3d-form.js');
        add_js_data('__3D_Config__', [
            'urls' => [
                'create_default' => $this->getModuleRoute('create-default'),
        
                'preview' => $this->getModuleRoute('preview'),
                'editor' => $this->getModuleRoute('edit', ['secret_id'=>'SECRET_ID']),
            ]
        ]);
        
    }
    public function getCreateForm(Request $request)
    {
        add_js_data('__3D_Config__', [
            'urls' => [
                'create_default' => $this->getModuleRoute('create-default'),
        
                'preview' => $this->getModuleRoute('preview'),
                'editor' => $this->getModuleRoute('edit', ['secret_id'=>'SECRET_ID']),
            ]
        ]);
        return $this->viewModule('create');
    }

    public function createDefault(Request $request)
    {
        extract($this->apiDefaultData);
        $sid = substr(md5(uniqid().time()), 5, 16);
        $d = [
            'name' => $request->name?$request->name:'untitle',
            'category_id' => $request->category_ide?$request->category_id:0,
            'description' => $request->description?$request->description:'',
            'status' => $request->status?$request->status:'',
            '__data__' => $this->filemanager->json(json_path('data/3d/template.json')),
            'secret_id' => $sid,
            'thumbnail' => $this->filemanager->copyFile(public_path('static/images/default/no-image.png'), public_path('static/sources/templates/'.$sid.'.png'))?$sid.'.png':null
        ];
        if(!($template = $this->repository->save($d))){
            $message = 'Không thể tạo file nháp';
        }
        else{
            $status = true;
            $data = $this->repository->mode('mask')->detail($template->id);
        }

        return $this->json(compact(...$this->apiSystemVars));
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

    public function getAngularEditTemplatePage(Request $request)
    {
        if($request->secret_id && $template = $this->repository->mode('mask')->with(['itemrefs'=>function($q){$q->with('item');}])->detail(['secret_id' => $request->secret_id])){
            // dd($this->itemRefRepository->get());       
            // return $this->json($template);     
            return $this->viewModule('angular-editor', ['template'=>$template]);
        }
        $this->showError($request, 404);
    }
}
