<?php

namespace App\Http\Controllers\CPanel;

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
    protected $viewFolder = 'cpanel';
    /**
     * @var string dường dãn thư mục chứa form
     */
    protected $formDir = 'cpanel/forms';

    /**
     * @var string $menuName
     */
    protected $menuName = 'cpanel_menu';


    protected $scope = 'cpanel';

}
