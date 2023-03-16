<?php

namespace App\Http\Controllers\Manager;

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
    protected $viewFolder = 'manager';
    /**
     * @var string dường dãn thư mục chứa form
     */
    protected $formDir = 'manager/forms';

    /**
     * @var string $menuName
     */
    protected $menuName = 'manager_menu';
    
    
    protected $scope = 'manager';

}
