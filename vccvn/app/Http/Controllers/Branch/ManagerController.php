<?php

namespace App\Http\Controllers\Branch;

use App\Engines\Helper;
use App\Engines\ViewManager;
use App\Http\Controllers\Controller;


use Illuminate\Http\Request;
use Crazy\Files\Filemanager;
use Crazy\Html\Menu;

class ManagerController extends Controller
{

    /**
     * @var string $viewFolder thu muc chua view
     * khong nen thay doi lam gi
     */
    protected $viewFolder = 'branch';
    /**
     * @var string dường dãn thư mục chứa form
     */
    protected $formDir = 'branch/forms';

    /**
     * @var string $menuName
     */
    protected $menuName = 'branch_menu';
    
    
    protected $scope = 'branch';

    
    public static $isShare = false;
    /**
     * device
     *
     * @var \Mobile_Detect
     */
    public $device = null;

    protected function shareDefaultData($name = null, $value = null)
    {
        if(self::$isShare) return true;
        // ViewManager::share($name, $value);
        self::$isShare = true;
        
        $settings = system_setting();
        $helper = new Helper();
        $request = request();
        view()->share(\compact('settings', 'helper', 'request'));
        
    }

    public function init()
    {
        parent::init();
        $this->shareDefaultData('__module__', static::class);
    }
}
