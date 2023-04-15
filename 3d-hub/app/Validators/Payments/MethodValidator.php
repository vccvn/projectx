<?php

namespace App\Validators\Payments;

use App\Validators\Base\BaseValidator;

class MethodValidator extends BaseValidator
{
    public function extends()
    {
        $this->addRule('check_method', function ($attr, $value) {
            $methods = get_payment_config('methods');
            if (is_array($methods)) {
                return array_key_exists($value, $methods);
                return false;
            }
            return true;
        });
        $this->addRule('check_config', function ($attr, $value) {
            if (!is_array($value) || !($mtData = get_payment_method_inputs(isset($value['method']) && $value['method'] ? $value['method'] : ($this->payment_method ? $this->payment_method : $this->method)))) return false;
            if (isset($mtData['inputs'])) {
                $inputs = $mtData['inputs'];
                foreach ($inputs as $key => $inp) {
                    if (!in_array($key, ['name', 'description', 'method'])) {
                        if ((isset($inp['required']) && $inp['required'] && (!isset($value[$key]) || $value[$key] == ""))) return false;
                        if ($inp['type'] == 'number' && !is_numeric($value[$key])) return false;
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

        return [

            'name' => 'required|string|max:191',
            'method' => 'required|check_method|unique_prop',
            'description' => 'mixed',
            'config' => 'check_config'

        ];
    }

    /**
     * các thông báo
     */
    public function messages()
    {
        return [

            'name.*' => 'Tên hiển thị Không hợp lệ',
            'method.required' => 'Phương thức thanh toán Không được bỏ trống',
            'method.check_method' => 'Phương thức thanh toán Không hợp lệ',
            'method.unique_prop' => 'Phương thức thanh toán đã tồn tại',
            'config.*' => 'Thông tin config Không hợp lệ'

        ];
    }
}
