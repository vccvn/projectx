<?php

namespace App\Http\Controllers;

use BadMethodCallException;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests,
        DispatchesJobs,
        ValidatesRequests,
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
        Traits\ResponseMethods,
        Traits\Events,
        Traits\MagicMethods;

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


    /**
     * Handle calls to missing methods on the controller.
     *
     * @param  string  $method
     * @param  array  $parameters
     * @return mixed
     *
     * @throws \BadMethodCallException
     */
    public function __call($method, $parameters)
    {

        if($this->_funcExists($method)){
            return $this->_nonStaticCall($method, $parameters);
        }
        if($this->repository && method_exists($this->repository, $method)){
            return call_user_func_array([$this->repository, $method], $parameters);
        }
        if (substr($method, 0, 2) == 'on' && strlen($event = substr($method, 2)) > 0 && ctype_upper(substr($event, 0, 1)) && count($parameters) && is_callable($parameters[0])) {

            return $this->addEvent($event, $parameters[0]);
        }


        return $this->_nonStaticCall($method, $parameters);
    }

    /**
     * Handle calls to missing methods on the controller.
     *
     * @param  string  $method
     * @param  array  $parameters
     * @return mixed
     *
     * @throws \BadMethodCallException
     */
    public static function __callStatic($method, $parameters)
    {
        return static::_staticCall($method, $parameters);
    }


}

Controller::globalStaticFunc('on', '_on');
Controller::globalFunc('on', 'addEvent');

