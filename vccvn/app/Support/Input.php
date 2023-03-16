<?php

namespace App\Support;

use Crazy\Helpers\Arr;

class Input extends Arr{

    public function remove($name = null)
    {
        if(is_string($name)){
            unset($this->__data[$name]);
        }
    }

    public function all()
    {
        return $this->__data;
    }
}