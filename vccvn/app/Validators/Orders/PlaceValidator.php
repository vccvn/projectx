<?php

namespace App\Validators\Orders;

use App\Engines\Helper;
use App\Repositories\Locations\DistrictRepository;
use App\Repositories\Locations\RegionRepository;
use App\Repositories\Locations\WardRepository;
use App\Validators\Base\BaseValidator;

class PlaceValidator extends BaseValidator
{
    public $methods = [];
    public function extends()
    {
        $this->methods = Helper::getPaymentMethodOptions();
        $this->addRule('check_method', function($attr, $value){
            if(!$value) return false;
            
            $s = false;
            if($this->methods && count($this->methods)){
                foreach ($this->methods as $key => $method) {
                    if($key == $value || $method->method == $value) $s = true;
                }
            }
            return $s;
        });

        $this->addRule('vnpay_bank', function($attr, $value){
            if($this->methods && count($this->methods)){
                foreach ($this->methods as $key => $method) {
                    if($key == 'vnpay' || $method->method == 'vnpay'){
                        if($method->configData && is_countable($method->configData)){
                            foreach ($method->configData as $code => $bank) {
                                if($value == $code || $value == $bank->code){
                                    return true;
                                }
                            }
                        }
                    }
                }
            }
            return false;
        });
        

    }

    /**
     * ham lay rang buoc du lieu
     */
    public function rules()
    {
        $rules = [
            'billing_name'                        => 'required|string|max:191',
            'billing_email'                       => 'required|email',
            'billing_phone_number'                => 'required|phone_number',
            'billing_address'                     => 'required',
            'billing_region_id'                   => 'required|check_region',
            'billing_district_id'                 => 'required|check_district:billing_region_id',
            'billing_ward_id'                     => 'required|check_ward:billing_district_id',
            'payment_method'                      => 'check_method',
            'note'                                => 'mixed',
            'create_account'                      => 'check_boolean',
            
            'ship_to_different_address'           => 'check_boolean',
        ];
        if(!$this->user() && $this->create_account){
            $rules['password']                    =  'required|string|min:6';
        }

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
        if($this->payment_method == 'vnpay'){
            $rules['vnpay_bank'] = 'vnpay_bank';
        }
    
        return $rules;
    }

    /**
     * các thông báo
     */
    public function messages()
    {
        return [
            
            'payment_method.check_method'         => 'Phương thức thanh toán không hợp lệ',
            'password.required'                   => 'Bạn chưa nhập mật khẩu',
            'password.min'                        => 'Mật khẩu phải có ít nhất 6 ký tự',
            

            'billing_name.max'                    => 'Họ tên dài vựa quá số ký tự',
            'billing_name.required'               => 'Bạn chưa nhập họ và tên',
            'billing_email.required'              => 'Bạn chưa nhập email',
            'billing_email.email'                 => 'Email không hợp lệ',
            'billing_phone_number.required'       => 'Số điện thoại không được bỏ trống',
            'billing_phone_number.phone_number'   => 'Số điện thoại không hơp lệ',
            'billing_address.required'            => 'Địa chỉ không được bỏ trống',
            'billing_address.max'                 => 'Địa chỉ không hợp lệ',
            'billing_region_id.required'          => 'Vui lòng chọn tỉnh / thành phố',
            'billing_region_id.check_region'      => 'Tỉnh / thành phố không hợp lệ',
            'billing_district_id.required'        => 'Vui lòng chọn quận / huyện',
            'billing_district_id.check_district'  => 'Quận / huyện không hợp lệ',
            'billing_ward_id.required'            => 'Vui lòng chọn phường / xã',
            'billing_ward_id.check_ward'          => 'phường / xã phố không hợp lệ',
            

            'shipping_name.max'                   => 'Họ tên dài vựa quá số ký tự',
            'shipping_name.required'              => 'Bạn chưa nhập họ và tên',
            'shipping_email.required'             => 'Bạn chưa nhập email',
            'shipping_email.email'                => 'Email không hợp lệ',
            'shipping_phone_number.required'      => 'Số điện thoại không được bỏ trống',
            'shipping_phone_number.phone_number'  => 'Số điện thoại không hơp lệ',
            'shipping_address.required'           => 'Địa chỉ không được bỏ trống',
            'shipping_address.max'                => 'Địa chỉ không hợp lệ',
            'shipping_region_id.required'         => 'Vui lòng chọn tỉnh / thành phố',
            'shipping_region_id.check_region'     => 'Tỉnh / thành phố không hợp lệ',
            'shipping_district_id.required'       => 'Vui lòng chọn quận / huyện',
            'shipping_district_id.check_district' => 'Quận / huyện không hợp lệ',
            'shipping_ward_id.required'           => 'Vui lòng chọn phường / xã',
            'shipping_ward_id.check_ward'         => 'phường / xã phố không hợp lệ',
            'vnpay_bank'                          => 'Ngân hàng / Ví diện tử không hợp lệ'
            
        ];
    }
}