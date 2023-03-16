<?php

namespace App\Validators\Products;

use App\Validators\Base\BaseValidator;
use App\Repositories\Products\CategoryRepository;

class AttributeValidator extends BaseValidator
{
    public $categoryRepository;
    public function extends()
    {
        $this->categoryRepository = new CategoryRepository();

        $this->addRule('check_category', function($prop, $value){
            if(!$value) return true;
            return $this->categoryRepository->findBy('id', $value)?true:false;
        });

        $this->addRule('check_unique_name', function($prop, $value){
            $args = ['name' => $value];
            $cate_list = [];
            if($this->category_id){
                if($cate = $this->categoryRepository->findBy('id', $this->category_id)){
                    $args['category_id'] = array_merge([0], $cate->getMap());
                }
            }
            $list = $this->repository->get($args);
            if(count($list)){
                if(!$this->id) return false;
                foreach ($list as $key => $attr) {
                    if($attr->id != $this->id) return false;
                }
            }
            return true;
        });

        $this->addRule('check_value_type', function($prop, $value){
            return in_array(strtolower($value), ['varchar', 'int', 'decimal', 'text']);
        });
        $this->addRule('check_show_type', function($prop, $value){
            if($this->value_type!='texr'){
                if($this->is_required){
                    if($this->is_order_option){
                        return in_array($value, ['dropdown', 'radio', 'checkbox']);
                    }
                    return in_array($value, ['dropdown', 'radio', 'checkbox', 'simple']);
                }
            }
            return true;
        });
        
        $this->addRule('advance_value_type', function($prop, $value){
            if(!$value) return true;
            $list = ['default', 'color', 'image'];
            return in_array(strtolower($value), $list);
        });

        $this->addRule('check_input_type', function($prop, $value){
            if($this->is_required && !$this->is_uniqye){
                if($this->input_type){
                    // $list = $this->is_order_option ? ['default', 'select', 'checklist', 'tags', 'multiselect'] : ['default', 'select'];
                    $list = ['default', 'select', 'checklist', 'tags', 'multiselect'];
                    return in_array(strtolower($value), $list);
                }
            
            }
            return true;
        });

        $this->addRule('check_price_type', function($prop, $value){
            if(!$this->is_uniqye && $this->value_type!='text' && $this->is_order_option && $this->is_variant && $this->price_type){
                $args = ['price_type' => 1];
                $cate_list = [];
                if($this->category_id){
                    if($cate = $this->categoryRepository->findBy('id', $this->category_id)){
                        $args['category_id'] = array_merge([0], $cate->getMap());
                    }
                }
                $list = $this->repository->get($args);
                if(count($list)){
                    if(!$this->id) return false;
                    foreach ($list as $key => $attr) {
                        if($attr->id != $this->id) return false;
                    }
                }
                
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
            'category_id'                      => 'check_category',
            'name'                             => 'required|string|max:191|check_unique_name|is_slug',
            'label'                            => 'mixed',
            'input_type'                       => 'check_input_type',
            'value_type'                       => 'check_value_type',
            'show_type'                        => 'check_show_type',
            'is_required'                      => 'binary',
            'is_unique'                        => 'binary',
            'is_query'                         => 'binary',
            'is_order_option'                  => 'binary',
            'is_variant'                        => 'binary',
            'price_type'                       => 'binary|check_price_type',
            'value_unit'                       => 'mixed',
            'advance_value_type'               => 'advance_value_type'
        ];
        

        return $rules;
        // return $this->parseRules($rules);
    }

    public function messages()
    {
        return [
            'name.required'                    => 'Tên thuộc tính không được bỏ trống',
            'name.string'                      => 'Tên thuộc tính không hợp lệ',
            'name.is_slug'                     => 'Tên thuộc tính không được chứa ký tự đặc biệt hay chuỗi unicode',
            'name.max'                         => 'Tên thuộc tính hơi... dài!',
            'name.check_unique_name'           => 'Tên thuộc tính bị trùng lặp',
            'category_id.check_category'       => 'Danh mục không hợp lệ',
            'input_type.check_input_type'      => 'Kiểu input không hợp lệ',
            'value_type.check_value_type'      => 'Kiểu giá trị không hợp lệ',
            'show_type.check_show_type'        => 'kiểu hiển thị không hợp lệ',
            'price_type.check_price_type'      => 'Chỉ có thể tồn tại một thuộc tính duy nhất trong cây danh mục có thể thay đỏi giá gôc',
            'advance_value_type.*'             => 'Kiểu giá trị bổ xung không hợp lệ'
            
        ];
    }
}