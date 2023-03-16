<?php

namespace App\Http\Controllers\Clients;

use App\Models\Dynamic;
use App\Repositories\Dynamics\DynamicRepository;
use App\Repositories\Pages\PageRepository;
use App\Repositories\Posts\CategoryRepository;
use Illuminate\Http\Request;
use Crazy\Helpers\Arr;

use App\Repositories\Posts\PostRepository;
use App\Web\Data;
use Crazy\Files\Filemanager;

class PostController extends ClientController
{
    protected $module = 'posts';

    protected $moduleName = 'Post';

    protected $flashMode = true;

    protected $perPage = 10;
    protected $postShowListType = 'posts';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(PostRepository $PostRepository, DynamicRepository $dynamicRepository, PageRepository $pageRepository, CategoryRepository $categoryRepository)
    {
        $this->repository = $PostRepository;
        $this->dynamicRepository = $dynamicRepository;
        $this->categoryRepository = $categoryRepository;
        $this->pageRepository = $pageRepository;

        // set các tham so mac dinh
        $this->repository->mode('mask')->addDefaultParam('privacy', 'privacy', 'public');
        $this->pageRepository->mode('mask')
            ->addDefaultParam('privacy', 'privacy', 'public')
            ->notTrashed();
        $this->dynamicRepository->mode('mask')->notTrashed();
        $this->categoryRepository->mode('mask')->notTrashed();

        $this->init();


        $post_setting = post_setting();
        $this->perPage = $post_setting ? $post_setting->per_page(10) : 10;
        $this->postShowListType = $post_setting ? $post_setting->show_mode('post') : 'post';

    }

    // em phai xem qua car code nay nua moi hieu tai sao no lai co cac bien nhu posts hay pages, ..
    /**
     * xem chi tiết trang hoặc bài viết
     *
     * @param Request $request
     * @return View
     */
    public function viewPost(Request $request)
    {
        return $this->cacheUrl($request, false, function ($request) {
            // cac key de su dung cache
            $key = 'post-page-detail';
            $postKey = $key . '-post';
            $pageKey = $key . '-page';
            $slug = $request->route('dynamic', $request->route('parent'));
            $postSlug = $request->route('post', $request->route('child'));
            // nếu không có slug
            if (!$slug || !$postSlug) {
                return $this->view('errors.404');
            }


            /**
             * @var \App\Models\Dynamic
             */
            $dynamic = $this->cacheTask($request, $postKey, $this->dynamicRepository)->with('metadatas')->detail(['slug' => $slug]);
            if ($dynamic) {
                $dynamic->applyMeta();
                set_active_model('dynamic', $dynamic);
                $postKey .= '---' . $dynamic->slug . '---' . $postSlug;
                $args = [
                    'dynamic_id' => $dynamic->id,
                    'slug' => $postSlug
                ];
                $post = $this->cacheTask($request, $postKey)->getPostDetail($args);
                if ($post) {
                    $post->applyMeta();
                    $post->post_type = $dynamic->post_type;
                    set_active_model('post', $post);
                    $this->breadcrumb->addPost($post);
                    $article = $post;
                    $page_title = $post->title;
                    // dd($article);
                    $data = compact('dynamic', 'page_title', 'article');
                    return $this->view('posts.detail', $data);
                }
            }

            // lay thong tin page
            $parent = $this->cacheTask($request, $pageKey, $this->pageRepository)->getPageDetail(['slug' => $slug]);
            if ($parent) {
                set_model_data('page', $parent->id, $parent);
                set_active_model('page', $parent);
                $pageKey .= '---' . $parent->slug . '---' . $postSlug;

                $page = $this->cacheTask($request, $pageKey, $this->pageRepository)
                    ->with(['author', 'metadatas'])
                    ->detail([
                        'parent_id' => $parent->id,
                        'slug' => $postSlug
                    ]);
                    
                if ($page) {
                    $article = $page;
                    $page_title = $page->title;
                    $this->breadcrumb->addPage($page);

                    $data = compact('parent', 'page_title', 'article');
                    return $this->view('pages.detail', $data);
                }
            }

            return $this->view('errors.404');
        });
    }
    /**
     * lấy thông tin kênh hoặc trang theo slug
     *
     * @param Request $request
     * @param string $slug
     * @return View
     * @description url: /page-cha/page-con.html
     * cai url nay cung bao gom luon ten-kenh/bai-view.html
     */
    public function viewDynamicPage(Request $request)
    {
        return $this->cacheUrl($request, true, function ($request) {
            // kiểm tra kênh trước
            $slug = $request->route('dynamic', $request->route('parent'));
            $key = 'page-dynamic-' . $slug;

            // kiểm tra kênh đăng bài
            if ($dynamic = $this->cacheTask($request, $key, $this->dynamicRepository)->with('metadatas')->detail(['slug' => $slug])) {
                // phan nay cung view post list luon
                // set dynamic để khỏi phải gọi nhiều lần
                set_active_model('dynamic', $dynamic);
                $this->breadcrumb->addDynamic($dynamic);
                // tra về cache hoac view
                // function se tra ve data cho view
                $data = $this->cacheData($key, function () use ($request, $dynamic, $slug, $key) {
                    $list_type = 'post';
                    if ($this->postShowListType == 'category' && $dynamic->use_category) {
                        $list_type = 'category';
                        $posts = $this->getCategories($request, $key . '--category', [
                            'dynamic_id' => $dynamic->id,
                            'parent_id' => 0,
                            '@paginate' => $this->perPage
                        ]);
                    } else {
                        $posts = $this->getPosts($request, $key, ['dynamic_id' => $dynamic->id]);
                    }
                    // $posts = $this->getPosts($request, $key, ['dynamic_id' => $dynamic->id]);
                    $page_title = $dynamic->name;
                    return compact('dynamic', 'posts', 'page_title', 'list_type');
                });

                return $this->view('posts.list', $data);
            }
            // kiểm tra page
            elseif ($page = $this->cacheTask($request, $key, $this->pageRepository)->getPageDetail(['slug' => $slug])) {
                // nếu trang có trang con

                $page->applyMeta();
                set_active_model('page', $page);
                $this->breadcrumb->addPage($page);
                // data là mảng chứa các biến sẽ dc truyền vào view
                // dd(get_active_model('page')->content);
                $data = ['page_title' => $page->title];
                $data['article'] = $page;

                // mopt65 vài tham số tuy vấn thôi
                $perPage = ($display = get_display_setting()) ? $display->page_per_page(10) : $this->perPage;
                $results = $this->cacheTask($request, $key . '-child', $this->pageRepository)
                    ->where('posts.parent_id', $page->id)
                    ->paginate($perPage)
                    ->getResults($request);

                // du lieu duoc lay tronng cache nen se co do delay
                if (count($results)) {
                    // nếu có page con
                    $view = 'pages.list'; // view list
                    $data['parent'] = $page;
                    $data['pages'] = $results;

                } else {

                    $view = 'pages.detail';

                }
                return $this->view($view, $data);
            }
            return $this->view('errors.404');
        });
    }



    /**
     * lấy danh sách bài viết theo level category
     *
     * @param Request $request
     * @return void
     */
    public function viewCategory(Request $request)
    {
        // $categories = get_post_categories(['parent_id' => 0, '@limit' => 5]);
        return $this->cacheUrl($request, true, function ($request) {
            $key = 'dynamic-category-level';
            $view = 'posts.';
            $data = [];
            if ($dynamic = $this->getDynamic($request, 'dynamic', $key)) {
                $page_title = $dynamic->name;
                $categoryRoutekeys = [];
                $levelParams = [];
                // trường hợp 1 level (chỉ dùng slug)
                if ($slug = $request->route('slug')) $categoryRoutekeys[] = $slug;
                // trường hop74 chỉ có 2 level (parent / child)
                elseif ($child = $request->route('child')) $categoryRoutekeys = [$request->route('parent'), $child];
                // trường hợp có đến 4 level
                elseif ($fourth = $request->route('fourth')) $categoryRoutekeys = [$request->route('first'), $request->route('second'), $request->route('third'), $fourth];
                // trường hợp chỉ có 3 level
                elseif ($third = $request->route('third')) $categoryRoutekeys = [$request->route('first'), $request->route('second'), $third];
                // nếu chỉ dùng id
                elseif ($id = $request->cid ?? ($request->category_id ?? ($request->cate_id ?? $request->category ?? $request->cate))) $levelParams[] = ['id' => $id];
                // nếu có slug trong route thì foreach qua để lấy slug
                if ($categoryRoutekeys) {
                    foreach ($categoryRoutekeys as $slug) {
                        $levelParams[] = ['slug' => $slug];
                    }
                }

                if ($levelParams) {
                    $category = null;
                    $t = count($levelParams);
                    $lv = 0;
                    for ($i = 0; $i < $t; $i++) {
                        $params = $levelParams[$i];
                        $params['dynamic_id'] = $dynamic->id;
                        if ($category) {
                            $page_title = $category->name;

                            $params['parent_id'] = $category->id;
                        }
                        if($i == $t - 1){
                            if($this->postShowListType == 'category'){
                                $params['@withCount'] = ['children'];
                            }
                        }
                        $k = $key . '-' . md5(json_encode($params));
                        if ($cate = $this->getCategory($request, $k, $params)) {
                            $category = $cate;
                            set_active_model('post_category', $category);
                            $lv++;
                        } else {
                            break;
                        }
                    }

                    if ($lv == $t) {
                        $view .= 'list';

                        $list_type = 'post';
                        if ($this->postShowListType == 'category' && $category->children_count) {
                            $list_type = 'category';
                            $posts = $this->getCategories($request, $k . '--category', [
                                'dynamic_id' => $dynamic->id,
                                'parent_id' => $category->id,
                                '@paginate' => $this->perPage
                            ]);
                        } else {
                            $posts = $this->getPosts($request, $k, [
                                'dynamic_id' => $dynamic->id,
                                '@category' => $category->id
                            ]);
                        }

                        $page_title = $category->name;
                        $data = compact('dynamic', 'category', 'posts', 'page_title', 'list_type');
                        $this->breadcrumb->addCategory($category);
                    } elseif ($category) {
                        $view .= 'empty';
                        $data = compact('dynamic', 'category', 'page_title');
                        $this->breadcrumb->addCategory($category);
                    } else {
                        $view .= 'empty';
                        $data = compact('dynamic', 'page_title');
                    }
                } else {
                    $view = 'errors.404';
                }
            } else {
                $view = 'errors.404';
            }
            return $this->view($view, $data);
        });
    }



    /**
     * lấy dynamic để phuc4 vụ các task khác nhau
     *
     * @param Request $request
     * @param string $slug
     * @param string $key
     * @param \Closure $success
     * @param \Closure $error
     * @return Dynamic
     */
    protected function getDynamic(Request $request, $slugParam, $key, $success = null, $error = null)
    {
        $slug = $request->route($slugParam);
        if (!$slug) return null;
        $key .= '-' . $slug;
        // kiểm tra kinh đăng bài
        if ($dynamic = $this->cacheTask($request, $key, $this->dynamicRepository)->with('metadatas')->detail(['slug' => $slug])) {
            // set dynamic để khỏi phải gọi nhiều lần
            set_active_model('dynamic', $dynamic);
            // nếu truyền vào callbavk thi goi callback
            if (is_callable($success)) {
                return $success($dynamic, $request, $key);
            }
            // nếu không thì trả về dynamic
            return $dynamic;
        } elseif (is_callable($error)) {
            return $error($request, $key);
        }
        return null;
    }


    /**
     * lấy thông tin bai viet theo tham so co su dung cache
     *
     * @param Request $request
     * @param string $key
     * @param array $args
     * @return mixed
     */
    protected function getPosts(Request $request, $key, $args = [])
    {
        return $this->repository
            ->cache($key, $this->cacheDataTime)        // set tham so cache
            ->with(['metadatas', 'author', 'category'])  // cac doi tuong dinh kem
            ->withCount('publishComments')
            ->paginate($this->perPage)                             // phân trang
            ->getResults($request, $args);
    }

    public function getCategory(Request $request, $key, $args = [])
    {
        $category = $this->cacheTask($request, $key, $this->categoryRepository)->detail($args);
        if ($category) {
            set_web_data('model_data.post_category.' . $category->id, $category);
        }
        return $category;
    }

    public function getCategories(Request $request, $key, $args = [])
    {
        $categories = $this->cacheTask($request, $key, $this->categoryRepository)->getData($args);
        return $categories;
    }
}
