<?php

namespace App\Repositories\Users;

class OwnerRepository extends BaseUserRepository
{

    /**
     * class chứ các phương thức để validate dử liệu
     * @var string $validatorClass 
     */
    protected $validatorClass = 'App\Validators\Users\OwnerValidator';
    
    protected $columns = [
        'id' => 'users.id',
        'name' => 'users.name',
        'email' => 'users.email',
        'username' => 'users.username',
        'phone_number' => 'users.phone_number',
        'type' => 'users.type',
        'status' => 'users.status',
        'deleted' => 'users.deleted'

    ];

    public function init(){
        
    }
    
    
    /**
     * get staffs by info
     * @param string
     */
    public function findLogin($info)
    {
        return $this->where(function($query) use($info){
            $query->where('phone_number', $info)
                ->orWhere('username', $info)
                ->orWhere('email', $info);
        })->first(['status'=>1]);
    }


    /**
     * thiết lập truy vấn để sử dụng trong trang quản trị
     * @return object instance
     */
    public function fullInfo()
    {
        $this
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
            'phone_number' => 'users.phone_number' 

        ];
        $this->setSearchable($cc)
             ->setWhereable($cc)
             ->setSortable(array_merge($this->columns, ['created_at'=> 'users.created_at', 'avatar' => 'users.avatar']));
        // dd($this);
        $this->addDefaultParam('owner_id', 'owner_id', '=', 0);
        return $this;
    }

    /**
     * lấy thông tin chủ web
     * @return \App\Models\User
     */
    public function getOwner()
    {
        return  null;
    }
    
}