<?php

namespace App\Http\Controllers\Clients;

use App\Http\Controllers\Clients\ClientController;
use App\Repositories\Projects\CategoryRepository;
use Illuminate\Http\Request;
use Crazy\Helpers\Arr;

use App\Repositories\Projects\ProjectRepository;

class ProjectController extends ClientController
{
    protected $module = 'projects';

    protected $moduleName = 'Project';

    protected $flashMode = true;

    protected $perPage = 10;
    

    /**
     * category
     *
     * @var CategoryRepository
     */
    public $categoryRepository;


    /**
     * repository chinh
     *
     * @var ProjectRepository
     */
    public $repository;
    
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(ProjectRepository $repository, CategoryRepository $categoryRepository)
    {
        $this->repository = $repository;
        $this->categoryRepository = $categoryRepository;
        // theme dieu kien
        $this->repository->mode('mask');
        $this->categoryRepository->mode('mask')->addDefaultParam('deleted', 'deleted', 0);
        $this->init();
        
        $this->perPage = ($display = get_display_setting()) ? $display->project_per_page(10) : 10;
    }


    
    /**
     * xem chi tiết dự án
     *
     * @param Request $request
     * @return View
     */
    public function viewProjectDetail(Request $request)
    {
        // trả về cache url
        return $this->cacheUrl($request, false, function() use($request){
            // key trut cap
            $slug = $request->route('slug');
            $key = 'view-project-detail-';
            if($slug){
                $key .= 'slug-'.$slug;
                $args = ['slug' => $slug];
            }elseif($request->id){
                $key .= 'id-'.$request->id;
                $args = ['id' => $request->id];
            }else{
                return $this->view('errors.404');
            }
            
            if($project = $this->cacheTask($request, $key)->getProjectDetail($args)){
                $project->applyMeta();
                set_active_model('project', $project);
                $this->breadcrumb->addProject($project);
                $page_title = $project->title;
                $article = $project;
                $data = compact('page_title', 'project', 'article');
                return $this->view('projects.detail', $data);
            }
            return $this->view('errors.404');
        });
    }

    /**
     * lấy dữ liệu dự án và đổ về json
     *
     * @param Request $request
     * @return void
     */
    public function getProjectJsonData(Request $request)
    {
        extract($this->apiDefaultData);

        $project = $this->cacheUrl($request, false, function() use($request){
            // key truy cap
            $slug = $request->route('slug');
            $key = 'view-project-detail-';
            if($slug){
                $key .= 'slug-'.$slug;
                $args = ['slug' => $slug];
            }elseif($request->id){
                $key .= 'id-'.$request->id;
                $args = ['id' => $request->id];
            }else{
                return ['status' => false, 'errors' => ['404' => "Không tìm thấy"]];
            }
            
            if($project = $this->cacheTask($request, $key)->getProjectDetailData($args)){
                $project->applyMeta();
                $project->variants = $project->getVariantAttributes();
                $project->options = $project->getOrderAttributes();
                $project->url = $project->getViewUrl();
                return ['status' => true, 'data' => $project];
            }
            return ['status' => false, 'errors' => ['404' => "Không tìm thấy"]];
        });
        extract($project);
        return $this->json(compact($this->apiSystemVars));
    }

    /**
     * lấy danh sách hoặc tìm kiếm dự án
     *
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function viewProjects(Request $request)
    {
        // cache view theo url
        return $this->cacheUrl($request, true, function() use($request){
            // yu khoa tim kiem
            $sortby = $request->sortby??$request->orderBy;
            $categoryRoutekeys = [];
            $page_title = "Dự án";
            $levelParams = [];
            $idMode = false;
            $args = [];
            $category = null;
            $category_map = [0];
            $key = 'project-list-';
            $ck = $key;
            $categoryRoutekeys = [];
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
                $category = null;
                $key = 'project-category-';
                
                $t = count($levelParams);
                $lv = 0;
                $ck = $key;
                
                for ($i=0; $i < $t; $i++) { 
                    $params = $levelParams[$i];
                    if($category) $params['parent_id'] = $category->id;
                    // nếu có danh mục được set ở vòng lạp trước thì thêm nó vào danh mục được kích hoạt
                    // và thêm tham số id của nó làm parent_id để truy vấn danh mục hiện tại
                    // .. có thể dùng with được nhưng vẫn mất ngần ấy query thôi
                    
                    // tạo key để lấy cache nếu có
                    $k = $key . '-'. md5(json_encode($params));
                    if($cate = $this->getCategory($request, $k, $params)){
                        $category_map[] = $cate->id;
                        $category = $cate;
                        set_active_model('project_category', $category);$page_title = $category->name;

                        $ck = $k;
                        $lv++;
                    }else {
                        // nếu ko có danh mục tại vòng lặp hiện tại thì thoát khỏi vòng lặp ngay và luôn
                        break;
                    }
                }
                // dd(get_active_model('project_category'));
                // dd($category);
                // nếu level bằng tổng số danh mục
                if($lv==$t){
                    if($idMode) $category_map = array_merge([0],$category->getMap()); 
                    $args = [
                        '@category' => $category->id
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

            }
            $projects = $this->cacheTask($request, $ck)->paginate($this->perPage)->getResults($request, $args);

            if($category){
                $this->breadcrumb->addCategory($category);
            }else{
                $this->breadcrumb->add('dự án');
            }

            $keyword = $request->s;
            $data = compact('projects', 'category', 'page_title', 'keyword', 'idMode', 'sortby');
            return $this->viewModule('list', $data);
        });

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
            set_web_data('model_data.project_category.'.$category->id, $category);
        }
        return $category;
    }

    /**
     * lấy danh sách dự án
     *
     * @param Request $request
     * @param string $key
     * @param array $args
     * @return void
     */
    public function getProjects(Request $request, $key, $args = [])
    {
        return $this->cacheTask($request, $key, $this->repository)->getResults($request, $args);
    }





}
