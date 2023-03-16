<?php

namespace App\Validators\Orders;

use App\Validators\Base\BaseValidator;
use App\Repositories\Products\AttributeValueRepository;
use App\Repositories\Products\ProductRepository;

class OrderValidator extends BaseValidator
{
    public $attributeValueRepository;
    public $productRepository;

    /**
     * repository chinh
     *
     * @var RegionRepository
     */
    public $regionRepository;
    
    /**
     * @var DistrictRepository
     *
     */
    public $districtRepository;

    /**
     * reposaitory quanr ly xa / phuong
     *
     * @var WardRepository
     */
    public $wardRepository;

    public function extends()
    {
        $this->attributeValueRepository = new AttributeValueRepository();
        $this->productRepository = new ProductRepository();
        // Thêm các rule ở đây
        $this->addRule('check_payment_method', function ($prop, $value){
            if(!is_null($value)) return array_key_exists($value, get_payment_method_id_options());
            return true;
        });
        
        $this->addRule('check_ship_fee', function ($prop, $value){
            if(!is_null($value)) (is_numeric($value) && $value >= 0);
            return true;
        });

        $this->addRule('check_vat', function ($prop, $value){
            if(!is_null($value)) (is_numeric($value) && $value >= 0 && $value <= 1000);
            return true;
        });

        $this->addRule('check_status', function ($prop, $value){
            if(!is_null($value)) return in_array($value, [0, 100, 200, 300, 400, 500, 1000, -1]);
            return true;
        });

        $this->addRule('check_items', function($prop, $value){
            if(!is_array($value) || !count($value)) return false;
            $item = $value;
            if(!isset($item['product_id']) || !isset($item['quantity']) || !is_numeric($item['quantity']) || $item['quantity'] < 1 || !$this->productRepository->findBy('id', $item['product_id'])) return false;
            if(isset($item['attr_values'])){
                if(is_array($item['attr_values'])){
                    foreach ($item['attr_values'] as $name => $value_id) {
                        if(!$this->attributeValueRepository->checkAttributeValue($name, $value_id, $item['product_id']??0)) return false;
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
            'shipping_fee'                        => 'check_ship_fee',
            'tax'                                 => 'check_vat',
            'payment_method_id'                   => 'check_payment_method',
            'status'                              => 'check_status',
            'items.*'                             => 'check_items',
            'ship_to_different_address'           => 'check_boolean',
            'note'                                => 'mixed',
            
            'billing_name'                        => 'required|string|max:191',
            'billing_email'                       => 'required|email',
            'billing_phone_number'                => 'required|phone_number',
            'billing_address'                     => 'required',
            'billing_region_id'                   => 'required|check_region',
            'billing_district_id'                 => 'required|check_district:billing_region_id',
            'billing_ward_id'                     => 'required|check_ward:billing_district_id',
            
        ];
        
        if($this->ship_to_different_address){
            $rules = array_merge($rules, [
                'shipping_name'                   => 'required|string|max:191',
                'shipping_email'                  => 'required|email',
                'shipping_phone_number'           => 'required|phone_number',
                'shipping_address'                => 'required',
                'shipping_region_id'              => 'required|check_region',
                'shipping_district_id'            => 'required|check_district:shipping_region_id',
                'shipping_ward_id'                => 'required|check_ward:shipping_district_id',
            ]);
        }

        return $rules;;
    }

    /**
     * các thông báo
     */
    public function messages()
    {
        return [
            
            'billing_name.max'                     => 'Họ tên dài vựa quá số ký tự',
            'billing_name.required'                => 'Bạn chưa nhập họ và tên',
            'billing_email.required'               => 'Bạn chưa nhập email',
            'billing_email.email'                  => 'Email không hợp lệ',
            'billing_phone_number.required'        => 'Số điện thoại không được bỏ trống',
            'billing_phone_number.phone_number'    => 'Số điện thoại không hơp lệ',
            'billing_address.required'             => 'Địa chỉ không được bỏ trống',
            'billing_address.max'                  => 'Địa chỉ không hợp lệ',
            'billing_region_id.required'           => 'Vui lòng chọn tỉnh / thành phố',
            'billing_region_id.check_region'       => 'Tỉnh / thành phố không hợp lệ',
            'billing_district_id.required'         => 'Vui lòng chọn quận / huyện',
            'billing_district_id.check_district'   => 'Quận / huyện không hợp lệ',
            'billing_ward_id.required'             => 'Vui lòng chọn phường / xã',
            'billing_ward_id.check_ward'           => 'phường / xã phố không hợp lệ',
            

            'shipping_name.max'                    => 'Họ tên dài vựa quá số ký tự',
            'shipping_name.required'               => 'Bạn chưa nhập họ và tên',
            'shipping_email.required'              => 'Bạn chưa nhập email',
            'shipping_email.email'                 => 'Email không hợp lệ',
            'shipping_phone_number.required'       => 'Số điện thoại không được bỏ trống',
            'shipping_phone_number.phone_number'   => 'Số điện thoại không hơp lệ',
            'shipping_address.required'            => 'Địa chỉ không được bỏ trống',
            'shipping_address.max'                 => 'Địa chỉ không hợp lệ',
            'shipping_region_id.required'          => 'Vui lòng chọn tỉnh / thành phố',
            'shipping_region_id.check_region'      => 'Tỉnh / thành phố không hợp lệ',
            'shipping_district_id.required'        => 'Vui lòng chọn quận / huyện',
            'shipping_district_id.check_district'  => 'Quận / huyện không hợp lệ',
            'shipping_ward_id.required'            => 'Vui lòng chọn phường / xã',
            'shipping_ward_id.check_ward'          => 'phường / xã phố không hợp lệ',

            'status.required'                      => 'Trạng thái không hợp lệ',
            'status.check_status'                  => 'Trạng thái không hợp lệ',
            'payment_method_id.check_payment_method'=>'Phương thức thanh toán không hợp lệ',
            'shipping_fee.check_ship_fee'          => 'Phí giao hàng không hợp lệ',
            'tax.check_vat'                        => 'Thuế VAT không hợp lệ',
            'items.*.check_items'                  => 'Sản phẩm không hợp lệ!'
        ];
    }
}