<?php

namespace App\Validators\Users;

use App\Validators\Base\BaseValidator;

class ExtensionValidator extends BaseValidator
{
    public function extends()
    {
        // Thêm các rule ở đây
        $this->addRule('check_user', function($attr, $value){
            return $this->repository->count(['status' => 1, 'id' => $value]) == 1;
        });
    }

    /**
     * ham lay rang buoc du lieu
     */
    public function rules()
    {
    
        return [
            
            'id' => 'check_user',
            'expired_at' => 'strdatetime'
        ];
    }

    /**
     * các thông báo
     */
    public function messages()
    {
        return [
            

        ];
    }
}