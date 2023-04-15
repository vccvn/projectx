<?php

namespace App\Validators\Web;

use App\Validators\Base\BaseValidator;

class SettingValidator extends BaseValidator
{
    public function extends()
    {
        $this->repository->reset(true)->removeDefaultConditions();
        /**
         * kiểm tra tên miền
         *
         * @return void
         */
        $this->addRule('check_domain', function($prop, $value){
            if(!in_array($value, get_system_config('domain_list'))) return false;
            return true;
        });

        $this->addRule('check_subdomain', function($attr, $value){
            if(!$this->domain) return false;
            if($web = $this->repository->first(['subdomain'=>$value, 'domain'=>$this->domain])){
                if(get_owner_id() == $web->owner_id) return true;
                return false;
            }
            return true;
        });
        $this->addRule('check_alias', function($attr, $value){
            if($value && $web = $this->repository->first(['alias_domain'=>$value])){
                if(get_owner_id() == $web->owner_id) return true;
                return false;
            }
            return true;
        });

        
        $this->addRule('check_web_type', function($attr, $value){
            if($list = get_system_config('web_type_list')){
                return isset($list[$value]);
            }
            return false;
        });
        
    }

    /**
     * ham lay rang buoc du lieu
     */
    public function rules()
    {
    
        return [
            
            'domain' => 'required|check_domain',
            'subdomain' => 'required|check_subdomain',
            'alias_domain' => (is_subdomain() ? '': 'required|').'check_alias',
            'web_type' => 'required|check_web_type'

        ];
    }

    /**
     * các thông báo
     */
    public function messages()
    {
        return [
            'web_type.required'                    => 'Bạn chưa chọn gói dịch vụ',
            'web_type.check_web_type'              => 'Gói dịch vụ không hợp lệ',
            'subdomain.required'                   => 'Bạn chưa nhập tên miền',
            'subdomain.check_subdomain'            => 'Tên miền này đã được sử dụng',
            'domain.required'                      => 'Bạn chưa nhập tên miền',
            'domain.check_domain'                  => 'Tên miền hỗ trợ không hợp lệ',
            'alias_domain.required'                => 'Bạn chưa nhập tên miền alias',
            'alias_domain.check_alias'             => 'Alias Domain đã được sử dụng',
        ];
    }
}