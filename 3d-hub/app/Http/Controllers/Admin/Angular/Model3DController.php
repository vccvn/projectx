<?php

namespace App\Http\Controllers\Admin\Angular;

use App\Http\Controllers\Admin\AdminController;
use App\Repositories\Crazy3D\CategoryRepository;
// use App\Models\Post;
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
     * repository chinh
     *
     * @var CategoryRepository
     */
    public $categoryRepository;
    
    /**
     * @var array $supportExtensions
     */
    protected $supportExtensions = [];
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(ModelItemRepository $repository, CategoryRepository $categoryRepository)
    {
        $this->repository = $repository;
        $this->categoryRepository = $categoryRepository->addDefaultParam('deleted', 0);
        $this->init();
        
        // $this->activeMenu('3d.items');
        // $this->addHeaderButtons('create');
        $this->supportExtensions = get_3d_support_extensions();
    }

    public function getAngularEditemPage(Request $request)
    {
        if($request->secret_id && $model = $this->repository->mode('mask')->detail(['secret_id' => $request->secret_id])){
            return $this->viewModule('angular-editor', ['item'=>$model]);
        }
        $this->showError($request, 404);
    }


    public function getItemCategories(Request $request)
    {
        // extract($this->apiDefaultData);
        $categories = $this->categoryRepository->mode('mask')->getResults($request, [
            '@withItems' => 6
        ]);
        return $categories;
    }
}
