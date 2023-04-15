<?php

namespace App\Repositories\Web;

use App\Repositories\Base\BaseRepository;

use Crazy\Helpers\Any;

class SettingRepository extends BaseRepository
{

    /**
     * class chứ các phương thức để validate dử liệu
     * @var string $validatorClass 
     */
    protected $validatorClass = 'Web\SettingValidator';
    /**
     * get model
     * @return string
     */
    public function getModel()
    {
        return \App\Models\WebSetting::class;
    }
    

    public function getUniqueSubDomain(int $owner_id, $string = null)
    {
        if(!$string) $string = 'user'.$owner_id;
        $string = str_slug($string); 
        if($m = $this->findBy('subdomain', $string)){
            if($m->owner_id == $owner_id) return $string;
        }else{
            return $string;
        }
        $i = 2;
        do{
            $sd = $string.$i;
            if($m1 = $this->findBy('subdomain', $sd)){
                if($m1->owner_id == $owner_id) return $sd;
            }
            else{
                return $sd;
            }
        }while(true);
    }

    /**
     * luu setting
     * @param int $owner_id
     * @param array $data
     * @return model
     */

    public function saveOwnerSetting(int $owner_id, array $data = [])
    {
        $id = null;
        if($setting = $this->findby('owner_id', $owner_id)){
            $id = $setting->id;
            unset($data['owner_id']);
        }else{
            $data['owner_id'] = $owner_id;
        }
        return $this->save($data, $id);
    }

    /**
     * lấy ra thông tin user
     * @param string $subDomain
     * 
     * @return User|null
     */
    public function getActiveUserBySubDomain($subDomain)
    {
        return $this->join('users', 'users.id', '=', 'web_settings.owner_id')
                    ->where('users.deleted', 0)
                    ->where('web_settings.subdomain', $subDomain)
                    ->where('web_settings.domain', get_cfg_domain())
                    ->select('web_settings.*', 'users.username')
                    ->first();
    }

    
    /**
     * lấy ra thông tin user
     * @param string $subDomain
     * 
     * @return User|null
     */
    public function getActiveUserByAliasDomain($domain)
    {
        return $this->join('users', 'users.id', '=', 'web_settings.owner_id')
                    ->where('users.deleted', 0)
                    ->where('web_settings.alias_domain', $domain)
                    ->select('web_settings.*', 'users.username')
                    ->first();
    }


    /**
     * kích hoạt theme
     *
     * @param integer $theme_id
     * @return bool
     */
    public function activeTheme($theme_id = 0)
    {
        $status = false;
        if($webSetting = $this->first()){
            $this->update($webSetting->id, compact('theme_id'));
            $status = true;
        }
        return $status;
    }


}