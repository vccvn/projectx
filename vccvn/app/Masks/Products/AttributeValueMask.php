<?php
namespace App\Masks\Products;

use App\Models\AttributeValue;
use Crazy\Magic\Mask;

class AttributeValueMask extends Mask
{

    // xem thêm ExampleMask
    /**
     * thêm các thiết lập của bạn
     * ví dụ thêm danh sách cho phép truy cập vào thuộc tính hay gọi phương thức trong model
     * hoặc map vs các quan hệ dữ liệu
     *
     * @return void
     */
    protected function init(){
        $this->map([
            'attribute' => AttributeMask::class
        ]);
    }

    /**
     * lấy data từ model sang mask
     * @param AttributeValue $attributeValue Tham số không bắt buộc phải khai báo. 
     * Xem thêm ExampleMask
     */
    // public function toMask()
    // {
    //     $data = $this->getAttrData();
    //     return $data;
        
    // }

    /**
     * sẽ được gọi sau khi thiết lập xong
     *
     * @return void
     */
    protected function onLoaded()
    {
        $attribute = get_model_data('product_attribute', $this->attribute_id);
        if($attribute){
            if($attribute->advance_value_type == 'image'){
                $d = 'static/products/attributes/';
                $this->image = null;
                if($this->advance_value && file_exists(public_path($p = $d.$this->advance_value))){
                    $this->image_url = asset($p);
                    $this->image = $this->advance_value;
                }else{
                    $this->image_url = asset($d.'/default.png');
                }
            }elseif($attribute->advance_value_type == 'color'){
                $this->color = $this->advance_value;
            }
            $this->value = $this->{$attribute->value_type.'_value'};
            $this->text = $this->text_value??$this->value;
        }
    }

    
    /**
     * Convert the object into something JSON serializable.
     *
     * @return array
     */
    // public function toArray()
    // {
    //     $data = parent::toArray();
    //     $attribute = get_model_data('product_attribute', $this->attribute_id);
    //     if($attribute){
    //         if($attribute->advance_value_type == 'image'){
    //             $d = 'static/products/attributes/';
    //             $data['image'] = null;
    //             if($this->advance_value && file_exists(public_path($p = $d.$this->advance_value))){
    //                 $data['image_url'] = asset($p);
    //                 $data['image'] = $this->advance_value;
    //             }else{
    //                 $data['image_url'] = asset($d.'/default.png');
    //             }
    //         }elseif($attribute->advance_value_type == 'color'){
    //             $data['color'] = $this->advance_value;
    //         }
    //         $data['value'] = $this->{$attribute->value_type.'_value'};
    //         $data['text'] = $this->text_value??$data['value'];
    //     }
    //     return $data;
        
    // }

    
    
    /**
     * Convert the object into something JSON serializable.
     *
     * @return array
     */
    public function jsonSerialize()
    {
        return array_map(function ($value) {
            if ($value instanceof JsonSerializable) {
                return $value->jsonSerialize();
            } elseif ($value instanceof Jsonable) {
                return json_decode($value->toJson(), true);
            } elseif ($value instanceof Arrayable) {
                return $value->toArray();
            }

            return $value;
        }, $this->toArray());
    }

    
    
    // khai báo thêm các hàm khác bên dưới nếu cần
}