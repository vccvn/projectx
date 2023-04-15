<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests,
    
    
    // module quan li lien quan toi modulw se dc ke thua tu controller nay
        Traits\ModuleMethods, 
        // tap hop cac thuoc tinh va ham lien quan den view
        Traits\ModuleData, 
        // tap hop cac thuoc tinh va ham lien quan den view
        Traits\ViewMethods, 
        // tap hop cac thuoc tinh va ham lien quan den form
        Traits\FormMethods, 
        // tap hop cac thuoc tinh va ham lien quan den xu ly su kien nhu create, update, delete, restore
        Traits\CrudMethods,
        // tap hop cac thuoc tinh va ham lien quan den xu ly su kien nhu save , handle
        Traits\BaseCrud,
        // tap hop cac thuoc tinh va ham lien quan den xu ly su file
        Traits\FileMethods,
        // tap hop cac thuoc tinh va ham lien response 
        Traits\ResponseMethods;

        
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
        $this->formInit();
        $this->activeMenu();
        $this->start();
    }

    /**
     * start 
     */
    public function start()
    {
        # code...
    }

}
