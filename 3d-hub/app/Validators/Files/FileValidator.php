<?php

namespace App\Validators\Files;

use App\Validators\Base\BaseValidator;

class FileValidator extends BaseValidator
{
    public function extends()
    {

    }
    /**
     * ham lay rang buoc du lieu
     */
    public function rules()
    {
    
        $rules = [
            'title'                            => 'max:191',
            'description'                      => 'mixed',
            
            'file'                             => 'mimes:jpg,jpeg,png,gif',
        ];
        return $rules;
        // return $this->parseRules($rules);
    }

    public function messages()
    {
        return [
            'file.mimes'                       => 'Định đạng file không được hỗ trợ'
            
        ];
    }
}