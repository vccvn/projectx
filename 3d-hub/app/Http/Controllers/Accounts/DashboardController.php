<?php

namespace App\Http\Controllers\Accounts;

use App\Http\Controllers\Accounts\AccountController;

use Illuminate\Http\Request;
use Crazy\Helpers\Arr;

use App\Repositories\Users\UserRepository;

class DashboardController extends AccountController
{
    protected $module = 'dashboard';

    protected $moduleName = 'Dashboard';

    protected $flashMode = true;

    /**
     * repository chinh
     *
     * @var UserRepository
     */
    public $repository;
    
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(UserRepository $repository)
    {
        $this->repository = $repository;
        $this->init();
    }

    public function getDashboard(Request $request)
    {
        return $this->viewModule('index');
    }

}
