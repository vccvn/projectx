<?php

namespace App\Http\Controllers\Clients;

use Illuminate\Http\Request;
use Crazy\Helpers\Arr;

use App\Repositories\Pages\PageRepository;

class ErrorController extends ClientController
{
    protected $module = 'errors';

    protected $moduleName = 'Thông báo lỗi';

    protected $flashMode = true;
    
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(PageRepository $PageRepository)
    {
        $this->repository = $PageRepository;
        $this->init();
    }

    public function reportError(Request $request, $error = 404)
    {
        return $this->cacheViewModule($request, $error);
    }

}
