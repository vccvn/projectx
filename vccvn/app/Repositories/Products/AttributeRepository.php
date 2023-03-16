<?php

namespace App\Repositories\Products;

use App\Repositories\Base\BaseRepository;

class AttributeRepository extends BaseRepository
{
    /**
     * class chứ các phương thức để validate dử liệu
     * @var string $validatorClass
     */
    protected $validatorClass = 'App\Validators\Products\AttributeValidator';
    /**
     * @var string $resource
     */
    protected $resourceClass = 'AttributeResource';
    /**
     * @var string $collectionClass
     */
    protected $collectionClass = 'AttributeCollection';


    protected $responseMode = 'resource';

    /**
     * tên class mặt nạ. Thược có tiền tố [tên thư mục] + \ vá hậu tố Mask
     *
     * @var string
     */
    protected $maskClass = 'Products\AttributeMask';

    /**
     * tên collection mặt nạ
     *
     * @var string
     */
    protected $maskCollectionClass = 'Products\AttributeCollection';
    /**
     * get model
     * @return string
     */
    public function getModel()
    {
        return \App\Models\Attribute::class;
    }

    /**
     * thiết lập
     * @return void
     */
    public function init()
    {

    }


    /**
     * xữ lý trước khi lấy dữ liệu
     *
     * @param array $args
     * @return void
     */
    public function beforeGetData($args = []){
        if(is_array($args) && (isset($args['@category']) || array_key_exists('@category', $args))){
            $cat = $args['@category'];
            if(is_array($cat)){
                foreach ($cat as $key => $c) {
                    $this->like('attributes.category_map', " $c,");
                }
            }else{
                $this->like('attributes.category_map', " $cat,");
            }
        }
    }



    public function getAttributeData($args = [])
    {
        $this->with('values');
        return $this->parseCollection($this->get($args));
    }



    /**
     * khoi tao category repository
     */
    public function categories()
    {
        return new CategoryRepository();
    }
    /**
     * tạo cây danh mục
     * @param int $category_id
     * @return string ví dụ: " 1, 4, 6,"
     */
    public function makeCategoryMap($category_id = 0)
    {
        if(!$category_id) return null;
        $rep = new CategoryRepository();
        $cate = $rep->find($category_id);
        $str='';
        if($cate){
            $str = ' '.implode(', ', $cate->getMap()).',';
        }

        return $str;
    }


    /**
     * lấy thông tin input thuộc tính
     * @param int $category_id
     * @param bool $all
     * @return array mảng thuộc tính ưu tiên required
     */
    public function getAttributeInput($category_id = 0, $all = false) : array
    {
        // các thuộc tính bắt buộc
        $required = [];
        // thuộc tính tùy chôn
        $optional = [];

        $variants = [];
        // nếu dược yêu cầu lấy các thuộc tính chung thì sẽ lấy thuộc tính chung trước
        if($all){
            if(count($attrib = $this->get(['category_id' => 0, 'is_variant' => 0]))){
                foreach ($attrib as $attribute) {
                    // phân loại bắt buộc và tùy chọn
                    if($attribute->is_required){
                        $required[] = $attribute;
                    }else{
                        $optional[] = $attribute;
                    }
                }
            }
            if(count($attrs = $this->get(['category_id' => 0, 'is_variant' => 1]))){
                foreach ($attrs as $attribute) {
                    $variants[] = $attribute;
                }
            }

        }



        // lấy thuộc tính theo danh mục
        if($category_id && $category = $this->categories()->first(['id'=>$category_id])){
            // lấy cây danh mục id: ví dụ cha > con > cháu ==> [parent_id, id, child_id]
            $category_id_map = $category->getMap();
            // lấy thuộc tính theo mảng danh mục id
            if(count($attr2 = $this->get(['category_id' => $category_id_map, 'is_variant' => 0]))){
                foreach ($attr2 as $attr) {
                    if($attr->is_required){
                        $required[] = $attr;
                    }else{
                        $optional[] = $attr;
                    }
                }
            }
            if(count($attr3 = $this->get(['category_id' => $category_id_map, 'is_variant' => 1, '@order_by' => ['price_type'=> 'DESC']]))){
                foreach ($attr3 as $att) {
                    $variants[] = $att;
                }
            }

        }
        $attributes = compact('required', 'optional');
        return compact('attributes', 'variants');
    }


    /**
     * lấy thông tin input thuộc tính
     * @param int $produxt_id
     * @param bool $all
     * @return array mảng thuộc tính ưu tiên required
     */
    public function getVariantAttributeInput($produxt_id = 0, $all = false) : array
    {
        // các thuộc tính bắt buộc
        $inputs = [];

        $args = ['category_id' => 0, 'is_required' => 1, 'has_price' => 1, 'is_order_option' => 1];
        // nếu dược yêu cầu lấy các thuộc tính chung thì sẽ lấy thuộc tính chung trước
        if($all && count($attributes = $this->get($args))){
            foreach ($attributes as $attribute) {
                // phân loại bắt buộc và tùy chọn
                $inputs[] = $attribute;
            }
        }

        if($product = app(ProductRepository::class)->find($produxt_id)){
            // lấy thuộc tính theo danh mục
            if($product->category_id && $category = $this->categories()->first(['id'=>$product->category_id])){
                // lấy cây danh mục id: ví dụ cha > con > cháu ==> [parent_id, id, child_id]
                $category_id_map = $category->getMap();

                $args['category_id'] = $category_id_map;
                // lấy thuộc tính theo mảng danh mục id
                if(count($attrs = $this->get($args))){
                    foreach ($attrs as $attr) {
                        $attr->input_type = 'select';
                        $inputs[] = $attr;
                    }
                }
            }
        }

        return $inputs;
    }







    /**
     * lấy thông tin input thuộc tính
     * @param int $category_id
     * @return array mảng thuộc tính ưu tiên required
     */
    public function getOrderAttribute($category_id = 0)
    {

        $params = [
            'is_required' => 1,
            'is_order_option' => 1
        ];


        $category_map = [0];


        // lấy thuộc tính theo danh mục
        if($category_id && $category = $this->categories()->first(['id'=>$category_id])){
            // lấy cây danh mục id: ví dụ cha > con > cháu ==> [parent_id, id, child_id]
            $category_map = array_merge($category_map, $category->getMap());
            // lấy thuộc tính theo mảng danh mục id
        }

        $params['category_id'] = $category_map;

        return $this->get($params);
    }

    /**
     * lấy thông tin input thuộc tính
     * @param int $category_id
     * @return array mảng thuộc tính ưu tiên required
     */
    public function getOrderAttributeValues($category_id = 0, $product_id = 0)
    {

        $params = [
            'attributes.is_required' => 1,
            'attributes.is_order_option' => 1
        ];


        $category_map = [0];


        // lấy thuộc tính theo danh mục
        if($category_id && $category = $this->categories()->first(['id'=>$category_id])){
            // lấy cây danh mục id: ví dụ cha > con > cháu ==> [parent_id, id, child_id]
            $category_map = array_merge($category_map, $category->getMap());
            // lấy thuộc tính theo mảng danh mục id
        }

        $params['attributes.category_id'] = $category_map;

        return $this->join('attribute_values', 'attribute_values.attribute_id', 'attributes.id')
            ->join('product_attributes', 'product_attributes.attribute_value_id', 'attribute_values.id')
            ->where('product_attributes.product_id', $product_id)
            ->get($params);
    }



}
