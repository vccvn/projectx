<?php

namespace App\Http\Controllers\Manager;

use Illuminate\Http\Request;


class ErrorController extends ManagerController
{
    protected $module = 'errors';

    protected $moduleName = 'Errors';
    
    

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->repositoy = null;
    }

}
