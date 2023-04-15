<?php


namespace App\Repositories\Users;

/**
 * @created doanln  2018-10-27
 */
use App\Repositories\Base\BaseRepository;


class BaseUserRepository extends BaseRepository
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
        'deleted' => 'users.deleted'


    ];
    
    
    /**
     * get model
     * @return string
     */
    public function getModel()
    {
        return \App\Models\User::class;
    }
    /**
     * @override
     * @param array $data Dữ liệu thông tin người dùng
     * @return array Mảng sau khi dược xử lý
     */
    public function beforeSave($data)
    {
        if(array_key_exists('password', $data) && $data['password']){
            $data['password'] = bcrypt($data['password']);
        }
        else{
            unset($data['password']);
        }
        return $data;
    }


    public function deleteAvatar(int $id)
    {
        if($staff = $this->find($id)){
            if($staff->deleteAvatar());
        }
    }


    /**
     * get staffs by info
     * @param string
     */
    public function findUser($info)
    {
        return $this->where(function($query) use($info){
            $query->where('id', $info)
                ->orWhere('username', $info)
                ->orWhere('email', $info);
        })->first();
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
     * @return BaseRepository
     */
    public function enableStaffQuery()
    {
        $this->fullInfo();
        $cc = [
            'id' => 'users.id',
            'name' => 'users.name',
            'email' => 'users.email',
            'username' => 'users.username',
            'phone_number' => 'users.phone_number',
        ];
        $this->setSearchable($cc)
             ->setWhereable($cc)
             ->setSortable(array_merge($this->columns, ['created_at'=> 'users.created_at', 'avatar' => 'users.avatar']));
        // dd($this);
        return $this;
    }

    /**
     * thiet lap thong tin amn an toan
     * @param array $cols
     * 
     * @return object
     */
    public function setSelectColumns(...$cols)
    {
        $columns = $this->columns;
        $c = [];
        if(count($cols)){
            foreach ($columns as $key => $value) {
                if(in_array($key, $cols) || in_array($value, $cols)){
                    $c[$key] = $value;
                }
            }
        }
        if(count($c)){
            $this->setSelectable($c);
        }
        return $this;
    }

    /**
     * get user option
     * @param Request $request
     * @param array $args
     * @return array
     */
    public function getSelectOptions(array $args = [], $defaultFirst = null)
    {
        
        $data = [];
        if($defaultFirst) $data = [$defaultFirst];
        $this->setSelectColumns('id','name','email');
        if($list = $this->staffQuery()->get(array_merge(['@limit'=>10], $args))){
            foreach ($list as $user) {
                $data[$user->id] = $user->name . " ($user->email)";
            }
        }
        return $data;
    }
    /**
     * get user option
     * @param Request $request
     * @param array $args
     * @return array
     */
    public function getUserSelectOptions($request, array $args = [])
    {
        $this->setSelectColumns('id','name','email');
        if($request->ignore && is_array($request->ignore)){
            $this->whereNotIn('users.id', $request->ignore);
        }
        $data = [];
        if($list = $this->getFilter($request,$args)){
            foreach ($list as $user) {
                $data[$user->id] = $user->name . " ($user->email)";
            }
        }
        return $data;
    }
    /**
     * get user option
     * @param Request $request
     * @param array $args
     * @return array
     */
    public function getUserTagData($request, array $args = [])
    {
        $this->setSelectColumns('id','name','email');
        if($request->ignore && is_array($request->ignore)){
            $this->whereNotIn('users.id', $request->ignore);
        }
        $data = [];
        if($list = $this->getFilter($request,$args)){
            foreach ($list as $user) {
                $data[] = [
                    'id' => $user->id,
                    'name' => $user->name,
                ];
            }
        }
        return $data;
    }

    

    /**
     * lay danh sach user cho crazy rag
     * @param array $args 
     * @param array
     */
    public static function getDynamicSelectOptions(array $args = [])
    {
        $data = ['' => 'Chọn một'];
        if($list = (new static())->staffQuery()->get(array_merge(['@limit'=>10], $args))){
            foreach ($list as $user) {
                $data[$user->id] = $user->name . " ($user->email)";
            }
        }
        return $data;
    }
    /**
     * lay danh sach user cho crazy rag
     * @param array $args 
     * @param array
     */
    public static function getStaffSelectOptions(array $args = [])
    {
        $data = [];
        if($list = (new static())->staffQuery()->get($args)){
            foreach ($list as $user) {
                $data[$user->id] = $user->name . " ($user->email)";
            }
        }
        return $data;
    }

    // public function staffQuery()
    // {
    //     if($this->isSetDefault) return $this;
    //     $this->isSetDefault = true;
    //     return ($id = $this->getOwnerID()) ? $this->enableStaffQuery()->addDefaultCondition('owner', 'where',function($query) use($id){
    //         $query->where('users.id', $id)->orWhere('users.owner_id', $id);
    //     }) : $this;
        
    // }
    public function removeStaffQuery()
    {
        $this->removeDefaultConditions();
        $this->isSetDefault = false;
        return $this;
    }
    public function ownerInit()
    {
        
        return $this;
    }

    
    /**
     * lấy thông tin chủ web
     * @return \App\Models\User
     */
    public function getOwner()
    {
        return ($id = $this->getOwnerID()) ? $this->clear()->fullInfo()->getDetail(['id' => $id]) : null;
    }

    public function getUsernameByEmail($email)
    {
        $e = explode('@', $email);
        $name = str_slug($e[0], '_');
        $i = 0;
        do {
            $na = $name . ($i == 0 ? '' : '_'.$i);
            if(!$this->findBy('username', $na)) return $na;
            $i++;
        } while (true);
    }
}