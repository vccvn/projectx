<?php

namespace Illuminate\Database\Schema;

class Blueprint {
    public $data = [];


    function __construct()
    {
        
    }

    public function getData()
    {
        return $this->data;
    }

    public function __call($name, $params)
    {
        if(isset($params[0]) && $params[0] && !in_array($params[0], $this->data) && !in_array($name, ['increment', 'bigIncrements', 'foreign'])) 
            $this->data[] = $params[0];
        return (new static());
    }

    
    public function __toString()
    {
        
        return "[\n    '".implode("',\n    '", $this->data)."'\n]";
    }
}