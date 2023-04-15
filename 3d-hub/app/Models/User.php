<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;
class User extends Authenticatable implements JWTSubject
{
    use Notifiable,ModelAction;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'username', 'password', 'phone_number', 
        'facebook_id', 'google_id', 'type', 'avatar', 'status', 'deleted', 
        'google2fa_secret'
    ];
    
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token', 'google2fa_secret',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected $role_levels = [];

    protected $_meta = [];
    protected $_roles = [];



    public function getJWTIdentifier()
    {
        return $this->getKey();
    }
    public function getJWTCustomClaims()
    {
        return [];
    }

    
    public function setGoogle2faSecretAttribute($value)
    {
         $this->attributes['google2fa_secret'] = encrypt($value);
    }
    
    public function getGoogle2faSecretAttribute($value)
    {
        return $value?decrypt($value):null;
    }
    
    ############################## Các kết nối ##############################

    public function userWebData()
    {
        return $this->hasMany('App\Models\WebData', 'id');
    }


    public function posts()
    {
        return $this->hasMany('App\Models\Post', 'author_id', 'id');
    }

    public function pages()
    {
        return $this->hasMany('App\Models\Page', 'author_id', 'id');
    }

    

    /**
     * ket noi voi bang metadata
     * @return queryBuilder 
     */
    public function metadatas()
    {
        return $this->hasMany('App\Models\Metadata','ref_id','id')->where('ref', 'user');
    }

    
    public function userRole()
    {
        return $this->hasMany('App\Models\PermissionUserRole','user_id','id');
    }
    
    
    /**
     * lấy ra danh sách role
     */
    public function roles()
    {
        return $this->userRole()
                    ->join('permission_roles', 'permission_roles.id', '=', 'permission_user_roles.role_id')
                    ->select('permission_roles.id', 'permission_roles.name', 'permission_roles.level', 'permission_roles.description')
                    ->orderBy('permission_roles.level', 'DESC');
    }

    public function roleLevels()
    {
        if($this->role_levels) return $this->role_levels;
        $data = ['admin' => [], 'mod' => [], 'access' => [], 'list' => [], 'roles' => []];
        $level = [3 => 'admin', 2 => 'mod', 1 => 'access'];
        if(count($this->roles)){
            foreach($this->roles as $role){
                $data[$level[$role->level]][] = $role->id;
                $data['list'][] = $role->id;
                $data['roles'][$role->id] = $role;
            }
        }
        $this->role_levels = $data;
        return $data;
    }

    public function inGroup($level = 'mod')
    {
        if(!in_array($lv = strtolower($level), ['admin', 'mod'])) return false;
        $data = $this->roleLevels();
        return count($data[$lv]);
    }

    public function hasRoles($roles = [])
    {
        if(!is_array($roles) || !count($roles)) return false;
        $data = $this->roleLevels();
        foreach($roles as $role_id){
            if(!in_array($role_id, $data['list'])) return false;
        }
        return true;
    }

    public function hasOnly($roles = [])
    {
        if(!is_array($roles) || !count($roles)) return false;
        $data = $this->roleLevels();
        if(count($roles) != count($data['list'])) return false;
        foreach($roles as $role_id){
            if(!in_array($role_id, $data['list'])) return false;
        }
        return true;
    }
    
    
    /**
     * get avatar url
     * @param boolean $urlencode mã hóa url
     * @return string 
     */
    public function getAvatar($urlencode=false)
    {
        if($this->avatar){
            $avatar = $this->avatar;
        }else{
            $avatar = 'default.png';
        }
        $url = url('static/users/avatar/'.$avatar);
        if($urlencode) return urlencode($url);
        return $url;
    }

    /**
     * xoa avatar
     */
    public function deleteAvatar()
    {
        if($this->avatar && file_exists($path = public_path('static/users/avatar/'.$this->avatar))){
            unlink($path);
        }
    }

    

     /**
     * ham xóa file cũ
     * @param int $id
     * 
     * @return boolean
     */
    public function deleteAttachFile()
    {
        return $this->deleteAvatar();
    }

    
    /**
     * lấy tên file đính kèm cũ
     */
    public function getAttachFilename()
    {
        return $this->avatar;
    }
    /**
     * lay du lieu form
     * @return array
     */
    public function toFormData()
    {
        $data = $this->toArray();
        if($this->avatar) $data['avatar'] = $this->getAvatar();
        
        return $data;
    }

    

    public function __get_table()
    {
        return 'users';
    }

    


    public function canDelete()
    {
        // if($this->is('admin')) return false;
        if($id = get_owner_id()){
            if($this->id == $id) return false;
        }
        return true;
    }

    
    
    /**
     * kiểm tra có thể xóa hay không
     * @return boolean
     */
    public function canMoveToTrash()
    {
        if($id = get_owner_id()){
            if($this->id == $id) return false;
        }
        return true;
    }

    public function beforeDelete()
    {
        $this->metadatas()->delete();
        // $this->userRole()->delete();
        $this->deleteAvatar();
    }


    // ham get username khong dung hang

    public function getUsername($str=null,$id=null)
    {
        if(!$str && !isset($this->id) && !$id) return null;
        elseif($id){
            if($u = self::find($id)){
                if(!$str) $str = $u->name;
            }
        }
        elseif(isset($this->id) && $this->id){
            $id = $this->id;
        }
        $aslug = str_slug($str,'');
        $slug = null;
        $i = 1;
        $c = '';
        $s = true;
        do{
            $sl = $aslug.$c;
            if($item = self::where('username',$sl)->first()){
                if($id && $item->id == $id){
                    $slug = $sl;
                    $s = false;
                }
                $c='-'.$i;
            }else{
                $slug = $sl;
                $s = false;
            }

            $i++;
        }while($s);

        return $slug;
    }
}
