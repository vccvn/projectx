<?php

namespace App\Http\Controllers\Admin\General;

use Illuminate\Http\Request;
use App\Http\Controllers\Admin\AdminController;

use App\Repositories\Dynamics\DynamicRepository;

use App\Repositories\Metadatas\MetadataRepository;
use App\Repositories\Posts\CategoryRepository;
use Crazy\Helpers\Arr;

class DynamicController extends AdminController
{
    protected $module = 'dynamics';

    protected $moduleName = 'Nội dung';
    

    /**
     * @var App\Repositories\Dynamics\DynamicRepository $repository
     */
    public $repository;

    /**
     * @var string $formLayout
    */
    protected $formLayout = 'forms.grid';
    

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(DynamicRepository $dynamicRepository, MetadataRepository $MetadataRepository, CategoryRepository $categoryRepository)
    {
        $this->repository = $dynamicRepository;

        $this->metadatas = $MetadataRepository;

        $this->categoryRepository = $categoryRepository->addDefaultParam('deleted', 0);
        $this->init();
        
    }

    
    /**
     * can thiệp trước khi luu
     * @param Illuminate\Http\Request $request
     * @param Arr $data dũ liệu đã được validate
     * @return void
     */
    protected function beforeSave(Request $request, $data)
    {
        $slug = str_slug($request->custom_slug? $request->slug : $request->name);
        $data->slug = $this->repository->getSlug(
            $slug?$slug : uniqid(),
            $request->id
        );

        $this->uploadImageAttachFile($request, $data, 'feature_image', 'static/dynamics');

    }

    

    /**
     * can thiệp sau khi luu
     * @param Illuminate\Http\Request $request
     * @param Model $model dũ liệu đã được luu
     * @return void
     */
    protected function afterSave(Request $request, $model)
    {
        $this->repository->saveFormInfo($model->id, $request->all());
    }

    
    /**
     * can thiệp sau khi tạo mới
     * @param Illuminate\Http\Request $request
     * @param Model $model dũ liệu đã được luu
     * @return void
     */
    protected function afterCreate(Request $request, $model)
    {
        // thay đổi route chuyển hướng
        $this->redirectRoute = 'posts.config';
        $this->redirectRouteParams = [
            'dynamic' => $model->slug
        ];

    }


    



    /**
     * tim kiếm thông tin người dùng 
     * @param Request $request
     * @return json
     */
    public function getDynamicSelectOptions(Request $request)
    {
        extract($this->apiDefaultData);

        if($options = $this->repository->getDynamicSelectOptions($request)){
            $data = $options;
            $status = true;
        }else{
            $message = 'Không có kết quả phù hợp';
        }

        return $this->json(compact(...$this->apiSystemVars));
    }

    
    
    /**
     * lấy danh sách category
     * @param Request $request
     */
    public function getCategoryOptions(Request $request)
    {
        extract($this->apiDefaultData);

        if($request->dynamic_id && $dynamic = $this->repository->dynamic($request->dynamic_id)){
            if($dynamic->use_category){
                $status = true;
                if($options = $this->categoryRepository->getCategoryOptions(['dynamic_id'=>$dynamic->id])){
                    $data = $options;
                }
            }
        }

        return $this->json(compact(...$this->apiSystemVars));
    }


}
