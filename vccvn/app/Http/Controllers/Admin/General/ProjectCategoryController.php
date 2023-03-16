<?php

namespace App\Http\Controllers\Admin\General;

use Illuminate\Http\Request;
use App\Http\Controllers\Admin\AdminController;
use Crazy\Helpers\Arr;

use App\Repositories\Projects\CategoryRepository;
use App\Repositories\Metadatas\MetadataRepository;

class ProjectCategoryController extends AdminController
{
    protected $module = 'projects.categories';

    protected $moduleName = 'Danh mục Dự án';

    protected $flashMode = true;
    
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(CategoryRepository $CategoryRepository, MetadataRepository $MetadataRepository)
    {
        $this->repository = $CategoryRepository;
        
        $this->metadatas = $MetadataRepository;

        $this->init();
        $this->activeMenu('projects');
        $this->addHeaderButtons('create');
    }


    
    /**
     * cho phep can thiệp trước khi đổ ra update form view 
     * @param Request $request
     * 
     */
    public function beforeGetUpdateForm(Request $request)
    {        
        $this->repository->setActiveID($request->id);
    }

    /**
     * can thiệp trước khi luu
     * @param Illuminate\Http\Request $request
     * @param Arr $data dũ liệu đã được validate
     * @return void
     */
    protected function beforeSave(Request $request, $data)
    {
        $data->slug = $this->repository->getSlug(
            $request->slug ?? $request->name,
            $request->id
        );
        $this->uploadImageAttachFile($request, $data, 'feature_image', get_content_path('categories'));
    }


    /**
     * tim kiếm thông tin người dùng 
     * @param Request $request
     * @return json
     */
    public function getCategoryOptions(Request $request)
    {
        extract($this->apiDefaultData);
        if($options = $this->repository->getCategoryOptions($request->all())){
            $data = $options;
            $status = true;
        }else{
            $message = 'Không có kết quả phù hợp';
        }

        return $this->json(compact(...$this->apiSystemVars));
    }


}
