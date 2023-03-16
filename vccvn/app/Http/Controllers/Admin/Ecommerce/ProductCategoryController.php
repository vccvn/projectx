<?php

namespace App\Http\Controllers\Admin\Ecommerce;

use Illuminate\Http\Request;
use App\Http\Controllers\Admin\AdminController;

use App\Repositories\Products\CategoryRepository;
use App\Repositories\Metadatas\MetadataRepository;

use Crazy\Helpers\Arr;

class ProductCategoryController extends AdminController
{
    protected $module = 'products.categories';

    protected $moduleName = 'Danh mục';


    /**
     * @var string $formLayout
    */
    // protected $formLayout = 'forms.grid';
    

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
        $this->activeMenu('products');
        $this->addHeaderButtons('create');
    }


    /**
     * cho phep can thiệp trước khi đổ ra update form view 
     * @param Request $request
     * @param Arr $config
     * @param Arr $inputs
     * @param Arr $data
     * @param Arr $attrs
     * 
     */
    public function beforeGetUpdateForm(Request $request)
    {        
        $this->repository->setActiveID($request->id);
    }

    /**
     * can thiệp trước khi luu
     * @param \Illuminate\Http\Request $request
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
