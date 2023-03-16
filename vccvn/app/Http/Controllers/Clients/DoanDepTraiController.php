<?php

namespace App\Http\Controllers\Clients;

use App\Http\Controllers\Clients\ClientController;

use Illuminate\Http\Request;
use Crazy\Helpers\Arr;

use App\Repositories\DoanDepTrais\DoanDepTraiRepository;

class DoanDepTraiController extends ClientController
{
    protected $module = 'doandeptrais';

    protected $moduleName = 'DoanDepTrai';

    protected $flashMode = true;

    /**
     * repository chinh
     *
     * @var DoanDepTraiRepository
     */
    public $repository;
    
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(DoanDepTraiRepository $repository)
    {
        $this->repository = $repository;
        $this->init();
    }

}
