<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Manager\ManagerController;

use Illuminate\Http\Request;
use Crazy\Helpers\Arr;

use App\Repositories\Packages\WebAccountPackageRepository;

class PackageController extends ManagerController
{
    protected $module = 'packages';

    protected $moduleName = 'Package';

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

}
