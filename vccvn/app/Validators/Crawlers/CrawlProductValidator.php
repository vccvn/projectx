<?php

namespace App\Validators\Crawlers;

use App\Validators\Base\BaseValidator;
// use App\Repositories\Dynamics\DynamicRepository;
use App\Repositories\Users\StaffRepository;
use App\Repositories\Products\CategoryRepository;
use App\Repositories\Crawlers\FrameRepository;


class CrawlProductValidator extends BaseValidator
{
    /**
     * thêm các rule
     */
    public function extends()
    {
        // kiểm tra frame có tồn tại hay ko
        $this->addRule('check_frame', function($prop, $value){
            return (new FrameRepository())->first(['id' => $value])?true:false;
        });
        // kiểm tra người đăng
        $this->addRule('check_shop', function($prop, $value){
            return (new StaffRepository())->staffQuery()->first(['id' => $value])?true:false;
        });
        // kiểm tra danh mục
        $this->addRule('check_category', function($prop, $value){
            // xem kênh có dùng danh mục ko
            return (new CategoryRepository())->first(['id' => $value])?true:false;
            
        });
    }
    /**
     * ham lay rang buoc du lieu
     */
    public function rules()
    {
        $rules = [
            'url'                            => 'required|string',
            'frame_id'                       => 'required|check_frame',
            // 'dynamic_id'                     => 'required|check_dynamic',
            'category_id'                    => 'check_category',
            'shop_id'                        => 'check_shop',
            'crawl_resources'                => 'mixed'
            
        ];
        return $rules;
        // return $this->parseRules($rules);
    }

    public function messages()
    {
        return [
            'url.required'                   => 'Đường dẫn không được bỏ trống',
            'url.string'                     => 'Đường dẫn không hợp lệ',
            'url.max'                        => 'Đường dẫn quá dài',

            'frame_id.required'              => 'Nguồn Crawl không được bỏ trống',
            'frame_id.check_frame'           => 'Nguồn Crawl không hợp lệ',
            
            'dynamic_id.required'            => 'Mục đăng bài không được bỏ trống',
            'dynamic_id.check_dynamic'       => 'Mục đăng bài không hợp lệ',

            'category_id.required'           => 'Danh mục không được bỏ trống',
            'category_id.check_category'     => 'Danh mục không hợp lệ',

            'shop_id.required'               => 'Người đăng không được bỏ trống',
            'shop_id.check_shop'             => 'Người đăng không hợp lệ',
            
        ];
    }
}