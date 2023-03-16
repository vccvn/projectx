<?php

namespace App\Http\Controllers\Wordpress;

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
    protected $viewFolder = 'wp';
    /**
     * @var string dường dãn thư mục chứa form
     */
    protected $formDir = 'wp/forms';

    /**
     * @var string $menuName
     */
    protected $menuName = 'wp_menu';


    protected $scope = 'wp';

}
