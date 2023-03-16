<?php

namespace App\Validators\Products;

use App\Repositories\Products\AttributeRepository;
use App\Repositories\Products\AttributeValueRepository;
use App\Repositories\Products\ProductRepository;
use App\Validators\Base\BaseValidator;

class VariantValidator extends BaseValidator
{
    
    public $attributeValueRepository;

    protected $attrRulees = [];
    protected $attrMessages = [];
    public $attributes = [
        
    ];
    /**
     * san pham
     *
     * @var \App\Models\Product
     */
    public function extends()
    {
        
        $this->attributeValueRepository = app(AttributeValueRepository::class);
        
        $this->addRule('check_product', function($prop, $value){
            return app(ProductRepository::class)->first(['deleted' => 0, 'id' => $value]);
        });

        $this->addRule('check_price', function($prop, $value){
            if(is_null($value)) return true;
            if(!is_numeric($value) || to_number($value) < 0) return false;
            return true;
        });
        $this->addRule('check_sale_price', function($prop, $value){
            if(is_null($value)) return true;
            if(!$this->on_sale) return true;
            if(!is_numeric($value) || to_number($value) < 0) return false;
            return true;
        });
        $this->addRule('check_value_id', function($prop, $value){
            if(!$value) return true;
            $total = is_array($value)?count($value) : 1;
            return $this->attributeValueRepository->count(['id' => $value]) == $total;
        });

        $attributes = (new AttributeRepository())->getVariantAttributeInput($this->product_id, true);
        if($attributes){
            $attrs = [
                
            ];
            $needed = 'required';
            foreach ($attributes as $attribute) {
                $id = $attribute->id;
                
                $rule = $needed;
                $name = $attribute->name;
                
                $key = 'attributes.'.$name;
                $label = $attribute->label??$name;
                if($needed == 'required'){
                    $this->attrMessages[$key.'.'.$needed] = $label .' không được vỏ trống';
                }
                if($attribute->input_type != 'default'){
                    $rule.= '|check_value_id';
                    $this->attrMessages[$key.'.check_value_id'] = $label .' không hợp lệ';
                }else{
                    if(in_array($attribute->value_type, ['int', 'decimal'])){
                        $nk = $needed == 'required'?'numeric':'option_number';
                        $rule .= '|'.$nk;
                        $this->attrMessages[$key.'.'.$nk] = $label .' phải là số';
                    }
                }
                
                $this->attrRulees[$key] = $rule;
                $attrs[$id] = $attribute;
            }
            $this->attributes = $attrs;

        }
        

    }

    /**
     * ham lay rang buoc du lieu
     */
    public function rules()
    {
    
        return array_merge([
            
            'product_id'                       => 'check_product',
            'name'                             => 'mixed',
            'description'                      => 'mixed',
            'feature_image'                    => 'mimes:jpg,jpeg,png,gif',
            'feature_image_data'               => 'base64_file:image',
            'feature_image_keep_original'      => 'mixed',
            'list_price'                       => 'required|check_price',
            'sale_price'                       => 'check_sale_price',
            'on_sale'                          => 'binary',
            
        ], $this->attrRulees);
    }

    /**
     * các thông báo
     */
    public function messages()
    {
        return array_merge([
            
            'product_id.mixed' => 'product_id Không hợp lệ',
            'name.mixed' => 'name Không hợp lệ',
            'description.mixed' => 'description Không hợp lệ',
            'feature_image.mixed' => 'feature_image Không hợp lệ',
            'list_price.mixed' => 'list_price Không hợp lệ',
            'sale_price.mixed' => 'sale_price Không hợp lệ',
            'on_sale.mixed' => 'on_sale Không hợp lệ',
            'deleted.mixed' => 'deleted Không hợp lệ',
            'created_by.mixed' => 'created_by Không hợp lệ',
            'owner_id.mixed' => 'owner_id Không hợp lệ',

        ], $this->attrMessages);
    }
}