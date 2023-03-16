<?php

namespace App\Validators\Crawlers;

use App\Validators\Base\BaseValidator;
use App\Repositories\Dynamics\DynamicRepository;
use App\Repositories\Users\StaffRepository;
use App\Repositories\Posts\CategoryRepository;
use App\Repositories\Crawlers\PostFrameRepository;


class PostTaskValidator extends BaseValidator
{
    public $dynamic = null;
    public $frame = null;
    /**
     * thêm các rule
     */
    public function extends()
    {
        // kiểm tra dynamic và gán cho $this->dynamic
        if($this->dynamic_id && $dynamic = (new DynamicRepository())->dynamic($this->dynamic_id)){
            $this->dynamic = $dynamic;
        }
        if($this->frame_id && $frame = (new PostFrameRepository())->first(['id' => $this->frame_id])){
            $frame->checkSelectors();
            $this->frame = $frame;
        }
        // kiểm tra frame có tồn tại hay ko
        $this->addRule('check_frame', function($prop, $value){
            return $this->frame?true:false;
        });
        // kiểm tra kênh
        $this->addRule('check_dynamic', function($prop, $value){
            return $this->dynamic?true:false;
        });
        // kiểm tra người đăng
        $this->addRule('check_author', function($prop, $value){
            return (new StaffRepository())->staffQuery()->first(['id' => $value])?true:false;
        });
        // kiểm tra danh mục
        $this->addRule('check_category', function($prop, $value){
            // xem kênh có dùng danh mục ko
            if($this->dynamic && $this->dynamic->use_category){
                // nếu có mới kiểm tra danh mục
                return (new CategoryRepository())->first(['id' => $value])?true:false;
            }
            return true;
        });
        // kiểm tra thời gian lấy crawl
        $this->addRule('check_time', function($prop, $value){
            if(!$value) return true;
            return (check_time_format($value) || in_array($value, ['24:00:00', '48:00:00', '72:00:00', '96:00:00', '168:00:00']));
        });
        $this->addRule('check_post_url_selector', function($prop, $value){
            if(!$value) {
                if($this->frame && $this->frame->item_url_selector) return true;
                return false;
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
            'task_url'                       => 'required|string',
            'post_url_selector'              => 'check_post_url_selector|max:191',
            'frame_id'                       => 'required|check_frame',
            'dynamic_id'                     => 'required|check_dynamic',
            'category_id'                    => 'check_category',
            'author_id'                      => 'check_author',
            'quantity'                       => 'any_number',
            'repeat_time'                    => 'check_time',
            'crawl_time'                     => 'check_time',
            'status'                         => 'mixed',
            'crawl_resources'                => 'mixed'
            
        ];
        return $rules;
        // return $this->parseRules($rules);
    }

    public function messages()
    {
        return [
            'task_url.required'              => 'Đường dẫn không được bỏ trống',
            'task_url.string'                => 'Đường dẫn không hợp lệ',
            'task_url.max'                   => 'Đường dẫn quá dài',
            'post_url_selector.check_post_url_selector' => 'Thẻ link không được bỏ trống',
            'post_url_selector.string'       => 'Thẻ link không hợp lệ',
            'post_url_selector.max'          => 'Thẻ link quá dài',
            'frame_id.required'              => 'Nguồn Crawl không được bỏ trống',
            'frame_id.check_frame'           => 'Nguồn Crawl không hợp lệ',
            'dynamic_id.required'            => 'Mục đăng bài không được bỏ trống',
            'dynamic_id.check_dynamic'       => 'Mục đăng bài không hợp lệ',
            'category_id.required'           => 'Danh mục không được bỏ trống',
            'category_id.check_category'     => 'Danh mục không hợp lệ',
            'author_id.required'             => 'Người đăng không được bỏ trống',
            'author_id.check_author'         => 'Người đăng không hợp lệ',
            'quantity.any_number'            => 'Số lượng bài viết không hợp lệ',
            'repeat_time.check_time'         => 'Thời gian tự động crawl không hợp lệ'
            
        ];
    }
}