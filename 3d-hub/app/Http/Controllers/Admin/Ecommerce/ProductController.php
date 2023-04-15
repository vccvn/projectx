<?php

namespace App\Http\Controllers\Admin\Ecommerce;

use Illuminate\Http\Request;
use App\Http\Controllers\Admin\AdminController;
use Crazy\Helpers\Arr;
use App\Repositories\Products\ProductRepository;
use App\Repositories\Products\CategoryRepository;
use App\Repositories\Products\AttributeRepository;
use App\Repositories\Products\AttributeValueRepository;
use App\Repositories\Products\ProductAttributeRepository;
use App\Repositories\Tags\TagRefRepository;
use App\Repositories\Metadatas\MetadataRepository;
use App\Repositories\Files\FileRepository;
use App\Repositories\Products\WarehouseRepository;

class ProductController extends AdminController
{
    protected $module = 'products';

    protected $moduleName = 'Sản phẩm';

    /**
     * @var ProductRepository $productRepository
     */
    public $repository;
    /**
     * @var CategoryRepository $categoryRepository
     */
    protected  $categoryRepository;
    /**
     * @var AttributeRepository $attributeRepository
     */
    protected $attributeRepository;
    /**
     * @var AttributeValueRepository $attributeValueRepository
     */
    protected $attributeValueRepository;
    /**
     * @var ProductAttributeRepository $productAttributeRepository
     */
    protected $productAttributeRepository;
    /**
     * @var TagRefRepository $tagRefRepository
     */
    protected $tagRefRepository;
    /**
     * @var MetadataRepository $metadataRepository
     */
    protected $metadataRepository;
    /**
     * @var FileRepository $fileRepository,
     */
    protected $fileRepository;
    /**
     * @var WarehouseRepository $warehouseRepository
     */
    protected $warehouseRepository;
    

    /**
     * @var string $warehouseActionType Hành động với kho hàng
     */
    protected $warehouseActionType = null;

    protected $makeThumbnail = true;
    protected $productTotal = 0;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(
        ProductRepository $productRepository,
        CategoryRepository $categoryRepository, 
        AttributeRepository $attributeRepository,
        AttributeValueRepository $attributeValueRepository,
        ProductAttributeRepository $productAttributeRepository,
        TagRefRepository $tagRefRepository,
        MetadataRepository $metadataRepository, 
        FileRepository $fileRepository,
        WarehouseRepository $warehouseRepository
    )
    {
        $this->repository = $productRepository;
        $this->categoryRepository = $categoryRepository;
        $this->attributeRepository = $attributeRepository;
        $this->attributeValueRepository = $attributeValueRepository;
        $this->productAttributeRepository = $productAttributeRepository;
        $this->tagRefRepository = $tagRefRepository;
        $this->metadataRepository = $metadataRepository;
        $this->fileRepository = $fileRepository;
        $this->warehouseRepository = $warehouseRepository;
        $this->init();
        
    }

    /**
     * cho phep can thiệp trước khi đổ ra view
     * @return void
     */
    public function beforeGetCrudForm()
    {
        add_js_src('/manager/js/product.form.js');
        add_js_data('crazy_form_data', 'attributes', [
            'input_url' => route($this->routeNamePrefix.'products.attribute-inputs'),
            'tag_src' => asset('static/crazy/js/tags.js')
        ]);
    }

    /**
     * can thiệp trước khi luu
     * @param Illuminate\Http\Request $request
     * @param Arr $data dũ liệu đã được validate
     * @param App\Models\Product $product
     * @return void
     */
    protected function beforeUpdate(Request $request, $data, $product)
    {
        $product_total = $product->countTotal();
        if($data->total > $product_total){
            $this->warehouseActionType = 'import';
            $this->productTotal = $data->total - $product_total;
        }elseif($data->total < $product_total){
            $this->warehouseActionType = 'export';
            $this->productTotal = $product_total - $data->total;
        }
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

        if($data->category_id){
            $data->category_map = $this->repository->makeCategoryMap($data->category_id);
        }
        

        $this->uploadImageAttachFile($request, $data, 'feature_image', 'static/products', 400, 400);
    }
    
    /**
     * lưu các dữ liệu liên quan như thuộc tính, meta, gallery
     * @param Illuminate\Http\Request $request
     * @param App\Models\Product $product
     * @param Crazy\Helpers\Arr $data dữ liệu từ input đã dược kiểm duyệt
     * 
     * @return void
     */
    public function afterSave(Request $request, $product, $data)
    {
        $this->tagRefRepository->updateTagRef('product', $product->id, $data->tags??[]);
        // meta data
        $this->metadataRepository->saveMany('product', $product->id, $data->copy([
            'custom_slug',
            'meta_title',
            'meta_description',
            'feature_image_keep_original',
            'feature_description'
        ]));
        //nếu có gallery
        if($request->id == $product->id){
            $this->fileRepository->deleteRefFileIgnoreList('product', $product->id, is_array($request->gallery_ids)?$request->gallery_ids:[]);
        }
        if($request->gallery_data){
            $this->fileRepository->saveBase64List($request->gallery_data, 'product', $product->id, $request->user()->id);
        }

        // danh sach thuộc tính và các nhóm thuộc tính phân theo từng nhóm dược lấy ra từ validator
        $attributes = $this->validator->attributes; 
        
        $variant_values = [];
        if($attributes['variant_images']){
            foreach ($attributes['variant_images'] as $value_id) {
                if($file = $this->uploadFile($request, 'variant_images.'.$value_id, 'product-variant-'.$product->id.'-'.$value_id, 'static/products/variants')){
                    $variant_values[$value_id] = $file->filename;
                }
            }
        }
        if($data->variant_colors && is_array($data->variant_colors)){
            foreach ($data->variant_colors as $value_id => $color) {
                $variant_values[$value_id] = $color;
            }
        }

        // set repository va save value
        $this->productAttributeRepository->setRepositories(
            $this->attributeRepository, 
            $this->attributeValueRepository
        )->saveAttributeValues(
            $product->id, 
            $product->category_id, 
            $data->attributes??[], 
            $attributes??[],
            $data->variants??[], 
            $data->variant_price??[],
            $variant_values
        );




        // kho hàng
        if($this->crudAction == 'update' && $this->warehouseActionType){
            $this->warehouseRepository->log($this->warehouseActionType, $product->id, $this->productTotal, "Cập nhật sản phẩm", $request->user()->id);
        }
        elseif($this->crudAction == 'create' && $data->total){

            $this->warehouseRepository->log('import', $product->id, $data->total, "Thêm mới sản phẩm", $request->user()->id);
        }
    
    }

    



    /**
     * lấy chi tiết thuộc tính
     * @param Request $request
     * @return json
     */
    public function getAttributeByCategory(Request $request)
    {
        extract($this->apiDefaultData);
        
        if($category = $this->categoryRepository->findBy('id', $request->category_id)){
            $status = true;
            $data = [];
            // lấy cây danh mục id: ví dụ cha > con > cháu ==> [parent_id, id, child_id]
            $category_id_map = $category->getMap();
            // lấy thuộc tính theo mảng danh mục id 
            if(count($attrs = $this->attributeRepository->get(['category_id' => $category_id_map]))){
                foreach ($attrs as $attr) {
                    // Tham số cho input
                    $params = $attr->toProductInputParam($request->product_id??0);
                    if($attr->value_type == 'decimal'){
                        $params['step'] = 0.1;
                    }
                    // lấy mã html
                    $input = $this->view('forms.attribute-input', ['root_name' => 'attributes', 'params' => $params])->render();

                    $data[] = [
                        'input_type' => $attr->input_type,
                        'value_type' => $attr->value_type,
                        'input_name' => $attr->name,
                        'input_label' => $attr->lanel,
                        'input_id'   => $attr->id,
                        'input_group' => $attr->is_variant?'variants':($attr->is_required?'required':'optional'),
                        'html_code' => $input,
                    ];
                    
                }
            }

        }
    
        return $this->json(compact(...$this->apiSystemVars));
    }



    /**
     * tim kiếm thông tin sản phẩm
     * @param Request $request
     * @return json
     */
    public function getProductSelectOptions(Request $request)
    {
        extract($this->apiDefaultData);

        if($options = $this->repository->getProductSelectOptions($request, ['@limit'=>10])){
            $data = $options;
            $status = true;
        }else{
            $message = 'Không có kết quả phù hợp';
        }

        return $this->json(compact(...$this->apiSystemVars));
    }

    

    /**
     * tim kiếm thông tin sản phẩm
     * @param Request $request
     * @return json
     */
    public function getProductTagData(Request $request)
    {
        extract($this->apiDefaultData);

        if($options = $this->repository->getProductTagData($request, ['@limit'=>10])){
            $data = $options;
            $status = true;
        }else{
            $message = 'Không có kết quả phù hợp';
        }

        return $this->json(compact(...$this->apiSystemVars));
    }




}
