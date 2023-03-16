<?php

namespace App\Validators\Crawlers;

use App\Validators\Base\BaseValidator;

class ProductFrameValidator extends BaseValidator
{
    /**
     * thêm các rule
     */
    public function extends()
    {
        
    }
    /**
     * ham lay rang buoc du lieu
     */
    public function rules()
    {
        $rules = [
            'name'                           => 'required|string|max:191|unique_prop',
            'url'                            => 'required|string|max:191|unique_prop',
            'logo'                           => 'mimes:jpg,jpeg,png,gif,svg',
            'index'                          => 'any_number',
            'product_name'                   => 'required',
            'product_name_attr'              => 'mixed',
            'description'                    => 'mixed',
            'description_attr'               => 'mixed',
            'detail'                         => 'required',
            'tag'                            => 'mixed',
            'tag_attr'                       => 'mixed',
            'image'                          => 'mixed',
            'image_attr'                     => 'mixed',
            'gallery'                        => 'mixed',
            'gallery_attr'                   => 'mixed',
            'slug'                           => 'mixed',
            'meta_title'                     => 'mixed',
            'meta_description'               => 'mixed',
            'meta_keyword'                   => 'mixed',
            'style'                          => 'mixed',
            'except'                         => 'mixed',
            'regular_price'                  => 'mixed', 
            'regular_price_attr'             => 'mixed',
            'old_price'                      => 'mixed', 
            'old_price_attr'                 => 'mixed',
            'decimal_poiter'                 => 'mixed', 
            'thousands_sep'                  => 'mixed',
            'source_type'                    => 'in_list:ssr,csr',
            'item_url_selector'              => 'mixed',
            'use_loadmore'                   => 'mixed',
            'loadmore_method'                => 'mixed',
            'loadmore_link_selector'         => 'mixed',
            'loadmore_scroll_selector'       => 'mixed',
            'loadmore_turn'                  => 'mixed'
        ];
        return $rules;
        // return $this->parseRules($rules); 
    }

    public function messages()
    {
        return [
            'name.required'                  => 'Tên website không được bỏ trống',
            'name.string'                    => 'Tên website không hợp lệ',
            'name.max'                       => 'Tên website không được dài hơn 191 ký tự',
            'name.unique_prop'               => 'Tên website không trùng lặp',
            'url.required'                   => 'Địa chỉ website không được bỏ trống',
            'url.string'                     => 'Địa chỉ website không hợp lệ',
            'url.max'                        => 'Địa chỉ website quá dài',
            'url.unique_prop'                => 'Địa chỉ website đã được sử dụng',
            'logo.mimes'                     => 'File ảnh không hợp lệ',
            'index.any_number'               => 'Chỉ mục phải là dạng số',
            'title.required'                 => 'Selector cho tiêu đề không được bỏ trống',
            'description.required'           => 'Selector cho mô tả không được bỏ trống',
            'content.required'               => 'Selector cho nội dung không được bỏ trống'
        ];
    }
}