<?php

namespace App\Repositories\Users;

class WPerRepository extends BaseUserRepository
{

    /**
     * class chứ các phương thức để validate dử liệu
     * @var string $validatorClass 
     */
    protected $validatorClass = 'App\Validators\Users\WPerValidator';
    
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
        'academic_id' => 'profiles.academic_id', 
        'work_id' => 'profiles.work_id',
        'org_id' => 'profiles.org_id',

        'theme_id' => 'web_settings.theme_id', 
        'web_type' => 'web_settings.web_type', 
        'base_domain' => 'web_settings.base_domain', 
        'subdomain' => 'web_settings.subdomain',
        'account_type' => 'web_settings.account_type', 
        'expired_at' => 'web_settings.expired_at', 
        'alias_domain' => 'web_settings.alias_domain', 
        
    ];

    public function init(){
        // $this->addDefaultParam('type', 'mju-member')->addDefaultValue('type', 'mju-member');
        $this->defaultSortBy = [
            'id' => 'DESC'
        ];
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
        })->first(['status'=>1, 'owner_id' => 0]);
    }


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

    /**
     * lấy thông tin chủ web
     * @return \App\Models\User
     */
    public function getOwner()
    {
        return ($id = $this->getOwnerID()) ? $this->clear()->fullInfo()->with(['userWebSetting', 'profile'])->getDetail(['id' => $id]) : null;
    }
    
}