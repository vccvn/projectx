<?php

namespace App\Validators\Dynamics;

use App\Validators\Base\BaseValidator;

class DynamicValidator extends BaseValidator
{
    public function extends()
    {
        $this->addRule('check_slug', function($prop, $value){
            if(is_null($value)) return true;
            if($this->custom_slug){
                return $this->checkUniqueProp($prop, $value);
            }
            return true;
        });

        $this->addRule('post_type', function($prop, $value){
            if(is_null($value)) return true;
            return in_array(strtolower($value), ['article', 'news', 'gallery', 'video_embed', 'custom']);
        });
        $this->addRule('default_fields', function($prop, $value){
            if(is_null($value)) return true;
            if(is_array($value)){
                foreach ($value as $field) {
                    if(!in_array($field, ["title", "slug", "keywords", "description", "content", 'content_type', "feature_image", "tags", "privacy", "meta_title", "meta_description", 'seo'])) return false;
                }
            }
            return true;
        });

        
    }
    /**
     * ham lay rang buoc du lieu
     */
    public function rules()
    {
    
        $rules = [
            'name'                             => 'required|string|max:191|unique_prop',
            'slug'                             => 'check_slug',
            'custom_slug'                      => 'mixed',
            'description'                      => 'mixed',
            'content'                          => 'mixed',
            'keywords'                         => 'mixed',
            'feature_image'                    => 'mimes:jpg,jpeg,png,gif',
            
            'feature_image_data'               => 'base64_file:image',
            'post_type'                        => 'post_type',
            'use_category'                     => 'check_boolean',
            'use_gallery'                      => 'check_boolean',
            'default_fields'                   => 'default_fields',
        ];
        if($this->advance_props){
            $rules['advance_props'] = 'array';
            $rules['advance_props.*'] = 'prop_input';
        }


        return $rules;
        // return $this->parseRules($rules);
    }

    public function messages()
    {
        return [
            'name.required'                    => 'Tên mục không được bỏ trống',
            'name.string'                      => 'Tên mục không hợp lệ',
            'name.max'                         => 'Tên mục hơi... dài!',
            'name.unique_prop'                 => 'Tên mục bị trùng lặp',
            'slug.check_slug'                  => 'Đường dẫn không hợp lệ',
            'feature_image.mimes'              => 'Định đạng file không được hỗ trợ',
            'feature_image_data.base64_file'   => 'Định đạng file không được hỗ trợ',
            'post_type.post_type'              => 'Loại nội dung không hợp lệ',
            'default_fields.default_fields'    => 'Các thông tin mặc định không hợp lệ',
            'advance_props.array'              => 'Thông tin thuộc tính không hợp lệ',
            'advance_props.*.prop_input'       => 'Thông tin thuộc tính không hợp lệ',
            
            
        ];
    }
}