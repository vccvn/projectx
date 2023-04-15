<?php

namespace App\Http\Controllers\Admin\General;

use Illuminate\Http\Request;
use App\Http\Controllers\Admin\AdminController;
use Crazy\Helpers\Arr;

use App\Repositories\Subcribes\SubcribeRepository;

class SubcribeController extends AdminController
{
    protected $module = 'subcribes';

    protected $moduleName = 'Đăng ký theo dõi';

    protected $flashMode = true;
    
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(SubcribeRepository $SubcribeRepository)
    {
        $this->repository = $SubcribeRepository;
        $this->init();
    }

}
