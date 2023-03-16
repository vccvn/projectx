<?php

namespace App\Http\Controllers\Admin\Ecommerce;

use Illuminate\Http\Request;
use App\Http\Controllers\Admin\AdminController;
use App\Repositories\Affiliates\ProductUrlRepository;
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

use App\Repositories\Files\FileRefRepository;
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
     * lien ket file
     *
     * @var FileRefRepository
     */
    protected $fileRefRepository;
    /**
     * @var WarehouseRepository $warehouseRepository
     */
    protected $warehouseRepository;

    /**
     * product affiliate url
     *
     * @var ProductUrlRepository
     */
    public $productUrlRepository;

    /**
     * @var string $warehouseActionType Hành động với kho hàng
     */
    protected $warehouseActionType = null;

    protected $makeThumbnail = true;
    protected $productTotal = 0;



    /**
     * chiều rộng ảnh xem trước
     *
     * @var integer
     */
    public $thumbWidth = 414;

    /**
     * chiều cao ảnh
     *
     * @var integer
     */
    public $thumbHeight = 414;

    /**
     * @var string $formLayout
    */
    // protected $formLayout = 'forms.grid';

    public $featureImageWidth = 414;
    public $featureImageHeight = 414;

    public $socialImageWidth = 600;
    public $socialImageHeight = 315;
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
        FileRefRepository $fileRefRepository,
        WarehouseRepository $warehouseRepository,
        ProductUrlRepository $productUrlRepository
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
        $this->fileRefRepository = $fileRefRepository;
        $this->warehouseRepository = $warehouseRepository;
        $this->productUrlRepository = $productUrlRepository;
        $this->init();

    }

    /**
     * cho phep can thiệp trước khi đổ ra view
     * @return void
     */
    public function beforeGetCrudForm($request, $config, $inputs, $data, $attribues)
    {
        $category = $data->category_id ? get_product_category(['id' => $data->category_id]):null;
        $baseTitle = (
            $category ? $category->name . ' | ' : ''
        ) . siteinfo('site_name');
        
        add_js_data('seo_data', [
            'baseURL' => url('san-pham') . '/',
            'data' => [
                'urlParh' => $data->slug,
                'title' => $data->meta_title,
                'metaDesc' => $data->meta_description,
                'content' => $data->content,
                'focusKeyword' => $data->focus_keyword,
                'fullTitle' => ($data->title ? $data->title . ' | ' : '') . $baseTitle,
                'baseTitle' => $baseTitle
            ],
            '__default__' => [
                'baseURL' => url('san-pham') . '/',
                'baseTitle' => $baseTitle
            ],
            '__placeholder__' => [
                'title' => $data->meta_title?$data->meta_title:(($data->title ? $data->title . ' | ' : 'Tiêu đề | ') . $baseTitle),
                'urlPath' => $data->slug??'slug'
            ]

        ]);
        add_js_src('/static/manager/js/product.form.js');
        add_js_data('crazy_form_data', 'attributes', [
            'input_url' => route($this->routeNamePrefix.'products.attribute-inputs'),
            'tag_src' => asset('static/crazy/js/tags.js')
        ]);

        // dd($data->all());
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
     * @param Request $request
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


        // upload và cap nhật file ành
        $this->uploadImageAttachFile($request, $data, 'feature_image', get_content_path('products'), $this->thumbWidth, $this->thumbHeight);

        $this->makeSocialImage($data, 'products');
        $specification = [];
        $props = $data->specification;
        if (is_array($props)) {
            foreach ($props as $input) {
                $item = [
                    'name' => $input['name'],
                    'list' => []
                ];
                if (array_key_exists('list', $input)) {
                    if (!is_array($input['list'])) $propList = json_decode($input['list'], true);
                    else $propList = $input['list'];
                    if ($propList) {
                        foreach ($propList as $p) {
                            if (array_key_exists('key', $p) && $p['key'] && !array_key_exists($p['key'], $item)) {
                                $item['list'][] = [
                                    'key' => $p['key'],
                                    'value' => $p['value'] ?? null
                                ];
                            }
                        }
                    }
                }


                $specification[] = $item;
            }
        }
        $data->specification = $specification;

    }

    /**
     * lưu các dữ liệu liên quan như thuộc tính, meta, gallery
     * @param Request $request
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
            'focus_keyword',
            'meta_title',
            'meta_description',
            'feature_image_keep_original',
            'feature_description',
            'specification',
            'download_url'
        ]));

        $this->fileRefRepository->updateFileRef('product', $product->id, $data->gallery??[]);
        // danh sach thuộc tính và các nhóm thuộc tính phân theo từng nhóm dược lấy ra từ validator
        $attributes = $this->validator->attributes;

        $variant_values = [];
        if($attributes['variant_images']){
            foreach ($attributes['variant_images'] as $value_id) {
                if($file = $this->uploadFile($request, 'variant_images.'.$value_id, 'product-variant-'.$product->id.'-'.$value_id, get_content_path('products/variants'))){
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
            $variant_values,
            is_array($request->attribute_default_selected)?$request->attribute_default_selected:[]
        );


        $this->productUrlRepository->updateProductUrls($product->id, is_array($data->affiliates)?$data->affiliates:[]);

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
