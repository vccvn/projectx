<?php

namespace App\Http\Controllers\Manager;

use Illuminate\Http\Request;

use App\Repositories\Users\OwnerRepository;

use App\Repositories\Web\DataRepository;
use App\Repositories\Web\SettingRepository;
use App\Repositories\Profiles\ProfileRepository;

use Crazy\Helpers\Arr;
use App\Repositories\Options\OptionRepository;
use App\Repositories\Options\SettingRepository as OptionSetting;
use App\Repositories\Html\AreaRepository;

class UpdateFeatureController extends ManagerController
{
    protected $module = 'users';

    protected $moduleName = 'Người dùng';
    
    protected $data = [];

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(OwnerRepository $userRepository, ProfileRepository $profileRepository, SettingRepository $settingRepository, OptionSetting $OptionSetting, AreaRepository $htmlAreaRepository)
    {
        $this->repository = $userRepository;
        // $this->repository->setValidatorClass('Users\ManagerValidator');
        $this->repository->enableManagerQuery();
        $this->profiles = $profileRepository;
        $this->webSettings = $settingRepository;
        $this->optionRepository = $OptionSetting;
        $this->htmlAreaRepository = $htmlAreaRepository;
        $this->init();
    }

    public function updateFeatures(Request $request)
    {
        
        $this->repository->chunkById(200, function($owners){
            foreach ($owners as $owner) {
                $this->htmlAreaRepository->createDefaultArea($owner->id);
            }
        });
    }
}
