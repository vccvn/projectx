<?php

namespace App\Http\Controllers\Manager;

use Illuminate\Http\Request;

use App\Repositories\Users\UserRepository;

use Crazy\Helpers\Arr;

class TestController extends ManagerController
{
    protected $module = 'test';

    protected $moduleName = 'Người dùng';
    
    protected $data = [];


    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(UserRepository $userRepository)
    {
        $this->repository = $userRepository;
        $this->init();
        
    }



}
