<?php

namespace App\Http\Controllers\Accounts;

use App\Engines\Helper;
use App\Http\Controllers\Controller;
use App\Web\Options;
use Illuminate\Http\Request;
use Crazy\Files\Filemanager;
use Crazy\Html\Menu;

class AccountController extends Controller
{
    /**
     * @var string $routeNamePrefix
     */
    protected $routeNamePrefix = 'accounts.';

    /**
     * @var string $viewFolder thu muc chua view
     * khong nen thay doi lam gi
     */
    protected $viewFolder = 'accounts';
    /**
     * @var string dường dãn thư mục chứa form
     */
    protected $formDir = 'accounts/forms';

    /**
     * @var string $menuName
     */
    protected $menuName = 'account_menu';
    

    protected $scope = 'accounts';

    /**
     * chế độ view
     *
     * @var string $viewMode 
     */
    public $viewMode = 'module';


    public function init()
    {
        $options = new Options();
        $options->updateCache();
        set_web_data('options', $options);
        $siteinfo = siteinfo();
        $settings = system_setting();
        $helper = new Helper();
        $request = request();
        $current_url = $request->getRequestUri();
        $d = 'accounts.';
        view()->share(array_merge(
            compact('options', 'siteinfo', 'settings', 'helper', 'current_url', 'request'), 
            [
                '_component' => $d . 'components.',
                '_template' => $d . 'templates.',
                '_layout' => $d . 'layouts.',
                '_module' => $d . 'modules.',
                '_base' => $d,
                '_theme' => $d,
                '_lib' => 'client-libs.' 
            ]
        ));
        parent::init();
    }

    /**
     * view
     * @param string $bladePath
     * @param array $data
     * @return ViewEngin
     */
    public function view(string $bladePath, array $data = [])
    {
        $bp = ($this->viewMode == 'module'?'modules.':'') . $bladePath;
        $d = $this->viewFolder . '.';

        $bp = $d . $bp;

        $a = explode('.', $bp);
        $b = array_pop($a);
        $current = implode('.', $a) . '.';
        $viewdata = array_merge($data, [
            '_component' => $d . 'components.', // blade path to folder contains all of components
            '_template' => $d . 'templates.',
            '_pagination' => $d . 'pagination.',
            '_layout' => $d . 'layouts.',
            '_module' => $d . 'modules.',
            '_current' => $current,
            '_base' => $d,
            'module_slug' => $this->module,
            'module_name' => $this->moduleName,
            'route_name_prefix' => $this->routeNamePrefix
        ]);
        return view($bp, $viewdata);
    }

    /**
     * giống view nhung trỏ sẵn vào module
     * @param string $bladeName
     * @param array $data dữ liệu truyền vào
     */
    public function viewModule($subModule, array $data = [])
    {
        return $this->view($this->moduleBlade . '.' . $subModule, $data);
    }

}
