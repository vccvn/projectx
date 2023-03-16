<?php

namespace App\Http\Controllers\Admin\Business;

use Illuminate\Http\Request;
use App\Http\Controllers\Admin\AdminController;
use Crazy\Helpers\Arr;

use App\Repositories\Clients\FeedbackRepository;

class ClientFeedbackController extends AdminController
{
    protected $module = 'clients.feedback';

    protected $moduleName = 'Feedback từ khách hàng';

    protected $flashMode = true;
    
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(FeedbackRepository $FeedbackRepository)
    {
        $this->repository = $FeedbackRepository;
        $this->init();
    }

}
