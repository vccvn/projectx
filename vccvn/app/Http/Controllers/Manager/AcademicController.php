<?php

namespace App\Http\Controllers\Manager;

use Illuminate\Http\Request;
use Crazy\Helpers\Arr;
use App\Repositories\Profiles\AcademicRepository;

class AcademicController extends ManagerController
{
    protected $module = 'academics';

    protected $moduleName = 'Học vấn';

    protected $flashMode = true;
    
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(AcademicRepository $academicRepository)
    {
        $this->repository = $academicRepository;
        $this->init();
    }


}
