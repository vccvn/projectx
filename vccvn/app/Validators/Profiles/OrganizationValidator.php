<?php

namespace App\Validators\Profiles;

use App\Validators\Base\BaseValidator;


class OrganizationValidator extends BaseValidator
{
    public function extends()
    {
        $this->addRule('org_type', function($prop, $value){
            if(is_null($value)) return true;
            return in_array(strtolower($value), ['business', 'education']);
        });
    }
    /**
     * ham lay rang buoc du lieu
     */
    public function rules()
    {
    
        return [
            'type'                => 'required|org_type',
            'name'                => 'required|string|max:191',
            'phone_number'        => 'phone_number',
            'address'             => 'mixed',
            'email'               => 'email_or_null',
            'website'             => 'mixed',
            'logo'                => 'mimes:jpeg,jpg,png,gif',
            'logo_data'           => 'base64_file:image'
        ];

        // return $this->parseRules($rules);
    }

    public function messages()
    {
        return [
            'type.required'                        => 'Loại tổ chức không được bỏ trống',
            'type.org_type'                        => 'Loại tổ chức không hợp lệ',

            'name.required'                        => 'Tên tổ chức không được bỏ trống',
            'name.string'                          => 'tên tổ chức không hợp lệ',
            'name.max'                             => 'tên tổ chức hơi... dài!',
            'logo.mimes'                           => 'định dạng tập tin không hợp lệ'

        ];
    }
}