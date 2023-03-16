<?php

namespace App\Validators\Bookings;

use App\Validators\Base\BaseValidator;

class BookingValidator extends BaseValidator
{
    public function extends()
    {
        // Thêm các rule ở đây
        $this->addRule('check_quantity', function ($attr, $value)
        {
            
            if(!$value || $value == "") return true;
            return is_numeric($value) && $value > 0 && (((int) $value) == $value);
        });
    }

    /**
     * ham lay rang buoc du lieu
     */
    public function rules()
    {
    
        return [
            'title' => 'mixed',
            'name' => 'required|string|max:191',
            'email' => 'required|email',
            'phone_number' => 'phone_number',
            'address' => 'mixed',
            'message' => 'mixed',
            'booking_time' => 'mixed|strdatetime',
            'quantity' => 'check_quantity'

        ];
    }

    /**
     * các thông báo
     */
    public function messages()
    {
        return [
            
            'title' => 'title Không hợp lệ',
            'name' => 'Tên Không hợp lệ',
            'email' => 'Email Không hợp lệ',
            'phone_number' => 'SĐT Không hợp lệ',
            'address' => 'address Không hợp lệ',
            'message' => 'message Không hợp lệ',
            'booking_time' => 'Thời gian Không hợp lệ',
            'quantity' => 'Số lượng Không hợp lệ',

        ];
    }
}