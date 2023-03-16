<?php

namespace App\Http\Controllers\Apis;

use App\Http\Controllers\Apis\ApiController;

use Illuminate\Http\Request;
use Crazy\Helpers\Arr;

use App\Repositories\Clients\ClientRepository;

class testController extends ApiController
{
    protected $module = 'api.test';

    protected $moduleName = 'test';

    protected $flashMode = true;
    
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(ClientRepository $ClientRepository)
    {
        $this->repository = $ClientRepository;
        $this->init();
    }

    public function test(Request $request)
    {
        return $this->json($request->all());
    }

}
