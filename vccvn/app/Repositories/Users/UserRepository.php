<?php

namespace App\Repositories\Users;

class UserRepository extends BaseUserRepository
{
    /**
     * @var boolean $isSetDefault
     */
    public $isSetDefault = false;

    /**
     * class chứ các phương thức để validate dử liệu
     * @var string $validatorClass 
     */
    protected $validatorClass = 'App\Validators\Users\UserValidator';
    
    protected $columns = [
        'id' => 'users.id',
        'name' => 'users.name',
        'email' => 'users.email',
        'username' => 'users.username',
        'phone_number' => 'users.phone_number',
        'type' => 'users.type',
        'status' => 'users.status',
        'deleted' => 'users.deleted',
        'user_owner_id' => 'users.owner_id',

        'first_name' => 'profiles.first_name', 
        'last_name' => 'profiles.last_name', 
        'gender' => 'profiles.gender', 
        'birthday' => 'profiles.birthday', 
        'address' => 'profiles.address',

    ];

    /**
     * thiết lập truy vấn để sử dụng trong trang quản trị
     * @return object instance
     */
    public function fullInfo()
    {
        $this->setJoinable([
            ['leftJoin', 'profiles', 'profiles.profile_id', '=', 'users.id'],
            ['leftJoin', 'web_settings', 'web_settings.owner_id', '=', 'users.id']
        ])
        ->setSelectable(array_merge($this->columns, ['created_at'=> 'users.created_at', 'avatar' => 'users.avatar']));
        // dd($this);
        return $this;
    }

    /**
     * thiết lập truy vấn để sử dụng trong trang quản trị
     * @return object instance
     */
    public function enableManagerQuery()
    {
        $this->fullInfo();
        $cc = [
            'id' => 'users.id',
            'name' => 'users.name',
            'email' => 'users.email',
            'username' => 'users.username',
            'phone_number' => 'users.phone_number',
            'first_name' => 'profiles.first_name', 

        ];
        $this->setSearchable($cc)
             ->setWhereable($cc)
             ->setSortable(array_merge($this->columns, ['created_at'=> 'users.created_at', 'avatar' => 'users.avatar']));
        // dd($this);
        $this->addDefaultParam('owner_id', 'owner_id', '=', 0);
        return $this;
    }

    public function staffQuery()
    {
        if($this->isSetDefault) return $this;
        $this->isSetDefault = true;
        $id = $this->getOwnerID();
        if($id){
            $this->enableStaffQuery()->addDefaultCondition('owner', 'where',function($query) use($id){
                $query->where('users.id', $id)->orWhere('users.owner_id', $id);
            });
        }
        
        return $this;
        
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


}