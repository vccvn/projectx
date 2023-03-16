<?php

namespace App\Models;

class Profile extends Model
{
    public $table = 'profiles';
    public $fillable = ['profile_id', 'first_name', 'last_name', 'gender', 'birthday', 'email', 'phone_number', 'address', 'region_id', 'district_id', 'ward_id', 'academic_id', 'work_id', 'org_id'];
    // public $timestamps = false;
    
    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'profile_id';

    public function user()
    {
        return $this->belongsTo('App\Modals\User', 'profile_id', 'id');
    }

    public function region()
    {
        return $this->belongsTo('App\Models\Region', 'region_id', 'id');
    }
    public function district()
    {
        return $this->belongsTo('App\Models\District', 'district_id', 'id');
    }
    public function ward()
    {
        return $this->belongsTo('App\Models\Ward', 'ward_id', 'id');
    }

    /**
     * lay du lieu form
     * @return array
     */
    public function toFormData()
    {
        $data = $this->toArray();
        $data['id'] = $this->profile_id;
        if($this->birthday){
            $d = strtodate($data['birthday']);
            $data['birthday'] = $d['day'].'/'.$d['month'].'/'.$d['year'];
        }
        $data['avatar'] = get_owner()->getAvatar();
        return $data;
    }

    public function work()
    {
        return $this->belongsTo('App\Models\Work', 'work_id', 'id');
    }

    public function academic()
    {
        return $this->belongsTo('App\Models\Academic', 'academic_id', 'id');
    }
    
    public function organization()
    {
        return $this->belongsTo('App\Models\Organization', 'org_id', 'id');
    }

    
    
    
    /**
     * get avatar url
     * @param boolean $urlencode mã hóa url
     * @return string 
     */
    public function getAvatar($urlencode=false)
    {
        if($this->avatar){
            $avatar = $this->getSecretPath() .'/avatar/' . $this->avatar;

        }else{
            $avatar = 'static/images/avatar.png';
        }
        $url = url($avatar);
        if($urlencode) return urlencode($url);
        return $url;
    }

}
