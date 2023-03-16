<?php

namespace App\Http\Controllers\Admin\General;

use App\Http\Controllers\Admin\AdminController;

use Illuminate\Http\Request;
use Crazy\Helpers\Arr;

use App\Repositories\Bookings\BookingRepository;

class BookingController extends AdminController
{
    protected $module = 'bookings';

    protected $moduleName = 'Booking';

    protected $flashMode = true;

    /**
     * repository chinh
     *
     * @var BookingRepository
     */
    public $repository;
    
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(BookingRepository $repository)
    {
        $this->repository = $repository;
        $this->init();
    }

}
