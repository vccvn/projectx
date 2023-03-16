<?php

namespace App\Validators\Html;

use App\Repositories\Html\AreaRepository;
use App\Validators\Base\BaseValidator;

class EmbedValidator extends BaseValidator
{
    public function extends()
    {
        $this->addRule('check_slug', function($attr, $value){
            if(!$value) return true;
            return preg_match('/^[A-z]+[A-z0-9_]*$/si', $value);
        });
        $this->addRule('check_area', function($attr, $value){
            $rep = new AreaRepository();
            return $rep->count(['id' => $value]) == 1;
        });

    }

    /**
     * ham lay rang buoc du lieu
     */
    public function rules()
    {
    
        return [
            
            'area_id' => 'check_area',
            'label' => 'required|unique_prop:area_id',
            'slug' => 'check_slug|unique_value:area_id',
            'code' => 'mixed',
            'status' => 'binary',

        ];
    }

    /**
     * các thông báo
     */
    public function messages()
    {
        return [
            
            'area_id.*'             => 'Mã vùng Không hợp lệ',
            'label.unique_prop'     => 'Bạn không thể dùng 2 nhãn giống nhau trong cùng một nhóm',
            'label.*'               => 'Nhãn Không hợp lệ',
            'slug.unique_value'     => 'Bạn không thể dùng 2 slug giống nhau trong cùng một nhóm',
            'slug.*'                => 'Slug Không hợp lệ',
            'code.mixed'            => 'code Không hợp lệ',
            'status.mixed'          => 'status Không hợp lệ',

        ];
    }
}