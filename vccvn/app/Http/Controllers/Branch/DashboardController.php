<?php

namespace App\Http\Controllers\Branch;

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

    public function getIndex(Request $request)
    {
        $user = $request->user();
        $settings = web_setting();
        return $this->viewModule('index', compact('user', 'settings'));
    }
}
