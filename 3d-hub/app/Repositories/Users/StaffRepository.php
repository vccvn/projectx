<?php

namespace App\Repositories\Users;


class StaffRepository extends BaseUserRepository
{
    /**
     * @var boolean $isSetDefault
     */
    public $isSetDefault = false;

    /**
     * class chứ các phương thức để validate dử liệu
     * @var string $validatorClass 
     */
    protected $validatorClass = 'App\Validators\Users\StaffValidator';
    
    protected $columns = [
        'id' => 'users.id',
        'name' => 'users.name',
        'email' => 'users.email',
        'username' => 'users.username',
        'phone_number' => 'users.phone_number',
        'type' => 'users.type',
        'status' => 'users.status',
        'deleted' => 'users.deleted',
        'user_owner_id' => 'users.owner_id'

    ];

    public function removeStaffQuery()
    {
        $this->removeDefaultConditions();
        $this->isSetDefault = false;
        return $this;
    }

    public function staffQuery()
    {
        if($this->isSetDefault) return $this;
        $this->isSetDefault = true;
        return ($id = $this->getOwnerID()) ? $this->enableStaffQuery()->addDefaultCondition('owner', 'where',function($query) use($id){
            $query->where('users.id', $id)->orWhere('users.owner_id', $id);
        }) : $this;
        
    }
    
    
    /**
     * get staffs by info
     * @param string
     */
    public function findLogin($info)
    {
        return $this->where(function($query){
            $query->where('owner_id', get_owner_id())->orWhere(function($q){
                $q->where('owner_id', 0)->where('id', get_owner_id());
            });
        })
        ->where(function($query) use($info){
            $query->where('phone_number', $info)
                ->orWhere('username', $info)
                ->orWhere('email', $info);
        })->first();
    }

    // public function removeStaffQuery()
    // {
    //     $this->removeDefaultConditions();
    //     $this->isSetDefault = false;
    //     return $this;
    // }
    // public function ownerInit()
    // {
    //     if(in_array('owner_id', $this->getFields()) && self::$_owner_id){
    //         // $this->staffQuery();
    //         // $this->addDefaultValue('owner_id', self::$_owner_id)
    //         //       ->addDefaultParam('owner_id', self::$_owner_id);
                
    //     }
    //     return $this;
    // }
}