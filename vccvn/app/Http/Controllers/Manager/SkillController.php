<?php

namespace App\Http\Controllers\Manager;

use Illuminate\Http\Request;
use Crazy\Helpers\Arr;
use App\Repositories\Profiles\SkillRepository;

class SkillController extends ManagerController
{
    protected $module = 'skills';

    protected $moduleName = 'Kỹ năng';

    protected $flashMode = true;
    
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(SkillRepository $skillRepository)
    {
        $this->repository = $skillRepository;
        $this->init();
    }

    public function start()
    {
        add_js_data('profile_works', [
            'urls' => [
                'add_url' => route($this->routeNamePrefix.'works.add')
            ]
        ]);
        add_js_src('static/manager/js/profile.works.js');
    }

}
