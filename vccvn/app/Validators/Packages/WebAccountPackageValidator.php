<?php

namespace App\Validators\Packages;

use App\Validators\Base\BaseValidator;

class WebAccountPackageValidator extends BaseValidator
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
            
            'name' => 'required|unique_prop',
            'description' => 'mixed',
            'user_limited' => 'required|numeric|min:1',
            'price' => 'required|numeric|min:0',

        ];
    }

    /**
     * các thông báo
     */
    public function messages()
    {
        return [
            
            'name.mixed' => 'name Không hợp lệ',
            'description.mixed' => 'description Không hợp lệ',
            'type.mixed' => 'type Không hợp lệ',
            'user_limited.mixed' => 'user_limited Không hợp lệ',
            'price.mixed' => 'price Không hợp lệ',

        ];
    }
}