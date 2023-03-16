<?php

namespace App\Validators\Posts;

use App\Validators\Base\BaseValidator;

use App\Repositories\Tags\TagRepository;

class PostValidator extends BaseValidator
{
    public $_dynamic;
    public $propMessages = [];
    public $tags;
    public function extends()
    {
        $this->tags = new TagRepository();
        if(admin_check_dynamic()){
            $this->_dynamic = get_web_data('dynamic');
        }
        // kiểm tra slug xem có trùng lặp hay ko
        $this->addRule('check_slug', function($prop, $value){
            if(is_null($value)) return true;
            if($this->custom_slug){
                return $this->checkUniqueProp($prop, $value);
            }
            return true;
        });

        // kiểm tra slug xem có trùng lặp hay ko
        $this->addRule('check_content_type', function($prop, $value){
            if(is_null($value)) return true;
            return in_array($value, ['text', 'news', 'gallery', 'video_embed']);
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
        
        // kiểm tra thẻ xem có hợp lệ hay ko
        $this->addRule('check_video_url', function($prop, $value){
            if(($this->content_type == 'video_embed' || $this->_dynamic->post_type == 'video_embed') && !get_video_from_url($value)) return false;
            return true;
        });
        
    }
    /**
     * ham lay rang buoc du lieu
     */
    public function rules()
    {
    
        $rules = [
            'title'                            => 'required|string|max:191|unique_prop',
            'slug'                             => 'check_slug',
            'custom_slug'                      => 'mixed',
            'category_id'                      => 'required|numeric|exists:categories,id',
            'description'                      => 'mixed',
            'content'                          => 'mixed',
            'content_type'                     => 'check_content_type',
            'keywords'                         => 'mixed',
            'source'                           => 'mixed',
            'feature_image'                    => 'mimes:jpg,jpeg,png,gif',
            'feature_image_data'               => 'base64_file:image',
            'feature_image_keep_original'      => 'mixed',
            'tags'                             => 'check_tags',
            'gallery'                          => 'mixed',
            // 'gallery_data'                     => 'base64_list',
            'video_url'                        => 'check_video_url',
            'privacy'                          => 'privacy',
            'meta_title'                       => 'max:191',
            'meta_description'                 => 'max:300',
        ];

        $data = [];
        $d = $this->_dynamic;
        if($d){
            if(is_array($default = $d->default_fields)){
                if(in_array('seo', $default)){
                    $data = array_merge($data, [
                        'focus_keyword'                    => 'mixed',
                        'meta_title'                       => 'max:191',
                        'meta_description'                 => 'max:500',
                    ]);
                }
                foreach ($default as $field) {
                    if(array_key_exists($field, $rules)){
                        $data[$field] = $rules[$field];
                        if($field == 'slug'){
                            $data['custom_slug'] = $rules['custom_slug'];
                        }elseif($field == 'feature_image'){
                            $data['feature_image_keep_original'] = $rules['feature_image_keep_original'];
                        }
                    }
                }
            }
            if($d->use_category){
                $data['category_id'] = $rules['category_id'];
            }
            if($d->post_type == 'video_embed'){
                $data['video_url'] = $rules['video_url'];
            }

            if(is_array($inputs = $d->prop_inputs)){
                foreach ($inputs as $key => $input) {
                    if(array_key_exists('validate', $input) && $input['validate']){
                        $data[$input['name']] = $input['validate'];
                        $this->propMessages[$input['name'].'.*'] = ($input['label']??$input['name']) . ' không hop74 lệ';
                    }else{
                        $data[$input['name']] = 'mixed';
                    }
                }
            }

        }

        return $data;
        // return $this->parseRules($rules);
    }

    public function messages()
    {
        $d = $this->_dynamic;
        return array_merge([
            'title.required'                   => 'Tiêu đề '.$d->name.' không được bỏ trống',
            'title.string'                     => 'Tiêu đề '.$d->name.' không hợp lệ',
            'title.max'                        => 'Tiêu đề '.$d->name.' hơi... dài!',
            'title.unique_prop'                => 'Tiêu đề '.$d->name.' bị trùng lặp',
            'slug.check_slug'                  => 'Đường dẫn không hợp lệ',
            'content_type.check_content_type'  => 'Nội dung mở rộng không hợp lệ',
            'feature_image.mimes'              => 'Định đạng file không được hỗ trợ',
            'feature_image_data.base64_file'   => 'Định đạng file không được hỗ trợ',
            'category_id.required'             => 'Danh mục không được bỏ trống',
            'category_id.numeric'              => 'Danh mục không hợp lệ',
            'category_id.exists'               => 'Danh mục không tồn tại',
            'tags.check_tags'                  => 'Thẻ không hợp lệ',
            'gallery_data.base4_list'          => 'File không hợp lệ',
            'video_url_url.required'           => 'Liên kết video không được bỏ trống',
            'video_url_url.check_video'        => 'Liên kết video không hợp lệ',
            
        ], $this->propMessages);
    }
}