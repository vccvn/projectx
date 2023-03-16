<?php

namespace App\Http\Controllers\Clients;

use App\Repositories\Posts\PostRepository;
use App\Repositories\Posts\SearchRepository;
use Illuminate\Http\Request;
use Crazy\Helpers\Arr;


class SearchController extends ClientController
{
    protected $module = 'search';

    protected $moduleName = 'Search';

    protected $flashMode = true;
    

    public $paginate = 10;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(SearchRepository $searchRepository)
    {
        $this->repository = $searchRepository;
        $this->repository->mode('mask');
        $this->init();
    }

    public function search(Request $request)
    {
        return $this->cacheUrl($request, true, function() use($request){
            $keywords = strlen($request->search)?$request->search:(
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

            $results = $this->cacheTask($request, 'search')->search($request, $keywords);
            $page_title = 'Kết quả tìm kiếm cho '.$keywords;
            $this->breadcrumb->add('Tìm kiếm', route('client.search'));
            $this->breadcrumb->add($page_title);
            $data = compact('keywords', 'results', 'page_title');
            
            return $this->viewModule('results', $data);
        });
        
    }
}
