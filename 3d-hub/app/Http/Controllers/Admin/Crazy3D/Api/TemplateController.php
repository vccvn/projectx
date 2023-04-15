<?php

namespace App\Http\Controllers\Admin\Crazy3D\Api;

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Apis\ApiController;
use App\Masks\Crazy3D\CategoryMask;
use App\Repositories\Crazy3D\CategoryRepository;
use Crazy\Helpers\Arr;

use Illuminate\Http\Request;
use App\Repositories\Crazy3D\TemplateRepository;

class TemplateController extends ApiController
{
    protected $module = '3d.templates';

    protected $moduleName = 'Templates';

    protected $flashMode = true;

    /**
     * repository chinh
     *
     * @var TemplateRepository
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
    public function __construct(TemplateRepository $repository, CategoryRepository $categoryRepository)
    {
        $this->repository = $repository->mode('mask');
        $this->categoryRepository = $categoryRepository->addDefaultParam('deleted', 0);
        $this->init();
    }

    public function update3D(Request $request)
    {
        extract($this->apiDefaultData);
        if (!$request->id || !($template = $this->repository->first(['id' => $request->id]))) {
            $message = 'Model không tồn tại';
        } elseif (!$request->data) {
            $message = 'Không có dữ liệu';
        } elseif (!is_array($request->data)) {
            $message = 'Không có dữ liệu hoặc Dử liệu không hợp lệ';
        } elseif (!$this->repository->updateData($template, $request->data)) {
            $message = 'Dử liệu không hợp lệ';
        } else {
            $status = true;
            $data = $this->repository->mode('mask')->with(['itemrefs'=>function($q){$q->with('item');}])->detail(['id' => $request->id]);
        }
        return $this->json(compact(...$this->apiSystemVars));
    }


    public function updateThumbnail(Request $request)
    {
        extract($this->apiDefaultData);
        if (!$request->id || !($template = $this->repository->first(['id' => $request->id]))) {
            $message = 'Model không tồn tại';
        } elseif (!$request->thumbnail) {
            $message = 'Không có ảnh';
        } elseif (!($file = $this->saveBase64Image($request->thumbnail, $template->secret_id, 'static/sources/templates'))) {
            $message = 'Upload Không thành công';
        } elseif (!($template->thumbnail = $file->filename) || !($template->save())) {
            $message = 'Lỗi không xác định';
        } else {
            $status = true;
            $data = $template;
        }



        return $this->json(compact(...$this->apiSystemVars));
    }

    
    
    public function getTemplateCategories(Request $request)
    {
        // return $this->json($this->categoryRepository->mode('mask')->get());
        CategoryMask::$withTemplates = 6;
        return $this->getData(
            $request, 
            [], 
            $this->categoryRepository->mode('mask')
                                     ->leftJoin('crazy_3d_templates as templates', 'templates.category_id', '=', 'categories.id')
                                     ->select('categories.*')
                                     ->selectRaw('count(templates.id) as templates_count')
                                     ->havingRaw('count(templates.id) > 0')
                                     ->groupBy('categories.id')
        );
    }
}
