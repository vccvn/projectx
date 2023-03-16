<?php

namespace App\Http\Controllers\Manager;

use Illuminate\Http\Request;

use App\Repositories\Profiles\OrganizationRepository;


use Crazy\Helpers\Arr;

class OrganizationController extends ManagerController
{
    protected $module = 'organizations';

    protected $moduleName = 'Tổ chức';

    protected $flashMode = true;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(OrganizationRepository $organizationRepository)
    {
        $this->repository = $organizationRepository;
        $this->init();
        
    }

    /**
     * upload logo
     * @param Request $request
     * @param Arr $data
     * 
     * @return void
     */
    public function beforeSave(Request $request, Arr $data)
    {
        // upload logo
        $this->uploadImageAttachFile($request, $data, 'logo', 'static/organizations');
    }

}
