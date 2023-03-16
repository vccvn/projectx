<?php

namespace App\Web;

use Crazy\Helpers\Arr;
use App\Engines\JsonData;

class Config
{
    protected static $instance = null;

    public static $engine = null;

    public $user = null;

    public $system = null;

    public $web = null;

    public $ecommerce = null;

    public $general = null;

    public $personal = null;


    /**
     * ham khoi tao
     * khong cần tham so
     */
    public function __construct()
    {
        if (!static::$engine) {
            static::$engine = new JsonData();
            $this->user = new Arr(static::$engine->getData('config/user'));
            $this->system = new Arr(static::$engine->getData('config/system'));
            $this->web = new Arr(static::$engine->getData('config/web'));
            $this->ecommerce = new Arr(static::$engine->getData('config/ecommerce'));
            $this->general = new Arr(static::$engine->getData('config/general'));
            $this->personal = new Arr(static::$engine->getData('config/personal'));
            $this->payments = new Arr(static::$engine->getData('config/payments'));

            
        }
    }

    public static function getConfig()
    {
        if (!self::$instance) self::$instance = new static();
        return self::$instance;
    }
}
