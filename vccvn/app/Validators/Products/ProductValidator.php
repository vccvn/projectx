<?php

namespace App\Validators\Products;

use App\Repositories\Affiliates\AffiliateRepository;
use App\Validators\Base\BaseValidator;

use App\Repositories\Products\AttributeRepository;
use App\Repositories\Products\AttributeValueRepository;
use App\Repositories\Tags\TagRepository;

class ProductValidator extends BaseValidator
{
    protected $attrRulees = [];
    protected $attrMessages = [];

    public $attributeValueRepository;
    public $tags;

    public $affiliateExists = [];

    /**
     * Affiliate
     *
     * @var AffiliateRepository
     */
    public $affiliateRepository;


    public $account_type = 'demo';

    public $attributes = [
        'use_list' => [],
        'use_value' => [],
        'attrs' => [],
        'variants' => [],
        'variant_price' => [],
        'variant_colors' => [],
        'variant_images' => []
    ];

    public function extends()
    {
        $this->attributeValueRepository = new AttributeValueRepository();
        $this->tags = new TagRepository();
        $this->affiliateRepository = new AffiliateRepository();
        $this->affiliateRepository->addDefaultParam('deleted', 0);
        // kiểm tra slug xem có trùng lặp hay ko
        $this->addRule('check_slug', function($prop, $value){
            if(is_null($value)) return true;
            if($this->custom_slug){
                return $this->checkUniqueProp($prop, $value);
            }
            return true;
        });

        // kiểm tra thẻ xem có hợp lệ hay ko
        $this->addRule('check_tags', function($prop, $value){
            if(!$value) return true;
            if($value && !is_array($value)) return false;
            foreach ($value as $tag_id) {
                if(!$this->tags->find($tag_id)) return false;
            }
            return true;
        });

        $this->addRule('check_price', function($prop, $value){
            if(is_null($value)) return true;
            if(!is_numeric($value) || to_number($value) < -1) return false;
            return true;
        });
        $this->addRule('check_sale_price', function($prop, $value){
            if(is_null($value)) return true;
            if(!$this->on_sale) return true;
            if(!is_numeric($value) || to_number($value) < -1) return false;
            return true;
        });

        $this->addRule('check_value_id', function($prop, $value){
            if(!$value) return true;
            $total = is_array($value)?count($value) : 1;
            return $this->attributeValueRepository->count(['id' => $value]) == $total;
        });

        $this->addRule('option_number', function($prop, $value){
            if($value && !is_numeric($value)) return false;
            return true;
        });


        // Thêm các rule ở đây
        $this->addRule('check_total', function($prop, $value){
            if(!strlen($value)) return true;
            if(!is_numeric($value) || $value < 0) return false;
            return true;

        });



        $attributeGroups = (new AttributeRepository())->getAttributeInput($this->category_id, true);
        $attrs = [
            'use_list' => [],
            'use_value' => [],
            'attrs' => [],
            'variants' => [],
            'variant_list' => [],
            'variant_price' => [],
            'variant_colors' => [],
            'variant_images' => []
        ];
        if($attributeGroups['attributes']){
            $attributes = $attributeGroups['attributes'];
            if(count($attributes['required']) || count($attributes['optional'])){
                foreach ($attributes as $needed => $group) {
                    foreach ($group as $attribute) {
                        $id = $attribute->id;

                        $rule = $needed;
                        $name = $attribute->name;

                        $key = 'attributes.'.$name;
                        $label = $attribute->label??$name;
                        // thêm thông báo
                        if($needed == 'required'){
                            $this->attrMessages[$key.'.'.$needed] = $label .' không được vỏ trống';
                        }
                        if($attribute->input_type != 'default'){
                            $attrs['use_list'][] = $id;
                            $rule.= '|check_value_id';
                            $this->attrMessages[$key.'.check_value_id'] = $label .' không hợp lệ';
                        }else{
                            $attrs['use_value'][] = $id;
                            if(in_array($attribute->value_type, ['int', 'decimal'])){
                                $nk = $needed == 'required'?'numeric':'option_number';
                                $rule .= '|'.$nk;
                                $this->attrMessages[$key.'.'.$nk] = $label .' phải là số';
                            }
                        }
                        $this->attrRulees[$key] = $rule;
                        $attrs['attrs'][$id] = $attribute;
                    }
                }
            }
        }
        if($attributeGroups['variants']){
            $variants = is_array($this->variants)?$this->variants:[];

            foreach ($attributeGroups['variants'] as $key => $attribute) {
                $id = $attribute->id;
                $rule = 'check_value_id';
                $name = $attribute->name;
                $key = 'variants.'.$name;
                $label = $attribute->label??$name;
                $this->attrMessages[$key.'.check_value_id'] = $label .' không hợp lệ';
                $this->attrRulees[$key] = $rule;
                $attrs['variant_list'][] = $id;
                $attrs['variants'][$id] = $attribute;
                $avt = $attribute->advance_value_type;

                if(isset($variants[$name]) && is_array($variants[$name])){
                    $ids = $variants[$name];
                    foreach($ids as $value_id){
                        $this->attrMessages['variant_price.'.$value_id.'.check_price'] = 'Giá không hợp lệ';
                        $this->attrRulees['variant_price.'.$value_id] = 'check_price';
                        $attrs['variant_price'][] = $value_id;
                        if($avt == 'image'){
                            $this->attrMessages['variant_images.'.$value_id.'.mimes'] = 'File ảnh không hợp lệ';
                            $this->attrRulees['variant_images.'.$value_id] = 'mimes:jpg,jpeg,gif,png,svg';
                            $attrs['variant_images'][] = $value_id;
                        }
                        elseif($avt == 'color'){
                            $this->attrMessages['variant_colors.'.$value_id.'.mixed'] = 'Mã màu không hợp lệ';
                            $this->attrRulees['variant_colors.'.$value_id] = 'mixed';
                            $attrs['variant_color'][] = $value_id;
                        }

                    }
                }
            }
        }

        $this->attributes = $attrs;

        $account_type = web_setting('account_type');
        $this->account_type = $account_type;
        if($account_type && $account_type != 'demo' && $this->affiliates){
            $this->addRule('check_affiliate', function($attr, $value){
                if(
                    !$value ||
                    in_array($value, $this->affiliateExists) ||
                    !$this->affiliateRepository->count(['id' => $value])
                ) return false;
                $this->affiliateExists[] = $value;
                return true;
            });
            $this->addRule('check_affiliate_url', function($attr, $value){
                return $value?true:false;
            });
            $this->addRule('check_affiliate_price', function($attr, $value){
                return is_numeric($value) && to_number($value) >= 0;
            });
        }


        // required nếu tạo mới
        $this->addRule('specification', function($name, $value){
            if(is_null($value)) return true;
            if(!is_array($value)) return false;
            if(count($value)){
                if(!isset($value['name']) || !strlen($value['name']) ) return false;
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
            'name'                             => 'required|string|max:191',
            'category_id'                      => 'required|exists:categories,id',
            'slug'                             => 'check_slug',
            'custom_slug'                      => 'mixed',
            'detail'                           => 'required',
            'description'                      => 'mixed',
            'keywords'                         => 'mixed',
            'feature_image'                    => 'mimes:jpg,jpeg,png,gif',
            'feature_image_data'               => 'base64_file:image',
            'feature_image_keep_original'      => 'mixed',
            'tags'                             => 'check_tags',
            'sku'                             => 'mixed',
            'price_status'                     => 'in_list:-1,0,1',
            'list_price'                       => 'required|check_price',
            'sale_price'                       => 'check_sale_price',
            'on_sale'                          => 'binary',
            'privacy'                          => 'privacy',
            'status'                           => 'binary',
            'type'                             => 'in_list:standard,digital',
            'download_url'                     => 'mixed',
            'meta_title'                       => 'max:191',
            'meta_description'                 => 'max:300',
            'feature_description'              => 'mixed|max:5000',
            'total'                            => 'check_total',
            'gallery'                          => 'mixed',
            'attribute_default_selected'       => 'mixed'
        ];

        $rules = array_merge($rules, $this->attrRulees);

        if($this->account_type && $this->account_type != 'demo' && $this->affiliates){
            $rules['affiliates.*.affiliate_id'] = 'check_affiliate';
            $rules['affiliates.*.url'] = 'check_affiliate_url';
            $rules['affiliates.*.price'] = 'check_affiliate_price';
        }
        if($this->specification){
            $rules['specification'] = 'array';
            $rules['specification.*'] = 'specification';
        }

        return $rules;
        // return $this->parseRules($rules);
    }

    public function messages()
    {
        return array_merge([
            'name.required'                    => 'Tên sản phẩm không được bỏ trống',
            'name.string'                      => 'Tên sản phẩm không hợp lệ',
            'name.max'                         => 'Tên sản phẩm hơi... dài!',
            'name.unique_prop'                 => 'Tên sản phẩm bị trùng lặp',
            'feature_image.mimes'              => 'Định đạng file không được hỗ trợ',
            'category_id.required'             => 'Danh mục không được bỏ trống',
            'category_id.numeric'              => 'Danh mục không hợp lệ',
            'category_id.exists'               => 'Danh mục không tồn tại',
            'tags.check_tags'                  => 'Thẻ không hợp lệ',
            'gallery_data.base4_list'          => 'File không hợp lệ',

            'price_status.*'                   => 'Trạng thái giá không hợp lệ',
            'list_price.required'              => 'Giá sản phẩm không được bỏ trống',
            'list_price.check_price'           => 'Giá sản phẩm không không hợp lệ',
            'sale_price.check_sale_price'      => 'Giá khuyến mãi không hop75 lệ',
            'privacy.privacy'                  => 'Tính riêng tư không hợp lệ',
            'total.check_total'                => 'Số lượng sản phẩm nhập kho không hợp lệ',
            '*.max'                            => 'Vượt quá số ký tự cho phép',
            'affiliates.*.affiliate_id.*'      => 'Trang affiliate không hợp lệ',
            'affiliates.*.url.*'               => 'Liên kết affiliate không hợp lệ',
            'affiliates.*.price.*'             => 'Giá không hợp lệ. min: 0'
        ], $this->attrMessages);
    }
}
