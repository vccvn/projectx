<?php

namespace App\Http\Controllers\Clients;

use App\Http\Controllers\Clients\ClientController;

use Illuminate\Http\Request;
use Crazy\Helpers\Arr;

use App\Repositories\Notices\NoticeRepository;

class AlertController extends ClientController
{
    protected $module = 'alert';

    protected $moduleName = 'Alert';

    protected $flashMode = true;
    
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(NoticeRepository $NoticeRepository)
    {
        $this->repository = $NoticeRepository;
        $this->init();
    }

    public function message(Request $request)
    {
        
        $this->breadcrumb->add('thông báo');
        $data = array_merge([
            'page_title' => 'thông báo'
        ], $request->all());
        return $this->viewModule('message', $data);
    }

}
