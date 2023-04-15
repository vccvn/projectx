<?php

namespace App\Http\Controllers\Apis\Clients;

use App\Http\Controllers\Apis\ApiController;

use Illuminate\Http\Request;
use Crazy\Helpers\Arr;

use App\Repositories\Crawlers\CrawlProductRepository;
use Crazy\Files\Filemanager;

class CrawlerController extends ApiController
{
    protected $module = 'crawlers';

    protected $moduleName = 'Crawler';

    protected $flashMode = true;

    /**
     * repository chinh
     *
     * @var CrawlProductRepository
     */
    public $repository;

    /**
     * filw
     *
     * @var Filemanager
     */
    public $filemanager;
    
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(CrawlProductRepository $repository, Filemanager $filemanager)
    {
        $this->repository = $repository;
        $this->init();
        $this->filemanager = $filemanager;
    }

    public function test(Request $request)
    {
        if($request->html){
            $this->filemanager->setDir(base_path('z-dev'));
            $this->filemanager->save('data.html', $request->html, 'html');
        }
        return $this->json(["aaa"]);
    }

}
