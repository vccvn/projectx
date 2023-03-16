<?php

namespace App\Validators\Tests;

use App\Validators\Base\BaseValidator;

class TestValidator extends BaseValidator
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