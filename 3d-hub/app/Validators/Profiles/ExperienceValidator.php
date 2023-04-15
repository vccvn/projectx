<?php

namespace App\Validators\Profiles;

use App\Validators\Base\BaseValidator;

class ExperienceValidator extends BaseValidator
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
    
        return [];
    }

    /**
     * các thông báo
     */
    public function messages()
    {
        return [];
    }
}