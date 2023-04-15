<?php

namespace App\Http\Controllers\Clients;

use App\Http\Controllers\Clients\ClientController;

use Illuminate\Http\Request;
use Crazy\Helpers\Arr;

use App\Repositories\Promos\ServicePromoRepository;

class ServicePromoController extends ClientController
{
    protected $module = 'servicepromos';

    protected $moduleName = 'ServicePromo';

    protected $flashMode = true;

    /**
     * repository chinh
     *
     * @var ServicePromoRepository
     */
    public $repository;
    
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(ServicePromoRepository $repository)
    {
        $this->repository = $repository;
        $this->init();
    }

    public function checkPromoCode(Request $request)
    {
        return $this->json($this->repository->check($request->promo_code, $request->package_id));
    }

}
