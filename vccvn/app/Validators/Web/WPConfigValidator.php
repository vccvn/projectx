<?php

namespace App\Validators\Web;

use App\Validators\Base\BaseValidator;

class WPConfigValidator extends BaseValidator
{
    public function extends()
    {
        $this->addRule('check_host', function ($attr, $value)
        {
            return preg_match('/(^[A-z0-9\-]+\.[A-z0-9\-\.]+$|^localhost$|^[0-9]+\.[0-9]+\.[0-9]+\.[0-9]+$)/', $value);
        });
    }

    /**
     * ham lay rang buoc du lieu
     */
    public function rules()
    {
    
        return [
            'debug' => 'check_boolean',
            // 'use_my_db' => 'check_boolean',
            'db_host' => 'required|check_host',
            'db_name' => 'required|string',
            'db_user' => 'required|string',
            'db_password' => 'mixed',
            'db_charset' => 'required',
            'db_collate' => 'mixed',
            'table_prefix' => 'mixed'

        ];
    }

    /**
     * các thông báo
     */
    public function messages()
    {
        return [
            'db_host' => 'Host không hợp lệ',
            'db_name' => 'database không hợp lệ',
            'db_user' => 'User không hợp lệ',
            'db_charset' => 'Bảng mã không hợp lệ',
            'db_collate' => 'mixed',
            

        ];
    }
}