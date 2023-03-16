<?php

namespace App\Http\Controllers\Clients;

use App\Http\Controllers\Clients\ClientController;
use App\Models\Product;
use App\Repositories\Categories\CategoryRepository;
use App\Repositories\Dynamics\DynamicRepository;
use App\Repositories\Posts\SearchRepository;
use App\Repositories\Products\ProductRepository;
use App\Repositories\Projects\ProjectRepository;



use Illuminate\Http\Request;
use Crazy\Helpers\Arr;

use App\Repositories\Sitemaps\SitemapRepository;
use Illuminate\Support\Facades\View;

class SitemapController extends ClientController
{
    protected $module = 'sitemaps';

    protected $moduleName = 'Sitemap';

    protected $flashMode = true;

    /**
     * repository chinh
     *
     * @var SearchRepository
     */
    public $repository;
    
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(
        SearchRepository $repository, 
        DynamicRepository $dynamicRepository, 
        ProductRepository $productRepository,
        CategoryRepository $categoryRepository
    )
    {
        $this->repository = $repository;
        $this->dynamicRepository = $dynamicRepository->notTrashed();
        $this->productRepository = $productRepository->notTrashed();
        $this->categoryRepository = $categoryRepository->notTrashed();
        
        $this->init();
    }

    public function sitemap(Request $request)
    {
        
        $data = [
            'posts' => $this->repository->paginate(1000)->getResults($request),
            'dynamics' => $this->dynamicRepository->paginate(1000)->getResults($request),
            // 'products' => $this->productRepository->paginate(1000)->getResults($request),
            // 'categories' => $this->categoryRepository->paginate(1000)->getResults($request),
            
        ];

        $type = get_web_type();
        $types = ['post'];
        if($type == 'ecommerce'){
            $data['products'] = $this->productRepository->paginate(1000)->getResults($request);
            $types[] = 'product';
        }
        if(in_array($type, ['personal', 'business'])){
            $types[] = 'project';
        }

        
        
        $data['categories'] = $this->categoryRepository->paginate(1000)->getResults($request, ['type' => $types]);
        // return view('sitemap.sitemap', $data)->header('content');
        $content = View::make('sitemap.sitemap')->with($data);
        $response = response($content, '200');
        $response->header('Content-Type', 'text/xml');
        return $response;
    }

}
