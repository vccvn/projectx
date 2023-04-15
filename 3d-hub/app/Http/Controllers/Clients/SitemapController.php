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
        $this->dynamicRepository = $dynamicRepository->addDefaultParam('deleted', 'deleted', 0);
        $this->productRepository = $productRepository->addDefaultParam('deleted', 'deleted', 0);
        $this->categoryRepository = $categoryRepository->addDefaultParam('deleted', 'deleted', 0);
        
        $this->init();
    }

    public function sitemap(Request $request)
    {
        
        $data = [
            'posts' => $this->repository->paginate(1000)->getResults($request),
            'dynamics' => $this->dynamicRepository->paginate(1000)->getResults($request),
            'products' => $this->productRepository->paginate(1000)->getResults($request),
            'categories' => $this->categoryRepository->paginate(1000)->getResults($request),
            
        ];
        // return view('sitemap.sitemap', $data)->header('content');
        $content = View::make('sitemap.sitemap')->with($data);
        $response = response($content, '200');
        $response->header('Content-Type', 'text/xml');
        return $response;
    }

}
