<?php

namespace App\Validators\Affiliates;

use App\Validators\Base\BaseValidator;

class AffiliateValidator extends BaseValidator
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
            
            'name' => 'required|string|max:191',
            'logo' => 'mimes:jpg,jpeg,png,gif,svg',
            'color' => 'mixed',
            'website' => 'mixed'

        ];
    }

    /**
     * các thông báo
     */
    public function messages()
    {
        return [
            
            'name.*' => 'Tên Web Không hợp lệ',
            'logo.mime' => 'Logo Không hợp lệ',
            'color.mixed' => 'color Không hợp lệ',
            'website.mixed' => 'website Không hợp lệ'

        ];
    }
}