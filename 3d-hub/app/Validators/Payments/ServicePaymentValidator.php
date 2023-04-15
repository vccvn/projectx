<?php

namespace App\Validators\Payments;

use App\Engines\Helper;
use App\Validators\Base\BaseValidator;

class ServicePaymentValidator extends BaseValidator
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
        $this->addRule('atm_bank', function($attr, $value){
            if($this->methods && count($this->methods)){
                foreach ($this->methods as $key => $method) {
                    if($key == 'atm' || $method->method == 'atm'){
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
            'payment_method' => 'check_method'
        ];
        if($this->payment_method == 'vnpay'){
            $rules['vnpay_bank'] = 'vnpay_bank';
        }
        if($this->payment_method == 'atm'){
            $rules['atm_bank'] = 'atm_bank';
        }
    
        return $rules;
    }

    /**
     * các thông báo
     */
    public function messages()
    {
        return [
            'payment_method' => 'Phương thức thanh toán không hợp lệ',
            'vnpay_bank' => 'Ngân hàng / Ví diện tử không hợp lệ'

        ];
    }
}