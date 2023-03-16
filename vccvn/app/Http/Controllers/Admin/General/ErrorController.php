<?php

namespace App\Http\Controllers\Admin\General;

use Illuminate\Http\Request;
use App\Http\Controllers\Admin\AdminController;

use App\Repositories\Users\UserRepository;

use Crazy\Helpers\Arr;
use Crazy\Laravel\Router;

class ErrorController extends AdminController
{
    protected $module = 'errors';

    protected $moduleName = 'Errors';
    
    

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->repositoy = null;
    }

}
