<?php

namespace App\Validators\Comments;

use App\Validators\Base\BaseValidator;

class CommentValidator extends BaseValidator
{
    public function extends()
    {
        $this->addRule('check_parent', function($prop, $value){
            if(!$value) return true;
            return $this->repository->checkExists($value);
        });

        $this->addRule('reflist', function($prop, $value){
            return in_array($value, ['page','post','product','project']);
        });

        
    }

    /**
     * ham lay rang buoc du lieu
     */
    public function rules()
    {
    
        return [
            
            'parent_id' => 'check_parent',
            'ref' => 'reflist',
            'ref_id' => 'refid',
            'author_name' => 'required|string|max:191',
            'author_email' => 'required|email|max:191',
            'author_phone' => 'phone_number',
            'author_website' => 'max:191',
            'message' => 'required',
            'privacy' => 'privacy',

        ];
    }

    /**
     * các thông báo
     */
    public function messages()
    {
        return [
            
            'parent_id.check_parent' => 'Mã bình luận không hợp lệ',
            'ref.reflist' => 'Ref Không hợp lệ',
            'ref_id.refid' => 'Id mục không hợp lệ',
            'author_name.*' => 'Vui lòng nhập họ tên',
            'author_email.required' => 'Email không được bỏ trống',
            'author_email.email' => 'author_email Không hợp lệ',
            'author_phone.phone_number' => 'Số điện thoại không hợp lệ',
            'author_website.max' => 'Website không hợp lệ',
            'message.required' => 'Nội dung không được bỏ trống',
            'privacy.privacy' => 'Tính riêng tư không hợp lệ',
            
        ];
    }
}