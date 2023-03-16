<?php

namespace App\Http\Controllers\Wordpress;

use Illuminate\Http\Request;

use App\Repositories\Users\UserRepository;
use Crazy\Database\MyAdmin;
use Crazy\Helpers\Arr;
use Illuminate\Support\Facades\Config;

class DashboardController extends ManagerController
{
    protected $module = 'dashboard';
    protected $moduleBlade = 'dashboard';
    protected $moduleName = 'Dashboard';

    
    /**
     * myAdmin
     *
     * @var MyAdmin
     */
    public $myAdmin = null;


    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->repositoy = null;
        $this->activeMenu();
        
        $myConfig = Config::get('database.myadmin', []);

        $this->myAdmin = new MyAdmin($myConfig['host'], $myConfig['username'], $myConfig['password']);
        $this->myAdmin->connect();
    }

    public function getIndex(Request $request)
    {
        $user = $request->user();

        $dbExists = $this->myAdmin->dbExists($user->secret_id);

        $settings = $user->userWebSetting;
        return $this->viewModule('index', compact('user', 'dbExists', 'settings'));
    }
}
