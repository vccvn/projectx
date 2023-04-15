<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;


use Illuminate\Http\Request;
use Crazy\Files\Filemanager;
use Crazy\Html\Menu;

class AdminController extends Controller
{
    /**
     * @var string $routeNamePrefix
     */
    protected $routeNamePrefix = 'admin.';

    /**
     * @var string $viewFolder thu muc chua view
     * khong nen thay doi lam gi
     */
    protected $viewFolder = 'admin';
    /**
     * @var string dường dãn thư mục chứa form
     */
    protected $formDir = 'admin/forms';

    /**
     * @var string $menuName
     */
    protected $menuName = 'admin_menu';
    

    protected $scope = 'admin';



}
