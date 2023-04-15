<?php

namespace App\Validators\Account;

use App\Validators\Base\BaseValidator as Base;
use Illuminate\Support\Facades\Hash;

class BaseValidator extends Base
{
    public function extends()
    {
        $this->addRule('unique_attr', function($name, $value, $parameters){
            $data = [$name => $value];
            if(is_array($parameters) && count($parameters)){
                foreach ($parameters as $attr) {
                    if($a = trim($attr)){
                        $data[$attr] = $this->{$attr};
                    }
                }
            }
            if($result = $this->repository->first($data)){
                if(($user = $this->user()) && $user->id == $result->id){
                    return true;
                }
                return false;
            }
            return true;
        });

        $this->addRule('username', function($attr, $value){
            return preg_match('/^[A-z]+[A-z0-9_\.]*$/si', $value);
        });
        
        $this->addRule('password_match', function($attr, $value){
            if($user = $this->user()){
                $password = $user->password;
                return Hash::check($value,$password);
            }
            return false;
            
        });

        $this->addRule('phone_exists', function($name, $value){
            if(!$value) return true;
            if($user = $this->repository->first(['phone_number'=>$value])){
                if($u = $this->user()){
                    if($u->id == $user->id){
                        return true;
                    }
                }
                return false;
            }
            return true;
        });

    }

    /**
     * ham lay rang buoc du lieu
     */
    public function rules()
    {
    
        return [
            

        ];
    }

    /**
     * các thông báo
     */
    public function messages()
    {
        return [
            

        ];
    }
}