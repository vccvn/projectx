<?php

namespace App\Validators\Themes;

use App\Validators\Base\BaseValidator;


use App\Repositories\Users\UserRepository;


class ThemeValidator extends BaseValidator
{
    /**
     * thêm các rule
     */
    public function extends()
    {
        $this->addRule('web_types', function($prop, $value){
            if(is_null($value)) return true;
            if(!is_array($value)) return false;
            $v = array_map('strtolower', $value);
            if($list = get_system_config('web_type_list')){
                return array_check_keys($list, $v);
            }
            
            return array_any_val(['default', 'portfolio', 'blog', 'news', 'ecomerces', 'ecomerce', 'business'], $v);
        });
        $this->addRule('theme_privacy', function($prop, $value){
            if(is_null($value)) return true;
            return in_array(strtolower($value), ['protected', 'public']);
        });

        
        
    }
    /**
     * ham lay rang buoc du lieu
     */
    public function rules()
    {
    
        $rules = [
            'name'                          => 'required|string|max:191|unique_prop:version',
            'view_type'                     => 'required|in_list:multi-page,spa',
            'mobile_version'                => 'in_list:responsive,dual',
            'web_types'                     => 'required|web_types',
            'version'                       => 'required|numeric|unique_prop:name|min:0.1',
            'description'                   => 'mixed',
            'zip'                           => 'required|mimes:zip',
            'privacy'                       => 'theme_privacy',
            'image'                         => 'mimes:jpeg,jpg,png,gif',
            'image_data'                    => 'base64_file:image'
        ];

        return $this->parseRules($rules);
    }

    public function messages()
    {
        return [
            'view_type.required'              => 'Loại Thông báo không được bỏ trống',
            'view_type.in_st'                 => 'Loại Thông báo không hợp lệ',
            'zip.required'                    => 'File đính kèm không được bỏe trống',
            'zip.mime'                        => 'File đính kèm không hợp lệ',
            'image'                           => 'File ảnh không hợp lệ',
            'mobile_version'                  => 'Phiên bản cho mobile không hợp lệ',
            
            'web_types'                       => 'Loại web không hợp lệ'
        ];
    }
}