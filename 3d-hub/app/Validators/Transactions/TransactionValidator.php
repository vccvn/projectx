<?php

namespace App\Validators\Transactions;

use App\Validators\Base\BaseValidator;

class TransactionValidator extends BaseValidator
{
    public function extends()
    {
        // Thêm các rule ở đây
    }

    /**
     * ham lay rang buoc du lieu
     */
    public function rules()
    {
    
        return [];
    }

    /**
     * các thông báo
     */
    public function messages()
    {
        return [];
    }
}