<?php

namespace App\Validators\Products;

use App\Validators\Base\BaseValidator;
use App\Repositories\Products\AttributeRepository;

class AttributeValueValidator extends BaseValidator
{
    /**
     * @var App\Repositories\Products\AttributeRepository $attributeRepository
     */
    public $attributeRepository;

    /**
     * @var App\Models\ProductAttribute $attribute
     */
    public $attribute = null;
    public function extends()
    {
        $this->attributeRepository = new AttributeRepository();

        if($this->attribute_id){
            $this->attribute = $this->attributeRepository->findBy('id', $this->attribute_id);
        }

        $this->addRule('check_attribute', function($prop, $value){
            return $this->attribute?true:false;
        });

        $this->addRule('check_value', function($prop, $value){
            $attr = $this->attribute;
            if(!$attr) return false;
            if(strlen($value)){
                if($attr->is_unique && !$this->checkUniqueProp($attr->value_type.'_value', $value, 'attribute_id')) return false;
                if(in_array($attr->value_type, ['int', 'decimal']) && !is_numeric($value)) return false;
                if(($attr->value_type == 'int' && (int) $value != $value) || ($attr->value_type == 'decimal' && (float) $value != $value)) return false;
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
            'attribute_id'                     => 'required|check_attribute',
            'value'                            => 'required|check_value',
            'text'                             => 'mixed',
            
        ];
        
        if($this->attribute){
            $avt = $this->attribute->advance_value_type;
            if($avt == 'image'){
                $rules['image'] = 'base64_file:jpg,png,gif,svg,jpeg,ico';
            }elseif($avt == 'color'){
                $rules['color'] = 'mixed';
            }
        }

        return $rules;
        // return $this->parseRules($rules);
    }

    public function messages()
    {
        return [
            'attribute_id.required'            => 'ID thuộc tính không được bỏ trống',
            'attribute_id.check_attribute'     => 'Thuộc tính không tồn tại',
            
            'value.required'                   => 'Giá trị không được bỏ trống',
            'value.check_type'                 => 'Giá trị không hợp lệ',
            'image.base64_file'                => 'File không hợp lệ'
            
            
        ];
    }
}