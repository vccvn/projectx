<?php

namespace App\Http\Controllers\Admin\Business;

use Illuminate\Http\Request;
use App\Http\Controllers\Admin\AdminController;
use Crazy\Helpers\Arr;

use App\Repositories\Teams\TeamRepository;

class TeamController extends AdminController
{
    protected $module = 'teams';

    protected $moduleName = 'Nhóm';

    protected $flashMode = true;
    
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(TeamRepository $TeamRepository)
    {
        $this->repository = $TeamRepository;
        $this->repository->mode('mask');
        $this->init();
    }


    public function beforeGetListView(Request $request)
    {
        add_js_data('team_data', [
            'urls' => [
                'detail' => $this->getModuleRoute('detail'),
                'member_detail' => $this->getModuleRoute('members.detail'),
                'delete_member' => $this->getModuleRoute('members.delete')
            ],
        ]);
    }

    public function beforeGetResourceDetail($request)
    {
        $this->repository->with('members');
    }

}
