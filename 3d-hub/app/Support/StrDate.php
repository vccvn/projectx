<?php
namespace App\Support;

Class StrDate{
    protected $date = [];
    function __construct($date = [])
    {
        $this->date = $date;
    }
    function __get($name)
    {
        return isset($this->data[$name])?$this->data[$name]:null;
    }
    public function format($format = 'Y-m-d')
    {
        if($this->year && $this->month && $this->day){
            $fm = strtolower($format);
            return str_replace(['y', 'm', 'd'], [$this->year,$this->month,$this->day], $fm);
        }
        return null;
        
    }
    function __toString()
    {
        return $this->format();
    }
}