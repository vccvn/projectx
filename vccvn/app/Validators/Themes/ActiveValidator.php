<?php

namespace App\Validators\Themes;

use App\Validators\Base\BaseValidator;

class ActiveValidator extends BaseValidator
{
    public function extends()
    {
        $this->addRule('check_theme', function($attr, $value){
            if($this->repository->detailQuery()->findBy('id', $value)) {
                return true;
            }
            return false;
        });
    }
    public function rules()
    {
        return [
            'id' => 'check_theme'
        ];
    }

    public function messages()
    {
        return [
            'id.check_theme' => 'Theme Không hợp lệ'
        ];
    }
}