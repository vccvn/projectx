<?php

namespace App\Http\Controllers\Admin\General;

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

    public function beforeSave(Request $request, Arr $data){
        // dd($data->all());
        $data->slug = str_slug($data->slug?$data->slug:$data->name);
    }

}
