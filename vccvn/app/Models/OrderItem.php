<?php

namespace App\Models;

class OrderItem extends Model
{
    public $table = 'order_items';
    public $fillable = ['owner_id', 'order_id', 'product_id', 'attr_values', 'quantity', 'list_price', 'final_price', 'note'];


    public $timestamps = false;

    /**
     * thuộc tính
     */
    public function getAttrs()
    {
        $attrValues = explode('-', $this->attr_values);
        if(!$attrValues) return [];
        $query = Attribute::join('attribute_values', 'attribute_values.attribute_id', '=', 'attributes.id')
                            ->whereIn('attribute_values.id', $attrValues)
                            ->select(
                                'attributes.id', 
                                'attributes.name', 
                                'attributes.label', 
                                'attributes.value_type', 
                                'attribute_values.id AS value_id', 
                                'attribute_values.varchar_value', 
                                'attribute_values.int_value', 
                                'attribute_values.decimal_value', 
                                'attribute_values.text_value'
                            );
        return $query->get();
    }
    
    /**
     * lay du lieu form
     * @return array
     */
    public function toFormData()
    {
        $data = $this->toArray();
        $data['attr_values'] = explode('-', $this->attr_values);
        return $data;
    }
}
