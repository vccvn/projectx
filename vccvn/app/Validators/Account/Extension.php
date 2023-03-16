<?php

namespace App\Validators\Account;

use App\Repositories\Web\SettingRepository;

class Extension extends BaseValidator
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
        
        
    }
    /**
     * ham lay rang buoc du lieu
     */
    public function rules()
    {
        $id = $this->id;
        $password = $this->password;

        $rules = [
            'expired_at'          => 'mixed',
            'status'              => 'user_status',
            
        ];

        return $rules; //$this->parseRules($rules);
    }

    public function messages()
    {
        return [
            'status.required'                      => 'Trạng thái không hợp lệ',
            'status.user_status'                   => 'Trạng thái không hợp lệ',
        
        ];
    }
}