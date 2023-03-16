<?php

namespace App\Validators\FOLDER;

use App\Validators\Base\BaseValidator;

class NAMEValidator extends BaseValidator
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
            $RULES
        ];
    }

    /**
     * các thông báo
     */
    public function messages()
    {
        return [
            $MESSAGES
        ];
    }
}