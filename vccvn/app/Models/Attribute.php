<?php

namespace App\Models;

class Attribute extends Model
{
    public $table = 'attributes';
    public $fillable = [
        'owner_id', 'category_id', 'category_map', 'name', 'label', 'input_type', 'value_type',
        'advance_value_type', 'show_type', 'value_unit',
        'is_required', 'is_query', 'is_order_option', 'is_variant',
        'price_type', 'is_unique', 'use_list'
        // 'priority'
    ];

    public $timestamps = false;

    /**
     * liên kiết tới bảng attribute_values
     * @param void
     * @return QueryBuilder
     */
    public function values()
    {
        return $this->hasMany(AttributeValue::class, 'attribute_id', 'id');//->orderBy("attribute_values.text_value", 'ASC');
    }

    /**
     * lấy về chi tiết giá trị tương ứng với loại giá trị
     */
    public function detailValues()
    {
        $select = ["id", "{$this->value_type}_value AS value", 'text_value as text', 'advance_value'];
        return $this->values()->select(...$select);
    }

    /**
     * xóa value
     */
    public function beforeDelete()
    {
        $this->deleteList('values');
    }

    /**
     * chuyển đổi thành thông tin cho Crazy\Html\Input
     * @param int $product_id
     * @return array
     */
    public function toProductInputParam($product_id = 0) : array
    {
        $data = [
            'name' => $this->name,
            'label' => $this->label,
            '@value-type' => $this->value_type,
            // 'required' => $this->is_required
            '@advance-value-type' => $this->advance_value_type,
            '@is-variant' => $this->is_variant,
            '@id' => $this->id,
            '@price-type' => $this->price_type
        ];
        $this->product_id = $product_id;
        $type = $this->input_type;

        $data['@scope'] = $this->category_id?'category':'general';


        $values = $this->getProductAttributeValues($product_id);
        $data['@values'] = $values;
        $idList = array_keys($values);

        if(in_array($type, ['checklist', 'tags', 'multiselect'])){
            $t = $type != 'tags' ? $type : 'crazytag';
            $data['type'] = $t;
            $data['template'] = $t;
            $data['value'] = $idList;
            if($type != 'tags'){
                $checkData = [];
                if(count($this->detailValues)){
                    if($this->is_variant){
                        foreach ($this->detailValues as $attrValue) {
                            $checkData[$attrValue->id] = [
                                'value_id' => $attrValue->id,
                                'advance_value' => $attrValue->advance_value,
                                'text' => $attrValue->text??$attrValue->value
                            ];
                        }
                    }else{
                        foreach ($this->detailValues as $attrValue) {
                            $checkData[$attrValue->id] = $attrValue->text??$attrValue->value;
                        }
                    }

                }
                $data['data'] = $checkData;
                if($this->is_variant){
                    $data['data-is-variant'] = true;
                    $data['data-price-type'] = $this->price_type;

                }
            }else{
                $tagData = [];
                if($this->detailValues){
                    foreach ($this->productAttributeValue as $attrVal) {
                        $tagData[] = [
                            'id' => $attrVal->id,
                            $this->value_type.'_value' => $attrVal->text??$attrVal->value
                        ];
                    }
                }
                $params = [
                    "@type" => "dynamic",
                    "@search-route"=> "admin.products.attributes.values",
                    '@search-route-params' => ['attribute_id' => $this->id],
                    "@create-route"=> "admin.products.attributes.values.create",
                    '@create-form-data' => ['attribute_id' => $this->id],
                    "@create-field"=> "value",
                    '@text-key' => $this->value_type.'_value',
                    '@value-key' => 'id',
                    "data" => $tagData
                ];
                $data = array_merge($data, $params);
            }
        }
        else{
            if(in_array($this->value_type, ['decimal', 'int'])){
                $data['type'] = 'number';
                if($this->value_unit){
                    $data['append_text'] = $this->value_unit;
                }
            }
            elseif ($this->value_type == 'text') {
                $data['type'] = 'textarea';
            }
            else{
                $data['type'] = 'text';
            }

            if($type=='select'){
                $data['type'] = 'select';
                $SelectData = [
                    '' => ' -- Chọn một -- '
                ];
                if(count($this->detailValues)){
                    foreach ($this->detailValues as $attrValue) {
                        $SelectData[$attrValue->id] = $attrValue->text??$attrValue->value;
                    }
                }
                $data['data'] = $SelectData;
            }

            if(count($this->productAttributeValue)){
                foreach ($this->productAttributeValue as $attrValue) {
                    $data['value'] = $type == 'select'?$attrValue->id : $attrValue->value;
                }
            }
        }
        if($this->is_required){
            $data['required'] = "true";
        }
        $data = array_merge($data, [
            'data-attribute-id' => $this->id,
            'data-attribute-value-type' => $this->value_type,
            'data-attribute-label' => $this->label??$this->name,
            'data-attribute-name' => $this->name,

        ]);



        return $data;
    }




    /**
     * chuyển đổi thành thông tin cho Crazy\Html\Input
     * @param int $product_id
     * @return array
     */
    public function toVariantInputParam($product_id = 0, $variant_id = 0) : array
    {
        $data = [
            'name' => $this->name,
            'label' => $this->label,
            // 'required' => $this->is_required
            'id' => $this->id
        ];
        $this->product_id = $product_id;
        $type = $this->input_type;

        $data['@scope'] = $this->category_id?'category':'general';
        if(in_array($type, ['checklist', 'tags', 'multiselect'])){
            $t = $type != 'tags' ? $type : 'crazytag';
            $data['type'] = $t;
            $data['template'] = $t;
            $data['data'] = $this->getProductAttributeValueData($product_id);

            if($type != 'tags'){
                if($this->has_price){
                    $data['data-has-price'] = true;
                    $data['data-price-type'] = $this->price_type;

                }
            }else{
                $params = [
                    "@type" => "dynamic",
                    "@search-route"=> "admin.products.attributes.values",
                    '@search-route-params' => ['attribute_id' => $this->id],
                    "@create-route"=> "admin.products.attributes.values.create",
                    '@create-form-data' => ['attribute_id' => $this->id],
                    "@create-field"=> "value",
                    '@text-key' => $this->value_type.'_value',
                    '@value-key' => 'id',
                ];
                $data = array_merge($data, $params);
            }
        }
        else{
            if(in_array($this->value_type, ['decimal', 'int'])){
                $data['type'] = 'number';
                if($this->value_unit){
                    $data['append_text'] = $this->value_unit;
                }
            }
            elseif ($this->value_type == 'text') {
                $data['type'] = 'textarea';
            }
            else{
                $data['type'] = 'text';
            }

            if($type=='select'){
                $data['type'] = 'select';
                $SelectData = [
                    '' => ' -- Chọn một -- '
                ];
                $data['data'] = $SelectData + $this->getProductAttributeValueData($product_id);
            }

            if(count($this->productAttributeValue)){
                foreach ($this->productAttributeValue as $attrValue) {
                    $data['value'] = $type == 'select'?$attrValue->id : $attrValue->value;
                }
            }
        }
        if($this->is_required){
            $data['required'] = "true";
        }
        if($valueData = $this->getVariantAttributeValue($variant_id)){
            $data['value'] = $valueData['value_id'];
            $data['@variant_advance_value'] = $valueData['variant_advance_value'];

        }
        $data['@advance_value_type'] = $this->advance_value_type;
        // $data['value'] = $this->getVariantAttributeValueId($product_id, $variant_id);
        $data = array_merge($data, [
            'data-attribute-id' => $this->id,
            'data-attribute-value-type' => $this->value_type,
            'data-attribute-label' => $this->label??$this->name,
            'data-attribute-name' => $this->name,


        ]);

        return $data;
    }

    /**
     * lấy danh sách id của value dược check
     * @param int $product_id
     * @return array
     */
    public function getProductAttributeValueIdList($product_id = 0) : array
    {
        if(!$product_id) return [];
        $valueList = [];
        $this->product_id = $product_id;
        $productAttributeValue = $this->productAttributeValue;

        if(count($productAttributeValue)){
            foreach ($productAttributeValue as $pav) {
                $valueList[] = $pav->id;
            }
        }

        return $valueList;
    }
    /**
     * lấy danh sách id của value dược check
     * @param int $product_id
     * @return array
     */
    public function getProductAttributeValues($product_id = 0) : array
    {
        if(!$product_id) return [];
        $valueList = [];
        $this->product_id = $product_id;
        $productAttributeValue = $this->productAttributeValue;

        if(count($productAttributeValue)){
            foreach ($productAttributeValue as $pav) {
                $valueList[$pav->id] = $pav->toArray();
            }
        }

        return $valueList;
    }
    /**
     * lấy danh sách id của value dược check
     * @param int $product_id
     * @return array
     */
    public function getProductAttributeValueData($product_id = 0) : array
    {
        if(!$product_id) return [];
        $valueList = [];
        $this->product_id = $product_id;
        $productAttributeValue = $this->productAttributeValue;

        if(count($productAttributeValue)){
            foreach ($productAttributeValue as $pav) {
                $valueList[$pav->id] = $pav->text?$pav->text:$pav->value;
            }
        }

        return $valueList;
    }
    /**
     * lấy danh sách id của value dược check
     * @param int $product_id
     * @return array
     */
    public function getVariantAttributeValue($variant_id = 0) : array
    {
        if(!$variant_id) return [];
        $this->variant_id = $variant_id;
        $variantAttributeValue = $this->variantAttributeValue;
        if(count($variantAttributeValue)){
            foreach ($variantAttributeValue as $pav) {
                return ['value_id' => $pav->value_id, 'variant_advance_value' =>$pav->variant_advance_value];
            }
        }

        return [];
    }

    /**
     * product attribute value
     */
    public function productAttributeValue()
    {
        return $this->values()
                    ->join('product_attributes', 'product_attributes.attribute_value_id', '=', 'attribute_values.id')
                    ->where('product_attributes.product_id', $this->product_id)
                    ->select(
                        "attribute_values.attribute_id",
                        'product_attributes.attribute_value_id',
                        'product_attributes.product_id',
                        'product_attributes.id as product_attribute_value_id',
                        'product_attributes.advance_value',
                        'product_attributes.price',
                        'product_attributes.is_default',
                        'attribute_values.id',
                        "attribute_values.{$this->value_type}_value AS value",
                        'attribute_values.text_value as text',
                        'attribute_values.varchar_value',
                        'attribute_values.int_value',
                        'attribute_values.decimal_value',
                        'attribute_values.text_value'
                    );
    }

    /**
     * product attribute value
     */
    public function variantAttributeValue()
    {
        return $this->values()
                    ->join('product_variant_attributes', 'product_variant_attributes.attribute_value_id', '=', 'attribute_values.id')
                    ->where('product_variant_attributes.product_variant_id', $this->variant_id)
                    ->select(
                        "attribute_values.attribute_id",
                        'attribute_values.id as value_id',
                        'product_variant_attributes.variant_advance_value'
                    );
    }
}
