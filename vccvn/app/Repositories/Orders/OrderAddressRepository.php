<?php

namespace App\Repositories\Orders;

use App\Repositories\Base\BaseRepository;

class OrderAddressRepository extends BaseRepository
{

    /**
     * tên class mặt nạ. Thược có tiền tố [tên thư mục] + \ vá hậu tố Mask
     *
     * @var string
     */
    protected $maskClass = 'Orders\OrderAddressMask';

    /**
     * tên collection mặt nạ
     *
     * @var string
     */
    protected $maskCollectionClass = 'Orders\OrderAddressCollection';

    /**
     * get model
     * @return string
     */
    public function getModel()
    {
        return \App\Models\OrderAddress::class;
    }

    /**
     * cập nhật thông tin địa chỉ cho đơn hàng
     *
     * @param integer $order_id
     * @param string $type
     * @param array $data
     * @return \App\Models\OrderAddress
     */
    public function updateAddress($order_id = 0, $type = null, $data = [])
    {
        if(!is_numeric($order_id) || $order_id < 1 || !is_string($type) || !in_array($type = strtolower($type), ['billing', 'shipping']) || !is_array($data)) return null;
        $params = compact('order_id', 'type');
        if($address = $this->first($params)){
            return $this->update($address->id, $data);
        }
        return $this->create(array_merge($params, $data));
    }

}