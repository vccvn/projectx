<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\AdminController;

use Illuminate\Http\Request;
use Crazy\Helpers\Arr;

use App\Repositories\Forms\FormRepository;

class FormController extends AdminController
{
    protected $module = 'forms';

    protected $moduleName = 'Form';

    protected $flashMode = true;

    /**
     * repository chinh
     *
     * @var FormRepository
     */
    public $repository;
    
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(FormRepository $repository)
    {
        $this->repository = $repository;
        $this->init();
    }

}
