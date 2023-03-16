<?php

namespace App\Repositories\Base;

/**
 * các phương thúc với owner
 */
trait OwnerAction
{
    protected static $_owner_id = 0;
    protected $system = 'default';
    public static function addOwnerID($id = 0)
    {
        if($id){
            self::$_owner_id = $id;
        }
    }
    public function setOwnerID($id = 0)
    {
        if($id){
            self::$_owner_id = $id;
        }
    }

    public static function getSettedOwnerID()
    {
        return self::$_owner_id;
    }
    public function getOwnerID()
    {
        return self::$_owner_id;
    }


    public function ownerInit()
    {
        if(in_array('owner_id', $this->getFields())){
            $owner = self::$_owner_id;
            if($owner || $this->system == 'both'){
                $this->addDefaultValue('owner_id', $owner);
                $this->addDefaultParam('owner', 'owner_id', $owner);
            }
        }
    }

    
    protected static $master_id = 0;
    public static function setMasterId($id){
        static::$master_id = $id;
    }

}
