<?php

namespace App\Http\Controllers\Clients;

use App\Repositories\Products\CategoryRepository;
use Illuminate\Http\Request;
use Crazy\Helpers\Arr;

use App\Repositories\Products\ProductRepository;
use App\Repositories\Products\ReviewRepository;

class ProductController extends ClientController
{
    protected $module = 'products';

    protected $moduleName = 'Product';

    protected $flashMode = true;

    protected $perPage = 10;



    /**
     * category
     *
     * @var CategoryRepository
     */
    public $categoryRepository;


    /**
     * reviwws
     * @var ReviewRepository
     */
    public $reviewRepository;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(ProductRepository $ProductRepository, CategoryRepository $categoryRepository, ReviewRepository $reviewRepository)
    {
        $this->repository = $ProductRepository;
        $this->categoryRepository = $categoryRepository;
        // theme dieu kien
        $this->repository->mode('mask');
        $this->categoryRepository->mode('mask')->notTrashed();
        $this->reviewRepository = $reviewRepository->setActor('client');
        $this->init();
        $product_setting = product_setting();
        $this->perPage = ($product_setting) ? $product_setting->per_page(12) : 12;
    }

    /**
     * xem chi tiết sản phẩm
     *
     * @param Request $request
     * @return View
     */
    public function viewProductDetail(Request $request)
    {
        // trả về cache url
        return $this->cacheUrl($request, false, function() use($request){
            // key trut cap
            $slug = $request->route('slug');
            $key = 'view-product-detail-';
            if($slug){
                $key .= 'slug-'.$slug;
                $args = ['slug' => $slug];
            }elseif($request->id){
                $key .= 'id-'.$request->id;
                $args = ['id' => $request->id];
            }else{
                return $this->view('errors.404');
            }

            if($product = $this->cacheTask($request, $key)->getProductDetail($args)){
                $product->applyMeta();
                set_active_model('product', $product);
                $this->breadcrumb->addProduct($product);
                $page_title = $product->name;
                $related_products = $this->cacheTask($request,$key.'--related')
                                    ->where('id', '!=', $product->id)
                                    ->getData([
                                        'category_id' => $product->category_id,
                                        '@order_by' => 'rand()',
                                        '@limit' => 8
                                    ]);
                                    
                $data = compact('page_title', 'product', 'related_products');
                return $this->view('products.detail', $data);
            }
            return $this->view('errors.404');
        });
    }

    /**
     * lấy dữ liệu sản phẩm và đổ về json
     *
     * @param Request $request
     * @return void
     */
    public function getProductJsonData(Request $request)
    {
        extract($this->apiDefaultData);

        $product = $this->cacheUrl($request, false, function() use($request){
            // key truy cap
            $slug = $request->route('slug');
            $key = 'view-product-detail-';
            if($slug){
                $key .= 'slug-'.$slug;
                $args = ['slug' => $slug];
            }elseif($request->id){
                $key .= 'id-'.$request->id;
                $args = ['id' => $request->id];
            }else{
                return ['status' => false, 'errors' => ['404' => "Không tìm thấy"]];
            }

            if($product = $this->cacheTask($request, $key)->getProductDetailData($args)){
                $product->applyMeta();
                $product->variants = $product->getVariantAttributes();
                $product->options = $product->getOrderAttributes();
                $product->url = $product->getViewUrl();
                return ['status' => true, 'data' => $product];
            }
            return ['status' => false, 'errors' => ['404' => "Không tìm thấy"]];
        });
        extract($product);
        return $this->json(compact($this->apiSystemVars));
    }

    /**
     * lấy danh sách hoặc tìm kiếm sản phẩm
     *
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function viewProducts(Request $request)
    {
        // cache view theo url
        return $this->cacheUrl($request, true, function() use($request){
            // yu khoa tim kiem
            $keyword = strlen($request->search)?$request->search:(
                strlen($request->s)?$request->s:(
                    strlen($request->keyword)?$request->keyword:(
                        strlen($request->keywords)?$request->keywords:(
                            strlen($request->tim)?$request->tim:(
                                $request->timkiem
                            )
                        )
                    )
                )
            );
            $sortby = $request->sortby??$request->orderBy;
            $page_title = "Sản phẩm";
            $categoryRoutekeys = [];
            $levelParams = [];
            $idMode = false;
            $args = [];
            $category = null;
            $category_map = [0];
            $key = 'product-list-';
            $ck = $key;
            // trường hợp 1 level (chỉ dùng slug)
            if($slug = $request->route('slug')) $categoryRoutekeys[] = $slug;
            // trường hop74 chỉ có 2 level (parent / child)
            elseif($child = $request->route('child')) $categoryRoutekeys = [$request->route('parent'), $child];
            // trường hợp có đến 4 level
            elseif($fourth = $request->route('fourth')) $categoryRoutekeys = [$request->route('first'), $request->route('second'), $request->route('third'), $fourth];
            // trường hợp chỉ có 3 level
            elseif($third = $request->route('third')) $categoryRoutekeys = [$request->route('first'), $request->route('second'), $third];
            // nếu chỉ dùng id
            elseif($id = $request->cid??($request->category_id??($request->id??($request->category??$request->cate)))) {$levelParams[] = ['id' => $id]; $idMode = true;}
            // nếu có slug trong route thì foreach qua để lấy slug
            if($categoryRoutekeys){
                foreach ($categoryRoutekeys as $slug) {
                    $levelParams[] = ['slug' => $slug];
                }
            }
            // nếu có danh mục
            if($levelParams){
                $key = 'product-category-';

                $t = count($levelParams);
                $lv = 0;
                $ck = $key;

                for ($i=0; $i < $t; $i++) {
                    $params = $levelParams[$i];
                    // nếu có danh mục được set ở vòng lạp trước thì thêm nó vào danh mục được kích hoạt
                    // và thêm tham số id của nó làm parent_id để truy vấn danh mục hiện tại
                    // .. có thể dùng with được nhưng vẫn mất ngần ấy query thôi

                    // tạo key để lấy cache nếu có
                    $k = $key . '-'. md5(json_encode($params));
                    if($cate = $this->getCategory($request, $k, $params)){
                        $category_map[] = $cate->id;
                        $category = $cate;
                        set_active_model('product_category', $category);$page_title = $category->name;

                        $params['parent_id'] = $category->id;
                        $ck = $k;
                        $lv++;
                    }else {
                        // nếu ko có danh mục tại vòng lặp hiện tại thì thoát khỏi vòng lặp ngay và luôn
                        break;
                    }
                }
                // dd(get_active_model('product_category'));
                // dd($category);
                // nếu level bằng tổng số danh mục
                if($lv==$t){
                    if($idMode) $category_map = array_merge([0],$category->getMap());
                    $args = [
                        '@category' => $category->id,
                        '@attribute_category_map' => $category_map
                    ];
                }
                // trường hợp ko có danh mục hiện tại nhưng có danh mục cha
                elseif($category){
                    // tra về view empty luôn
                    $data = compact('category', 'page_title');
                    return $this->viewModule('empty', $data);
                }
                // nếu ko có danh mục nào
                else{
                    return $this->view('errors.404');
                }

            }else{
                $args = [
                    '@attribute_category_map' => $category_map
                ];
            }
            if(!$sortby && $ps = product_setting('sorttype')){
                $args['@sorttype'] = $ps;
            }
            $products = $this->cacheTask($request, $ck)->paginate($this->perPage)->search($request, $keyword, $args);
            // return($results[0]->category);
            if($category){
                $this->breadcrumb->addCategory($category);
            }else{
                $this->breadcrumb->add('Sản phẩm');
            }
            $data = compact('products', 'category', 'page_title', 'keyword', 'idMode', 'sortby');
            return $this->viewModule('list', $data);
        });

    }



    /**
     * kiểm tra giá sản phẩm theo thuộc tính nếu có
     *
     * @param Request $request
     * @return void
     */
    public function checkPrice(Request $request)
    {
        // return $request->all();
        extract($this->apiDefaultData);
        if($productData = $this->repository->checkPrice($request->product_id, is_array($request->attrs)?$request->attrs:[], $request->quantity)){
            $status = true;
            $price = $productData['price'];
            $data = [
                'product' => $productData['product'],
                'quantity' => $productData['quantity'],
                'price' => $price,
                'price_format' => get_currency_format($price)
            ];
        }
        return $this->json(compact($this->apiSystemVars));
    }



    /**
     * lay danh muc
     *
     * @param Request $request
     * @param string $key
     * @param array $args
     * @return \App\Models\Category
     */
    public function getCategory(Request $request, $key, $args = [])
    {
        $category = $this->cacheTask($request, $key, $this->categoryRepository)->mode('mask')->detail($args);
        if($category){
            set_web_data('model_data.product_category.'.$category->id, $category);
        }
        return $category;
    }

    /**
     * lấy danh sách sản phẩm
     *
     * @param Request $request
     * @param string $key
     * @param array $args
     * @return void
     */
    public function getProducts(Request $request, $key, $args = [])
    {
        return $this->cacheTask($request, $key, $this->repository)->search($request, $args);
    }




    /**
     * gửi đánh giá giá sản phẩm
     *
     * @param Request $request
     * @return void
     */
    public function makeReview(Request $request)
    {
        $validator = $this->reviewRepository->validator($request);
        $type = 'danger';
        extract($this->createReview($request));
        if($status){
            $type = 'success';
        }elseif(!$errors){
            $type = 'warning';
        }
        $redirectData = [
            'type' => $type,
            'message' => $message,
            'link' => $this->repository->findBy('id', $request->product_id)->getViewUrl(),
            'text' => 'Quay lại trang sản phẩm'
        ];
        if($errors){
            $redirectData['title'] = $message;
            $redirectData['message'] = implode('<br>', array_values($errors));
        }
        return redirect()->route('client.alert')->with($redirectData);
    }

    /**
     * gui danh gia bang ajax
     *
     * @param Request $request
     * @return void
     */
    public function ajaxMakeReview(Request $request)
    {
        return $this->json($this->createReview($request));
    }

    protected function createReview(Request $request){
        extract($this->apiDefaultData);
        $validator = $this->reviewRepository->validator($request);
        $status = false;
        $errors = [];
        $data = null;
        if(!$validator){
            $message = 'Lỗi không xác định';
        }elseif(!$validator->success()){
            $message = 'Thiếu thông tin';
            $errors = $validator->errors();
        }elseif(!($review = $this->reviewRepository->create($validator->inputs()))){
            $message = 'Lỗi hẽ thống! Vui lòng thử lại sau giây lát';
        }else{
            $message = 'Gửi đánh giá thành công!';
            $data = $review;
            $status = true;
        }
        return compact($this->apiSystemVars);
    }

}
