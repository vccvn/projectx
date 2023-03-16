<?php

namespace App\Validators\Transactions;

use App\Repositories\Packages\WebAccountLimitedUpgradePaymentRepository;
use App\Validators\Base\BaseValidator;

class TransferPackagePaymentValidator extends BaseValidator
{

    /**
     * order repo
     *
     * @var WebAccountLimitedUpgradePaymentRepository
     */
    protected $accountPaymentRepository;
    public function extends()
    {
        $this->accountPaymentRepository = app(WebAccountLimitedUpgradePaymentRepository::class);
        $this->addRule('package_payment_id', function($prop, $value){
            return $this->accountPaymentRepository->count(['id' => $value]) == 1;
        });
    }

    /**
     * ham lay rang buoc du lieu
     */
    public function rules()
    {
        return [
            'package_payment_id'                => 'required|package_payment_id',
            'image'                             => 'required|mimes:jpg,jpeg,png,gif,heic,jelc',
            'transaction_type'                  => 'mixed',
            'note'                              => 'mixed',
            
        ];
    }

    /**
     * các thông báo
     */
    public function messages()
    {
        return [
            'package_payment_id.required'       => 'Mã dịch vụ không được bỏ trống',
            'image.mimes'                       => 'File không hợp lệ',
            

        ];
    }
}