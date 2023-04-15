<?php

namespace App\Validators\Crazy3D;

use App\Validators\Base\BaseValidator;

class UpdateModelSettingValidator extends BaseValidator
{
    public function extends()
    {
        // Thêm các rule ở đây
    }

    /**
     * ham lay rang buoc du lieu
     */
    public function rules()
    {
    
        return [
            'id' => 'check_exists',
            ''

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