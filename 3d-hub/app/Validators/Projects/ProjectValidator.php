<?php

namespace App\Validators\Projects;

use App\Validators\Base\BaseValidator;
use App\Repositories\Tags\TagRepository;

class ProjectValidator extends BaseValidator
{
    public $tags;
    public function extends()
    {
        $this->tags = new TagRepository();
    
        $this->addRule('check_slug', function($prop, $value){
            if(is_null($value)) return true;
            if($this->custom_slug){
                return $this->checkUniqueProp($prop, $value);
            }
            return true;
        });


        // kiểm tra thẻ xem có hợp lệ hay ko
        $this->addRule('check_tags', function($prop, $value){
            if(!$value) return true;
            if($value && !is_array($value)) return false;
            foreach ($value as $tag_id) {
                if(!$this->tags->find($tag_id)) return false;
            }
            return true;
        });
        

        // kiểm tra page cha
        $this->addRule('check_parent', function($prop, $value){
            if(!$value) return true;
            return $this->repository->count(['id'=>$value]) ? true : false;
        });
        
    }
    /**
     * ham lay rang buoc du lieu
     */
    public function rules()
    {
    
        $rules = [
            'title'                            => 'required|string|max:191|unique_prop',
            'category_id'                      => 'required|numeric|exists:categories,id',
            'slug'                             => 'check_slug',
            'custom_slug'                      => 'mixed',
            'description'                      => 'mixed',
            'content'                          => 'mixed',
            // 'keywords'                         => 'mixed',
            'tags'                             => 'check_tags',
            'feature_image'                    => 'mimes:jpg,jpeg,png,gif',
            'feature_image_data'               => 'base64_file:image',
            'feature_image_keep_original'      => 'mixed',
            // 'privacy'                          => 'privacy',
            // 'meta_title'                       => 'max:191',
            // 'meta_description'                 => 'max:300',
            'client_id'                        => 'mixed',
            'website'                          => 'mixed',
            'link'                             => 'mixed',
            
            
        ];
        
        return $rules;
        // return $this->parseRules($rules);
    }

    public function messages()
    {
        return [
            'title.required'                   => 'Tiêu đề không được bỏ trống',
            'title.string'                     => 'Tiêu đề không hợp lệ',
            'title.max'                        => 'Tiêu đề hơi... dài!',
            'title.unique_prop'                => 'Tiêu đề bị trùng lặp',
            'slug.check_slug'                  => 'Đường dẫn không hợp lệ',
            'feature_image.mimes'              => 'Định đạng file không được hỗ trợ',
            'feature_image_data.base64_file'   => 'Định đạng file không được hỗ trợ',
            'category_id.required'             => 'Danh mục không được bỏ trống',
            'category_id.numeric'              => 'Danh mục không hợp lệ',
            'category_id.exists'               => 'Danh mục không tồn tại',
            'tags.check_tags'                  => 'Thẻ không hợp lệ',
        ];
    }
}