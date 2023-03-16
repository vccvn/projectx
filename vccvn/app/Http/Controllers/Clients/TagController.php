<?php

namespace App\Http\Controllers\Clients;

use App\Http\Controllers\Clients\ClientController;
use App\Repositories\Posts\SearchRepository;
use Illuminate\Http\Request;
use Crazy\Helpers\Arr;

use App\Repositories\Tags\TagRepository;

class TagController extends ClientController
{
    protected $module = 'search';

    protected $moduleName = 'Search';

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
    public function __construct(SearchRepository $repository)
    {
        $this->repository = $repository;
        $this->repository->mode('mask');
        $this->init();
    }

    
    public function getPosts(Request $request)
    {
        return $this->cacheUrl($request, true, function() use($request){
            $keywords = str_replace('-', ' ', $request->tag);

            $results = $this->cacheTask($request, 'search')->search($request, $keywords);
            $page_title = 'Kết quả tìm kiếm cho '.$keywords;
            $this->breadcrumb->add('Tìm kiếm', route('client.search'));
            $this->breadcrumb->add($page_title);
            $data = compact('keywords', 'results', 'page_title');
            
            return $this->viewModule('results', $data);
        });
        
    }
}
