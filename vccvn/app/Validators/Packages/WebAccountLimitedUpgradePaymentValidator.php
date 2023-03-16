<?php

namespace App\Validators\Packages;

use App\Engines\Helper;
use App\Repositories\Packages\WebAccountPackageRepository;
use App\Validators\Base\BaseValidator;

class WebAccountLimitedUpgradePaymentValidator extends BaseValidator
{    
    public $methods = [];
    public function extends()
    {
        $this->methods = Helper::getPaymentMethodOptions();
        $this->addRule('check_package', function ($attr, $value){
            return app(WebAccountPackageRepository::class)->notTrashed()->count(['id'=>$value]) == 1;
        });

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
            'package_id'                          => 'required|check_package',
            'payment_method'                      => 'check_method',
        ];
        if($this->payment_method == 'vnpay'){
            $rules['vnpay_bank']                   = 'vnpay_bank';
        }
    
        return $rules;
        
    }

    /**
     * các thông báo
     */
    public function messages()
    {
        return [
            
            'package_id.required'                 => 'Thông tin gói không được bỏ trống',
            'package_id.check_package'            => 'Thông tin gói không hợp lệ',
            'vnpay_bank'                          => 'Ngân hàng / Ví diện tử không hợp lệ',
            'payment_method.*'                    => 'Phương thu7v1 thanh toán không hợp lệ'
            

        ];
    }
}