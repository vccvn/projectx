<?php

namespace App\Validators\Clients;

use App\Validators\Base\BaseValidator;

class FeedbackValidator extends BaseValidator
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
            
            'client_id'                    => 'required|exists:clients,id',
            'subject'                      => 'mixed',
            'message'                      => 'required|string|max:5000',

        ];
    }

    /**
     * các thông báo
     */
    public function messages()
    {
        return [
            
            'client_id.mixed'              => 'Khách hàng Không hợp lệ',
            'message.required'             => 'Nội dung Không được bỏ trống',
            'message.string'               => 'Nội dung Không hợp lệ',
            'message.max'                  => 'Nội dung Khôngđược vượt quá 600 ký tự',

        ];
    }
}