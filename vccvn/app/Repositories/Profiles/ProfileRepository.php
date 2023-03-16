<?php

namespace App\Repositories\Profiles;

use App\Repositories\Base\BaseRepository;

use App\Repositories\Users\UserRepository;

use App\Repositories\Web\SettingRepository;
use App\Repositories\Web\DataRepository;

use Crazy\Helpers\Any;

use Crazy\Files\Filemanager;

class ProfileRepository extends BaseRepository
{

    /**
     * class chứ các phương thức để validate dử liệu
     * @var string $validatorClass 
     */
    protected $validatorClass = 'App\Validators\Profiles\ProfileValidator';
    /**
     * @var string $maskClass
     */
    protected $maskClass = 'Profiles\ProfileMask';
    
    /**
     * cột bắt buộc trong truy vấn
     * @var string
     */
    protected $required = 'profile_id';
    /**
     * get model
     * @return string
     */
    public function getModel()
    {
        return \App\Models\Profile::class;
    }

    /**
     * lưu thông tin profile
     * @param int $profile_id
     * @param array $data
     * @param boolean $check_user
     * 
     * @return App\Models\Profile
     * 
     */
    public function saveProfile(int $profile_id, array $data = [], $check_user = true)
    {
        if($check_user && !(new UserRepository)->find($profile_id)) return false;
        $data['profile_id'] = $profile_id;
        return $this->save($data, $profile_id);
    }



    // danh cho api

    /**
     * tao du lieu mac dinh
     * @param int $profile_id
     * @param array $data
     */
    public function createNewProfile(int $profile_id, array $data = [])
    {
        if(!($user = (new UserRepository)->find($profile_id))) return false;
        $data['profile_id'] = $profile_id;
        $this->saveProfile($profile_id, $data, false);
        
        $webData = new DataRepository();
        // web_setting
        $setting = new SettingRepository();
        $setting->save([
            'owner_id' => $profile_id,
            'subdomain' => $setting->getUniqueSubDomain($profile_id, $user->username)
        ]);
        
        $filemanager = new Filemanager(base_path('json/data/web'));
        
        if($siteinfo = $filemanager->json('siteinfo')){
            foreach ($siteinfo['data'] as $info) {
                $info['owner_id'] = $profile_id;
                $webData->save($info);
            }
        }
        
        if($contact = $filemanager->json('contact')){
            foreach ($contact['data'] as $info) {
                $info['owner_id'] = $profile_id;
                $webData->save($info);
            }
        }

        if($sitesetting = $filemanager->json('setting')){
            foreach ($sitesetting['data'] as $info) {
                $info['owner_id'] = $profile_id;
                $webData->save($info);
            }
        }

        return true;        
    }

    public function getProfileInfo($profile_id)
    {
        return $this->cache('profile-info-'.$profile_id, system_setting()->cache_data_time)
            ->join('users', 'users.id', '=', 'profiles.profile_id')
            ->leftJoin('works', 'works.id', '=', 'profiles.work_id')
            ->leftJoin('organizations', 'organizations.id', '=', 'profiles.org_id')
            ->leftJoin('academics', 'academics.id', '=', 'profiles.academic_id')
            ->leftJoin('regions', 'regions.id', '=', 'profiles.region_id')
            ->leftJoin('districts', 'districts.id', '=', 'profiles.district_id')
            ->leftJoin('wards', 'wards.id', '=', 'profiles.ward_id')
            ->select(
                'profiles.*', 'users.name', 'profiles.last_name', 'users.username',
                'regions.name as region', 'districts.name as district', 'wards.name as ward', 
                'academics.title as academic_title', 'works.title as work_title', 
                'organizations.name as org_name',
                'users.avatar'
            )
            ->mode('mask')
            ->detail(['profile_id' => $profile_id]);
    }

}