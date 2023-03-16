<?php

namespace App\Http\Controllers\Apis\Clients;

use App\Http\Controllers\Apis\ApiController;

use Illuminate\Http\Request;
use Crazy\Helpers\Arr;

use App\Repositories\Clients\ClientRepository;

class TestController extends ApiController
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
        if($request->hasFile('image')){
            $files = $request->file('image');
            $list = [];
            foreach($files as $file){
                $list[] = [
                    'name' => $file->getClientOriginalName(),
                    'type' => $file->getClientMimeType()
                ];
            }
            return $this->json($list);
        }
        return $request;
    }

}
