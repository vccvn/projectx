<?php

namespace App\Http\Controllers\Admin\Ecommerce;

use Illuminate\Http\Request;
use App\Http\Controllers\Admin\AdminController;

use App\Repositories\Products\AttributeRepository;

use Crazy\Helpers\Arr;
use App\Repositories\Products\CategoryRepository;

class ProductAttributeController extends AdminController
{
    protected $module = 'products.attributes';

    protected $moduleName = 'Thuộc tính';



    /**
     * @var string $formLayout
    */
    // protected $formLayout = 'forms.grid';
    

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(AttributeRepository $AttributeRepository, CategoryRepository $categoryRepository)
    {
        $this->repository = $AttributeRepository;
        $this->categoryRepository = $categoryRepository;
        $this->repository->mode('mask');
        $this->init();
        $this->activeMenu('products');
        $this->activeMenu('admin.'.$this->module);
        $this->addHeaderButtons('create');
        
    }


    /**
     * cho phep can thiệp trước khi đổ ra view
     * @param Request $request
     * @param Arr $config
     * @param Arr $inputs
     * @param Arr $data
     * @param Arr $attrs
     * 
     * @return void
     */
    public function beforeGetCrudForm()
    {
        add_js_src('/manager/js/product.attributes.js');
        // add_css_link('/manager/css/product.attributes.min.css');
    }

    /**
     * can thiệp trước khi luu
     * @param Illuminate\Http\Request $request
     * @param Arr $data dũ liệu đã được validate
     * @return void
     */
    protected function beforeSave(Request $request, $data)
    {
        // kiểu giá trị của niến in thường để tiện so sánh
        $value_type             = strtolower($data->value_type);
        // điều kiện để thuộc tính có thể được query hoặc xuất hiện trong order
        $isQueryOption          = ($data->is_required && $value_type != 'text');
        // --------------------------------------------------------------------------------------------------------
        //     biến             | diều kiện                               | giá trị                   | mặc dịnh   
        // --------------------------------------------------------------------------------------------------------
        // thuộc tinh có giá trị duy nhất
        $data->is_unique        = $isQueryOption                          ? $data->is_unique          : 0;
        // có thể tìm kiếm sản phẩm theo thuộc tính hay ko
        $data->is_query         = $isQueryOption                          ? $data->is_query           : 0;
        // thuộc tính có phải là tùy chọn trong order hay ko
        $data->is_order_option  = ($isQueryOption && !$data->is_unique)   ? $data->is_order_option    : 0;
        // kiểu nhập giá trị thuộc tính
        $data->input_type       = ($isQueryOption && !$data->is_unique)   ? $data->input_type         : 'default';
        // thuộc tính có thể chứ giá hoặc làm thay đổi giá sản phẩm
        $is_variant             = $data->is_order_option                  &&$data->input_type         =='checklist';
        $data->is_variant       = $is_variant                             ? $data->is_variant         : 0;
        // loại giá 0 là cộng dồn vào giá ản phẩm 1 là thay thế toàn bộ giá sản phẩm
        $data->price_type       = $data->is_variant                       ? $data->price_type         : 0;
        $type_list              = ['int', 'decimal'];
        // đơn vị cụa giá trị thuộc tính. chỉ dùng để hiển thị
        $data->value_unit       = in_array($value_type, $type_list)       ? $data->value_unit         : null;
        $type_list[]            = 'varchar';
        $show                   = in_array($value_type, $type_list);
        // sử dụng 1 danh sách các giá trị có trước đó
        $use_list               = $show && ($data->is_query || $data->is_order_option);
        $data->use_list         = $use_list                               ? 1                         : 0;
        // hiển thị tùy chọn trong đơn hàng
        $data->show_type        = ($show && $data->is_order_option)       ? $data->show_type          : 'simple';
        // category_map
        $data->category_map     = $this->repository->makeCategoryMap($data->category_id);
    }


        
    /**
     * lấy chi tiết thuộc tính
     * @param Request $request
     * @return json
     */
    public function getAttributeDetail(Request $request, $id = null)
    {
        extract($this->apiDefaultData);
        if($attribute = $this->repository->mode('mask')->with(['values'])->detail($request->id)){
            $data = $attribute;
            $status = true;
        }else{
            $message = 'Không có kết quả phù hợp';
        }

        return $this->json(compact(...$this->apiSystemVars));
    }

}
