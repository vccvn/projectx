<?php

namespace App\Http\Controllers\CPanel;

use Illuminate\Http\Request;

use App\Repositories\Users\UserRepository;
use Crazy\Database\MyAdmin;
use Crazy\Helpers\Arr;

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
        
        $this->myAdmin = new MyAdmin(env('DB_HOST'), env('DB_ROOT_USERNAME'), env('DB_ROOT_PASSWORD'));
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
