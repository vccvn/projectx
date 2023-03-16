<?php

namespace App\Repositories\Products;

use App\Repositories\Base\BaseRepository;
use App\Repositories\Metadatas\MetadataRepository;
use App\Repositories\Orders\OrderRepository;
use Crazy\Helpers\Arr;

class ProductRepository extends BaseRepository
{
    /**
     * class chứ các phương thức để validate dử liệu
     * @var string $validatorClass
     */
    protected $validatorClass = 'App\Validators\Products\ProductValidator';
    /**
     * @var string $resource
     */
    protected $resourceClass = 'App\Http\Resources\ProductResource';
    /**
     * @var string $collectionClass
     */
    protected $collectionClass = 'App\Http\Resources\ProductCollection';

    /**
     * tên class mặt nạ. Thược có tiền tố [tên thư mục] + \ vá hậu tố Mask
     *
     * @var string
     */
    protected $maskClass = 'Products\ProductMask';

    /**
     * tên collection mặt nạ
     *
     * @var string
     */
    protected $maskCollectionClass = 'Products\ProductCollection';
    /**
     * @var string $system
     */
    protected $system = 'both';

    /**
     * @var \App\Repositories\Metadatas\MetadataRepository $metadataRepository
     */
    public $metadataRepository;


    /**
     * @var \App\Repositories\Products\AttributeRepository $attributeRepository
     */
    public $attributeRepository;

    /**
     * @var array $sortByRules kiểu sắp xếp
     */
    protected $sortByRules = [
        1 => 'id-DESC',
        2 => 'name-ASC',
        3 => 'name-DESC',
        4 => 'list_price-ASC',
        5 => 'list_price-DESC',
        6 => 'rand()',
        7 => 'id-ASC',

    ];


    /**
     * @var array $defaultSortBy Mảng key value là twen6 cộ và kiểu sắp xếp
     */
    protected $defaultSortBy = [
        'products.id' => 'DESC'
    ];



    /**
     * prefix attribute name
     *
     * @var string
     */
    public $attributePrefix = 'product_';

    /**
     * get model
     * @return string
     */
    public function getModel()
    {
        return \App\Models\Product::class;
    }

    /**
     * thiết lập
     * @return void
     */
    public function init()
    {
        $this->metadataRepository = new MetadataRepository();
        $this->attributeRepository = new AttributeRepository();
        $this->attributePrefix = get_attribute_request_name_prefix();
        $this->setJoinable([
            ['leftJoin', 'categories', 'categories.id', '=', 'products.category_id']
        ]);
        $raw = [
            'category_id', 'name', 'sku',
            'list_price', 'sale_price', 'on_sale', 'views', 'privacy', 'status',
        ];
        $columns = [
            'category_name' => 'categories.name',
            'category_keywords' => 'categories.keywords',
        ];
        $this->setSelectable(array_merge($columns, ['products.*']));
        $this->setSearchable(array_merge($columns, [
            'name' => 'products.name',
            'keywords' => 'products.keywords',
            'sku' => 'products.sku'
        ]));
        foreach ($raw as $col) {
            $columns[$col] = 'products.' . $col;
        }
        $this->setSortable($columns);

        $this->registerCacheMethods('getProductDetail', 'search', 'getProducts');
    }


    /**
     * xữ lý trước khi lấy dữ liệu
     *
     * @param array $args
     * @return void
     */
    public function beforeGetData($args = [])
    {
        if (is_array($args) && (isset($args['@category']) || array_key_exists('@category', $args))) {
            $cat = $args['@category'];
            if (is_array($cat)) {
                foreach ($cat as $key => $c) {
                    $this->like('products.category_map', " $c,");
                }
            } else {
                $this->like('products.category_map', " $cat,");
            }
        }
    }

    public function beforeFilter($request)
    {
        if ($request->category) {
            $cat = $request->category;
            if (is_array($cat)) {
                foreach ($cat as $key => $c) {
                    $this->like('products.category_map', " $c,");
                }
            } else {
                $this->like('products.category_map', " $cat,");
            }
        }
    }

    /**
     * lấy chi tiết sản phẩm
     *
     * @param array $args
     * @return \App\Models\Product[]|\App\Masks\Products\ProductCollection
     */
    public function getProducts(array $args = [])
    {
        if (isset($args['@withVariant'])) {
            if ($args['@withVariant']) {
                $this->with('variants');
            }
            unset($args['@withVariant']);
        }
        if (isset($args['@withOption'])) {
            if ($args['@withOption']) {
                $this->with('orderOptions');
            }
            unset($args['@withOption']);
        }
        if (isset($args['@withReview'])) {
            if ($args['@withReview']) {
                $this->with('reviews');
            }
            unset($args['@withOReview']);
        }


        if (isset($args['@promo'])) {
            if ($args['@promo']) {
                $this->join('product_refs', 'product_refs.product_id', '=', 'products.id')
                    ->where('product_refs.ref', 'promo')
                    ->where('product_refs.ref_id', $args['@promo']);
            }
            unset($args['@promo']);
        }
        $a = false;
        foreach (['', 'type', 'Type', '_type'] as $k) {
            if (isset($args['@sort' . $k])) {
                if (!$a) {
                    $this->parseSortBy($args['@sort' . $k]);
                    $a = true;
                }
                unset($args['@sort' . $k]);
            }
        }
        return $this->parseCollection($this->get($args));
    }

    /**
     * xử lý order by cho hàm lấy sản phẩm
     *
     * @param array|string $sortBy
     * @return void
     */
    public function parseSortBy($sortBy)
    {
        if (is_array($sortBy)) {
            // truong hop mang toan index la so
            if (Arr::isNumericKeys($sortBy)) {
                foreach ($sortBy as $by) {
                    $this->checkSortBy($by);
                }
            } else {
                foreach ($sortBy as $column => $type) {
                    if (is_numeric($column)) {
                        $this->checkSortBy($type);
                    } elseif (strtolower($column) == 'seller') {
                        $this->orderBySeller($type);
                    } else {
                        $this->order_by($column, $type);
                    }
                }
            }
        } else {
            $this->checkSortBy($sortBy);
        }
    }


    /**
     * kiểm tra tính hợp lệ của tham sớ truyền vào
     *
     * @param string $sortBy
     * @param string $type
     * @return void
     */
    protected function checkSortBy($sortBy = null, $type = null)
    {
        if (in_array($sortBy, $this->sortByRules)) {
            $this->orderByRule($sortBy);
        } elseif (array_key_exists($sortBy, $this->sortByRules)) {
            $this->orderByRule($this->sortByRules[$sortBy]);
        } elseif (strtolower($sortBy) == 'seller') {
            $this->orderBySeller($type ? $type : 'DESC');
        } elseif ($sortBy) {
            $this->order_by($sortBy, $type ? $type : 'ASC');
        }
    }


    /**
     * order by rule
     *
     * @param string $rule
     * @return void
     */
    protected function orderByRule($rule)
    {
        if ($rule == 'rand()') {
            $this->orderByRaw($rule);
        } else {
            $a = explode('-', $rule);
            $this->order_by($a[0], $a[1]);
        }
    }

    /**
     * Undocumented function
     *
     * @param string $type
     * @return void
     */
    protected function orderBySeller($type = 'DESC')
    {
        if (strtoupper($type) != 'ASC') $type = 'DESC';
        $this->leftJoin('order_items', 'order_items.product_id', '=', 'products.id')
            ->join('orders', 'orders.id', '=', 'order_items.order_id')
            ->where('orders.status', OrderRepository::COMPLETED)
            ->groupBy('products.id');
        $this->select('products.*')->selectRaw('COUNT(order_items.product_id) AS sell_total');
        $this->orderByRaw('COUNT(order_items.product_id) ' . $type);
    }
    /**
     * lấy chi tiết sản phẩm
     *
     * @param array $args
     * @return \App\Models\Product|\App\Masks\Products\ProductMask
     */
    public function getProductDetail(array $args = [])
    {
        if (!$args) return null;
        $detail = $this->with([
            'Shop', 'category', 'metadatas', 'gallery', 'reviews', 'affiliates',
            'notOrderOptions', 'variants', 'notVariantAttributes', 'promoAvailable',
            'publishComments' => function ($query) {
                $query->with(['publishChildren' => function ($query) {
                    $query->with(['publishChildren' => function ($query) {
                        $query->with('publishChildren');
                    }]);
                }]);
            }
        ])->first($args);
        return $this->parseDetail($detail);
    }
    /**
     * lấy chi tiết sản phẩm
     *
     * @param array $args
     * @return \App\Models\Product|\App\Masks\Products\ProductMask
     */
    public function getProductDetailData(array $args = [])
    {
        if (!$args) return null;
        $detail = $this->with([
            'shop', 'category', 'metadatas', 'gallery', 'reviews',
            'orderOptions', 'variants', 'notVariantAttributes', 'affiliates',
            'publishComments' => function ($query) {
                $query->with(['publishChildren' => function ($query) {
                    $query->with(['publishChildren' => function ($query) {
                        $query->with('publishChildren');
                    }]);
                }]);
            }
        ])->first($args);
        return $this->parseDetail($detail);
    }



    /**
     * tìm kiếm phía client
     *
     * @param Request $request
     * @param string $keywords
     * @param array $args
     * @return \App\Models\Product[]|\App\Masks\Products\ProductCollection
     */
    public function search($request, $keywords = null, $args = [])
    {
        $s = $keywords;
        $category = 0;
        // danh sach category id theo thu tu root > parent > child > ...
        $attributeCategoryMap = [0];
        if (isset($args['category_id'])) {
            $category = $args['category_id'];
            unset($args['category_id']);
        }
        if (isset($args['category'])) {
            $category = $args['category'];
            unset($args['category']);
        }
        if (isset($args['@category'])) {
            $category = $args['@category'];
        } elseif ($category) {
            $args['@category'] = $category;
        }

        if (isset($args['@attribute_category_map'])) {
            $attributeCategoryMap = $args['@attribute_category_map'];
        }

        $a = false;
        foreach (['', 'type', 'Type', '_type'] as $k) {
            if (isset($args['@sort' . $k])) {
                if (!$a) {
                    $this->parseSortBy($args['@sort' . $k]);
                    $a = true;
                }
                unset($args['@sort' . $k]);
            }
        }


        // tim kiếm theo tu khoa
        if (strlen($s)) {
            $this->where(function ($query) use ($s) {
                $t = 'products.';
                // tu khoa nam trong ten san pham
                $query->where($t . 'name', 'like', "%$s%");
                // tu khoa nam trong han meta keyword
                $query->orWhere($t . 'keywords', 'like', "%$s%");
                // tim theo tag
                $query->orWhereRaw(
                    $t . "id in ("
                        . "SELECT tag_refs.ref_id FROM tag_refs INNER JOIN tags ON tags.id = tag_refs.tag_id "
                        . "WHERE tag_refs.ref = 'product' AND "
                        . "(tags.name_lower like '%" . str_replace("'", "\'", strtolower($s)) . "%' OR tags.slug like '%" . str_slug($s) . "%')"
                        . ")"
                );
                // hoac bang mã sp
                $query->orWhere($t . 'sku', '=', $s);
            });
        }
        /// build orderby cac thu
        $this->prepareFilter($request);
        $this->buildJoin();
        $this->buildSelect();

        // lọc theo khoảng giá

        if (is_numeric($request->min_price)) {
            $this->where('products.list_price', '>=', $request->min_price);
        }
        if (is_numeric($request->max_price)) {
            $this->where('products.list_price', '<=', $request->max_price);
        }

        // tim san pham theo thuoc tinh


        // lấy thuộc tính từ request
        $reqAttrs = Arr::prefix($request->all(), $this->attributePrefix, true, function ($val) {
            if (is_string($val) && preg_match('/\,/', $v = trim($val, ',\s'))) {
                return array_map('trim', explode(',', $v));
            } elseif (is_array($val)) {
                $value = [];
                foreach ($val as $v) {
                    if (is_numeric($v) || (is_string($v) && strlen($v))) {
                        $value[] = $v;
                    }
                }
                return count($value) ? $value : null;
            }
            return $val;
        }, true);

        // them tham so de lay ra trong viww neu can
        set_attribute_request_data($reqAttrs);
        set_attribute_category_map($attributeCategoryMap);

        // neu co thuoc tinh tu request
        if ($reqAttrs) {
            $params = [
                'name' => array_keys($reqAttrs),
                'category_id' => $attributeCategoryMap,
                'is_query' => 1
            ];

            $product_attr_count = 0;
            if (count($attributes = $this->attributeRepository->get($params))) {
                $attributeById = [];
                // tao danh sach thuoc tinh mac dinh theo danh muc
                $attributeByCategoryId = [];

                // danh sach gia tri thuoc tinh
                $attributeValues = [];

                // duyệt mảng map để điền thông tin mặc định theo thu tu
                foreach ($attributeCategoryMap as $id) {
                    $attributeByCategoryId[$id] = [];
                }
                // duyệt mảng thuộc tính
                foreach ($attributes as $attr) {
                    $attributeById[$attr->id] = $attr;
                    $attributeByCategoryId[$attr->category_id][] = $attr->id;
                }

                // duyệt mảng thuộc tính theo category id để lấy ra giá trị và od của thuộc tính
                // và điền vào mảng $attributeValues với key là id và value là giá trị từ request
                foreach ($attributeByCategoryId as $category_id => $attribute_ids) {
                    if (count($attribute_ids)) {
                        foreach ($attribute_ids as $attribute_id) {
                            $attr = $attributeById[$attribute_id];
                            if (isset($reqAttrs[$attr->name])) {
                                $attributeValues[$attribute_id] = [
                                    'type' => $attr->value_type,
                                    'value' => $reqAttrs[$attr->name]
                                ];
                            }
                        }
                    }
                }


                // nếu chắc chắn có thuộc tính giống như người dùng gừi từ trình duyệt thì mới thực hiện bước truy vấn này
                if ($attributeValues) {
                    $this->join('product_attributes', 'product_attributes.product_id', 'products.id')
                        ->join('attribute_values', 'attribute_values.id', '=', 'product_attributes.attribute_value_id');
                    $this->where(function ($query) use ($attributeValues) {
                        $i = 0;
                        foreach ($attributeValues as $attribute_id => $value) {
                            // $f = $i?'orWhere':'where';
                            if (!$i){
                                $query->where(function ($query) use ($attribute_id, $value) {
                                    $query->where('attribute_values.attribute_id', $attribute_id);
                                    if (is_array($value['value'])) {
                                        $query->whereIn('attribute_values.' . $value['type'] . '_value', $value['value']);
                                    } else {
                                        $query->where('attribute_values.' . $value['type'] . '_value', $value['value']);
                                    }
                                });
                            }
                            else{
                                $query->orWhere(function ($query) use ($attribute_id, $value) {
                                    $query->where('attribute_values.attribute_id', $attribute_id);
                                    if (is_array($value['value'])) {
                                        $query->whereIn('attribute_values.' . $value['type'] . '_value', $value['value']);
                                    } else {
                                        $query->where('attribute_values.' . $value['type'] . '_value', $value['value']);
                                    }
                                });
                            }

                            $i++;
                        }
                    });

                    $this->havingRaw('count(DISTINCT product_attributes.attribute_value_id) = ' . count($reqAttrs));

                    $this->groupBy('products.id');

                    // addslashes
                }
            }
        }


        $args = $this->parsePaginateParam($request, $args);

        // lấy kết qua

        if (!$this->hasSortby && !isset($args['@orderBy']) && !isset($args['@order_by']) && $this->defaultSortBy && !$a) {
            $args['@order_by'] = $this->defaultSortBy;
        }
        $this->with(['category', 'metadatas', 'attrs', 'reviews']);

        $results = $this->get($args);
        // nếu tham số có yêu cau paginate
        if ($this->hasPaginateParam) {
            if ($params = array_remove_key($request->all(), 'page')) {
                // them query string vào url
                $results->appends($params);
            }
        }
        return $this->parseCollection($results);
    }



    /**
     * lấy giá của sản phẩm theo thuộc tính
     * @param int $product_id
     * @param array $attributes
     * @return int
     */
    public function checkPrice($product_id, array $attributes = [], $quantity = 1)
    {
        if ($product = $this->findBy('id', $product_id)) {
            if(!is_numeric($quantity) || $quantity < 1) $quantity = 1;
            $price = $product->getFinalPrice();
            if ($attributes) {
                $attrs = (new ProductAttributeRepository())->getProductAttributeValues($product_id, $attributes, 1, 1);
                $change = 0;
                if (count($attrs)) {
                    foreach ($attrs as $key => $attr) {
                        if ($attr->price_type) {
                            if (!$change) {
                                $price = $attr->price;
                                $change = 1;
                            }
                        } else {
                            $price += $attr->price;
                        }
                    }
                }
            }
            $product = $this->parseDetail($product);
            $price = $price * $quantity;
            if($product->price_status < 0) $price = -1;
            return compact('product', 'price', 'quantity');
        }
        return null;
    }

    


    /**
     * tạo cây danh mục
     * @param int $category_id
     * @return string ví dụ: " 1, 4, 6,"
     */
    public function makeCategoryMap($category_id = 0)
    {
        if (!$category_id) return null;
        $rep = new CategoryRepository();
        $cate = $rep->find($category_id);
        $str = '';
        if ($cate) {
            $str = ' ' . implode(', ', $cate->getMap()) . ',';
        }

        return $str;
    }


    public function getSelectOptions(array $args = [])
    {
        $data = [' -- Chọn một sản phẩm -- '];

        $params = array_filter($args, function ($value) {
            return is_string($value) ? (strlen($value) > 0) : (is_array($value) ? (count($value) > 0) : true);
        });
        $this->join('categories', 'categories.id', '=', 'products.category_id');
        $this->select('products.name', 'products.id', 'categories.name as category_name');
        if ($list = $this->get(array_merge(['@limit' => 10, '@order_by' => 'RAND()', 'deleted' => 0], $params))) {
            foreach ($list as $item) {
                $data[$item->id] = $item->name . " (danh mục: $item->category_name)";
            }
        }
        return $data;
    }

    /**
     * get Product option
     * @param Request $request
     * @param array $args
     * @return array
     */
    public function getProductSelectOptions($request, array $args = [])
    {
        if ($request->ignore && is_array($request->ignore)) {
            $this->whereNotIn('products.id', $request->ignore);
        }
        $data = [];
        if ($request->map_id) {
            $this->like('products.category_id', " $request->map_id,");
        }
        if ($list = $this->getFilter($request, $args)) {
            foreach ($list as $item) {
                $data[$item->id] = $item->name . " (danh mục: $item->category_name)";
            }
        }
        return $data;
    }
    /**
     * get user option
     * @param Request $request
     * @param array $args
     * @return array
     */
    public function getProductTagData($request, array $args = [])
    {
        if ($request->ignore && is_array($request->ignore)) {
            $this->whereNotIn('products.id', $request->ignore);
        }
        $data = [];
        if ($request->map_id) {
            $this->like('products.category_id', " $request->map_id,");
        }
        if ($list = $this->getFilter($request, $args)) {
            foreach ($list as $item) {
                $data[] = [
                    'id' => $item->id,
                    'name' => $item->name . " (danh mục: $item->category_name)"
                ];
            }
        }
        return $data;
    }




    /**
     * ref Query
     */
    public function refQuery()
    {
        return $this->setWhereable([
            'ref'          => 'product_refs.ref',
            'ref_id'       => 'product_refs.ref_id',
            'id'           => 'products.id',
        ])
            ->join('product_refs', 'products.id', '=', 'product_refs.product_id')
            ->join('categories', 'categories.id', '=', 'products.category_id')
            ->groupBy('products.id')
            ->select('products.id', 'products.name', 'categories.name as category_name', 'products.slug');
    }


    /**
     * lấy product có ref hoặc ko
     */
    public function getRefProducts(string $ref = 'link', $ref_id = 0, array $args = [])
    {
        $args = array_merge(compact('ref', 'ref_id'), $args);
        return $this->refQuery()->get($args);
    }

    /**
     * get Order Input Data
     * @param int $product_id
     * @param array $attribute_value_id
     */
    public function getOrderInputData($product_id, array $attribute_value_id = [])
    {
        $data = [];
        if ($product = $this->find($product_id)) {
            $data['product'] = $product;
            $attrs = [];
            if (count($attr_values = $this->attributeRepository->getOrderAttributeValues($product->category_id, $product_id))) {
                foreach ($attr_values as $attr) {
                    if (!array_key_exists($attr->attribute_id, $attrs)) {
                        $attrs[$attr->attribute_id] = [
                            'data-attribute-id' => $attr->attribute_id,
                            'type' => $attr->show_type == 'dropdown' ? 'select' : $attr->show_type,
                            'template' => $attr->show_type,
                            'name' => $attr->name,
                            'label' => $attr->label,
                            'data' => []
                        ];
                    }
                    if (in_array($attr->attribute_value_id, $attribute_value_id)) {
                        $attrs[$attr->attribute_id]['value'] = $attr->attribute_value_id;
                    }
                    if (!$attrs[$attr->attribute_id]['data']) {
                        $attrs[$attr->attribute_id]['default'] = $attr->attribute_value_id;
                    }
                    $attrs[$attr->attribute_id]['data'][$attr->attribute_value_id] = $attr->text_value ?? $attr->{$attr->value_type . '_value'};
                }
            }
            $data['attr_values'] = $attrs;
        }
        return $data;
    }
}
