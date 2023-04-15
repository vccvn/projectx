<?php

namespace App\Http\Controllers\Admin\Personal;

use Illuminate\Http\Request;
use App\Http\Controllers\Admin\AdminController;
use Crazy\Helpers\Arr;
use App\Repositories\Profiles\ProfileRepository;
use App\Repositories\Users\OwnerRepository;

class ProfileController extends AdminController
{
    protected $module = 'profile';

    protected $moduleName = 'Thông tin cá nhân';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(ProfileRepository $profileRepository, OwnerRepository $ownerRepository)
    {
        $this->repository = $profileRepository;
        $this->ownerRepository = $ownerRepository;
        $this->init();
    }

    /**
     * khoi chay cac thiet lap
     *
     * @return void
     */
    public function start()
    {
        $this->redirectRoute = $this->routeNamePrefix.$this->module . '.general';
        $this->submitRoute = $this->routeNamePrefix.$this->module . '.general.handle';

        add_js_data('profile_data', [
            'add_work_url'                 => route($this->routeNamePrefix.'works.add'),
            'add_organization_url'         => route($this->routeNamePrefix.'organizations.add'),
            'add_academic_url'             => route($this->routeNamePrefix.'academics.add'),
            
        ]);
        add_js_src(
            'manager/js/profile.works.js', 
            'manager/js/profile.organizations.js', 
            'manager/js/profile.academics.js'
        );
    }



    /**
     * hien thi form chinh sua
     *
     * @param Request $request
     * @return void
     */
    public function getProfileForm(Request $request)
    {
        return $this->getForm($request, ['type' => 'free'], $request->user()->profile);
    }


    /**
     * su kien xu ly xong
     *
     * @param Request $request
     * @param Arr $data
     * @return void
     */
    public function done(Request $request, Arr $data)
    {
        $user = $request->user();
        $this->uploadImageAttachFile($request, $data, 'avatar', 'static/users/avatar');
        $update = [];
        if($data->avatar){
            $update = ['avatar' => $data->avatar];
        }
        $update['name'] = $data->last_name . ' ' . $data->first_name;

        $this->ownerRepository->update($user->id, $update);
        // luu thong tin profile
        $this->repository->saveProfile($user->id, $data->all());
        
    }

    
    
    
}
