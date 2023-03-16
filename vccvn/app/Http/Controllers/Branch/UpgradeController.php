<?php

namespace App\Http\Controllers\Branch;

use Illuminate\Http\Request;
use Crazy\Helpers\Arr;

use App\Repositories\Packages\WebAccountPackageRepository;

class UpgradeController extends ManagerController
{
    protected $module = 'upgrades';

    protected $moduleName = 'Nâng cấp giới hạn tài khoản';

    protected $flashMode = false;

    /**
     * repository chinh
     *
     * @var WebAccountPackageRepository
     */
    public $repository;
    
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(WebAccountPackageRepository $repository)
    {
        $this->repository = $repository;
        $this->init();
    }

    public function getInfo(Request $request)
    {
        return $this->viewModule('index');
    }

}
