<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Admin\AdminController;

use App\Repositories\Users\UserRepository;

use Crazy\Helpers\Arr;
use Crazy\Laravel\Router;
use Crazy\Http\Curl;

class DashboardController extends AdminController
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
        $this->repository = null;
        $this->activeMenu();
    }


    public function getIndex(Request $request)
    {
        // $file = $this->getFilemanager(json_path('admin/forms'));
        // $file->convertJsonToPhp('products.attributes', base_path('products.attributes.php'));
        $webType = get_web_type();
        switch ($webType) {
            case 'default':
                return $this->viewDefaultDashboard($request);
                break;
            
            default:
                # code...
                return $this->viewModule('index');
                break;
        }
        
    }

    public function viewDefaultDashboard(Request $request)
    {
        $data = [];
        return $this->viewModule('default', $data);
    }
}
