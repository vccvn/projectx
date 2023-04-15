<?php

namespace App\Http\Controllers\Admin\General;

use Illuminate\Http\Request;
use App\Http\Controllers\Admin\AdminController;
use Crazy\Helpers\Arr;

use App\Repositories\Options\OptionRepository;
use App\Repositories\Options\GroupRepository;
use App\Repositories\Options\DataRepository;

class OptionController extends AdminController
{
    protected $module = 'options';

    protected $moduleName = 'Option';

    protected $flashMode = true;
    
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(OptionRepository $optionRepository, GroupRepository $groupRepository, DataRepository $dataRepository)
    {
        $this->repository = $optionRepository;
        $this->groupRepository = $groupRepository;
        $this->dataRepository = $dataRepository;
        $this->init();
    }

    /**
     * Hiển thị form option
     */
    public function getSettingForm(Request $request, $group = null)
    {
        
    }
}
