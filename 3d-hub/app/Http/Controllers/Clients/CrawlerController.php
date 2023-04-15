<?php

namespace App\Http\Controllers\Clients;

use App\Http\Controllers\Clients\ClientController;

use Illuminate\Http\Request;
use Crazy\Helpers\Arr;

use App\Repositories\Crawlers\CrawlProductRepository;
use Crazy\Apis\Api;

class CrawlerController extends ClientController
{
    protected $module = 'crawler';

    protected $moduleName = 'crawler sp';

    protected $flashMode = true;

    /**
     * repository chinh
     *
     * @var CrawlProductRepository
     */
    public $repository;

    /**
     * Api
     *
     * @var Api
     */
    protected $api;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(CrawlProductRepository $repository, Api $api)
    {
        $this->repository = $repository;
        $this->init();
        $this->api = $api;
    }

    public function test(Request $request)
    {
        if ($request->url && $res = $this->api->get($request->url)) {
            $data = $res->getBody()->getContents();
            $a = explode("define('app/pc', ['//laz-g-cdn.alicdn.com/lzdfe/pdp-platform/0.1.11/pc.js'], function(app) {", $data);
            if (count($a) > 1) {
                $b = explode('} catch(e) {', $a[1]);
                $c = explode('try{', $b[0]);
                if (count($c) > 1) {
                    $d = trim($c[1]);
                    $e = substr($d, 8, strlen($d) - 10);
                    return json_decode($e, true);
                }
            }
        }
    }
}
