<?php

namespace App\Validators\Testimonials;

use App\Validators\Base\BaseValidator;

class TestimonialValidator extends BaseValidator
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
            'email' => 'email_or_null',
            'job' => 'mixed|max:191',
            'company' => 'mixed|max:191',
            'content' => 'required',
            'avatar' => 'mixed',

        ];
    }

    /**
     * các thông báo
     */
    public function messages()
    {
        return [
            
            'name.*' => 'Tên Không hợp lệ',
            'email.*' => 'Email Không hợp lệ',
            'job.*' => 'Job Không hợp lệ',
            'company.*' => 'Company Không hợp lệ',
            'content.*' => 'Nội dung Không hợp lệ',
            'avatar.*' => 'avatar Không hợp lệ',

        ];
    }
}