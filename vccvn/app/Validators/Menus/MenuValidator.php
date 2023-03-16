<?php

namespace App\Validators\Menus;

use App\Validators\Base\BaseValidator;

class MenuValidator extends BaseValidator
{
    public function extends()
    {
        
        $this->addRule('check_slug', function($attr, $value){
            if(!$value) return true;
            return preg_match('/^[A-z]+[A-z0-9\-]*$/si', $value);
        });

        $this->addRule('check_type', function($attr, $value){
            return array_key_exists($value, get_menu_type_options());
        });

        $this->addRule('check_ref_id', function($attr, $value){
            if($this->type == 'post'){
                if(count_dynamic(['id' => $value, 'use_category' => 1])){
                    return true;
                }
                return false;
            }
            return true;
        });

        $this->addRule('check_positions', function($attr, $value){
            if(!$value) return true;
            $pos = get_menu_positions();
            return array_check_keys($pos, array_map('strtolower', (array) $value));
        });


    }

    /**
     * ham lay rang buoc du lieu
     */
    public function rules()
    {
    
        return [
            
            'name'                         => 'required|unique_prop',
            'slug'                         => 'check_slug',
            'depth'                        => 'numeric|min:1|max:8',
            'type'                         => 'check_type',
            'ref_id'                       => 'check_ref_id',
            'positions'                    => 'check_positions',

        ];
    }

    /**
     * các thông báo
     */
    public function messages()
    {
        return [
            
            'name.required'                => 'Tên menu không được bỏ trống',
            'name.unique_prop'             => 'Tên menu đã được sử dụng',
            'slug.check_slug'              => 'Slug Không hợp lệ',
            'type.check_type'              => 'Loại menu Không hợp lệ',
            'ref_id.check_ref_id'          => 'Mục tham chiếu không hợp lệ',
            'positions'                    => 'Vị trí menu không hợp lệ'

        ];
    }
}