<?php

namespace App\Http\Controllers\Manager;

use Illuminate\Http\Request;

use App\Repositories\Users\UserRepository;

use Crazy\Helpers\Arr;

class DashboardController extends ManagerController
{
    protected $module = 'dashboard';
    protected $moduleBlade = 'dashboard';
    protected $moduleName = 'Dashboard';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->repositoy = null;
        $this->activeMenu();
    }

    public function getIndex(Request $reuest)
    {
        return $this->viewModule('index');
    }
}
