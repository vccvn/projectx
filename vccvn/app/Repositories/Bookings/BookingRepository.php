<?php

namespace App\Repositories\Bookings;

use App\Repositories\Base\BaseRepository;

class BookingRepository extends BaseRepository
{
    /**
     * class chứ các phương thức để validate dử liệu
     * @var string $validatorClass 
     */
    protected $validatorClass = 'Bookings\BookingValidator';
    /**
     * tên class mặt nạ. Thường có tiền tố [tên thư mục] + \ vá hậu tố Mask
     *
     * @var string
     */
    protected $maskClass = 'Bookings\BookingMask';

    /**
     * tên collection mặt nạ
     *
     * @var string
     */
    protected $maskCollectionClass = 'Bookings\BookingCollection';

    /**
     * @var \App\Models\Booking
     */
    static $__Model__;

    /**
     * get model
     * @return string
     */
    public function getModel()
    {
        return \App\Models\Booking::class;
    }

}