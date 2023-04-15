<?php

namespace App\Validators\Transactions;

use App\Repositories\Orders\OrderRepository;
use App\Repositories\Services\UserServiceRepository;
use App\Validators\Base\BaseValidator;

class ServicePaymentValidator extends BaseValidator
{
    /**
     * order repo
     *
     * @var UserServiceRepository
     */
    protected $userServiceRepository;
    public function extends()
    {
        $this->userServiceRepository = new UserServiceRepository();
        // Thêm các rule ở đây
        
        $this->addRule('user_service_id', function($prop, $value){
            return $this->userServiceRepository->count(['id' => $value]) == 1;
        });

    }

    /**
     * ham lay rang buoc du lieu
     */
    public function rules()
    {
        return [
            'user_service_id'                   => 'required|user_service_id',
            'image'                             => 'required|mimes:jpg,jpeg,png,gif',
            'transaction_type'                  => 'mixed'
        ];
    }

    /**
     * các thông báo
     */
    public function messages()
    {
        return [
            'user_service_id.required'          => 'Mã dịch vụ không được bỏ trống',
            'order_id.check_order'              => 'Mã đơn hàng không hợp lệ',
            'image.mimes'                       => 'File không hợp lệ',
            

        ];
    }
}