<?php

namespace App\Validators\Account;

use App\Repositories\Web\SettingRepository;

class Upgrade extends BaseValidator
{
    public function extends()
    {
        
        
        $this->addRule('user_status', function($attr, $value){
            if(!$value) return true;
            if($status = get_user_config('status_list')){
                return isset($status[$value]);
            }
            return in_array($value, [-1, 0, 1]);
        });
        $this->addRule('account_id', function($attr, $value){
            return $this->repository->find($value)?true:false;
        });

        
        $this->addRule('check_subdomain', function($attr, $value){
            $setting = New SettingRepository();
            if(!$this->base_domain || !in_array($this->base_domain, get_system_config('domain_list'))) return false;
            if($web = $setting->first(['subdomain'=>$value, 'base_domain'=>$this->base_domain])){
                if($this->id){
                    if($this->id == $web->owner_id) return true;
                }
                return false;
            }
            return true;
        });
        $this->addRule('check_alias', function($attr, $value){
            $setting = New SettingRepository();
            // if(!$this->base_domain || !in_array($this->base_domain, get_system_config('domain_list'))) return false;
            if($web = $setting->first(['alias_domain'=>$value])){
                if($this->id){
                    if($this->id == $web->owner_id) return true;
                }
                return false;
            }
            return true;
        });
        $this->addRule('check_domain', function($attr, $value){
            if(!$this->base_domain || !in_array($this->base_domain, get_system_config('domain_list'))) return false;
            return true;
        });

        $this->addRule('check_web_type', function($attr, $value){
            if($list = get_system_config('web_type_list')){
                return isset($list[$value]);
            }
            
            return in_array(strtolower($value), ['user', 'admin', 'mod', 'content', 'owner', 'staff']);
        });
        
        
    }
    /**
     * ham lay rang buoc du lieu
     */
    public function rules()
    {
        $rules = [
            'account_id'          => 'required|account_id',
            'expired_at'          => 'mixed',
            'web_type'            => 'check_web_type',
            // 'subdomain'           => 'required|check_subdomain',
            // 'alias_domain'        => 'check_alias',
            // 'base_domain'              => 'required|check_domain',
            // 'agree'               => 'required'
            // 'status'              => 'user_status',
            
            
        ];

        return $rules; //$this->parseRules($rules);
    }

    public function messages()
    {
        return [
            'account_id.*'                        => 'Tài khoản không hợp lệ (:value)',
            'web_type.*'                          => 'Loại Web không hợp lệ',
        
        ];
    }
}