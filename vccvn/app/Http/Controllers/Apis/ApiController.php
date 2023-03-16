<?php

namespace App\Http\Controllers\Apis;

use App\Http\Controllers\Traits\ApiMethods;
use App\Http\Controllers\Traits\Events;
use App\Http\Controllers\Traits\FileMethods;
use App\Http\Controllers\Traits\ModuleMethods;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class ApiController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests,


        // module quan li lien quan toi modulw se dc ke thua tu controller nay
        ModuleMethods,
        // tap hop cac thuoc tinh va ham lien quan den xu ly su kien
        ApiMethods,
        // tap hop cac thuoc tinh va ham lien quan den xu ly su file
        FileMethods,
        Events;


    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->init();
    }

    /**
     * thuc thi mot so thiet lap
     * @return void
     */
    public function init()
    {
        $this->moduleInit();
        $this->crudInit();
        $this->fileInit();

    }

    public function response($data = null, $status = true, $message = '', $errors = [], $http = 200)
    {

        return $this->json(compact(...$this->apiSystemVars), $http);
    }

}
