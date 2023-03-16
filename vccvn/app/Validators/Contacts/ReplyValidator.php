<?php

namespace App\Validators\Contacts;

use App\Validators\Base\BaseValidator;

class ReplyValidator extends BaseValidator
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
            
            'owner_id' => 'mixed',
            'contact_id' => 'mixed',
            'user_id' => 'mixed',
            'message' => 'mixed',

        ];
    }

    /**
     * các thông báo
     */
    public function messages()
    {
        return [
            
            'owner_id.mixed' => 'owner_id Không hợp lệ',
            'contact_id.mixed' => 'contact_id Không hợp lệ',
            'user_id.mixed' => 'user_id Không hợp lệ',
            'message.mixed' => 'message Không hợp lệ',

        ];
    }
}