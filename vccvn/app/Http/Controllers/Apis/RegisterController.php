<?php

namespace App\Http\Controllers\Apis;

use App\Http\Controllers\Apis\ApiController;
use App\Repositories\Dynamics\DynamicRepository;
use Illuminate\Http\Request;

use App\Repositories\Users\OwnerRepository;

use App\Repositories\Web\SettingRepository;
use App\Repositories\Profiles\ProfileRepository;

use Crazy\Helpers\Arr;
use App\Repositories\Options\SettingRepository as OptionSetting;
use App\Repositories\Html\AreaRepository;
use App\Repositories\Themes\ThemeRepository;


class RegisterController extends ApiController
{
    protected $module = 'registers';

    protected $moduleName = 'Register';

    protected $flashMode = true;

    /**
     * repository chinh
     *
     * @var UserRepository
     */
    public $repository;
   
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(
        OwnerRepository $userRepository, 
        ProfileRepository $profileRepository, 
        SettingRepository $settingRepository, 
        OptionSetting $OptionSetting, 
        AreaRepository $htmlAreaRepository,
        DynamicRepository $dynamicRepository
        // ThemeRepository $themeRepository
    )
    {
        $this->repository = $userRepository;
        // $this->repository->setValidatorClass('Users\ManagerValidator');
        $this->repository->enableManagerQuery();
        $this->profiles = $profileRepository;
        $this->webSettings = $settingRepository;
        $this->optionRepository = $OptionSetting;
        $this->htmlAreaRepository = $htmlAreaRepository;
        $this->dynamicRepository = $dynamicRepository;
        // $this->themeRepository = $themeRepository;
        $this->init();
    }



    
    /**
     * can thiệp trước khi luu
     * @param Illuminate\Http\Request $request
     * @param Arr $data dũ liệu đã được validate
     * @return void
     */
    protected function beforeSave(Request $request, $data)
    {
        // $data->name = $data->last_name . ' ' . $data->first_name;
        
        $this->uploadImageAttachFile($request, $data, 'avatar', get_content_path('avatar'));

        $this->data = $data->all();
    }

    /**
     * bat su kien sau khi tao moi
     * @param Request $request
     * @param \App\Models\User $user
     */
    public function afterCreate(Request $request, $user)
    {
        // tao moi du lieu mac dinh
        // $this->optionRepository->createNewData($user->id);

        $this->htmlAreaRepository->createDefaultArea($user->id);

        // // tạo ra một trang đăng bài mặc định
        // $this->dynamicRepository->create([
        //     'name' => 'Blog',
        //     'slug' => 'blog',
        //     'content' => 'Trang Blog',
        //     'owner_id' => $user->id
        // ]);
        ThemeRepository::addOwnerID($user->id);
        // $this->themeRepository->setOwnerID();
        $themeRepository = new ThemeRepository();
        $themeRepository->activeDefault($user->id);
    }



    /**
     * can thiệp sau khi luu
     * @param Illuminate\Http\Request $request
     * @param \App\Models\User $user dũ liệu đã được luu
     * @return void
     */
    protected function afterSave(Request $request, $user)
    {
        // luu thong tin pro file
        $this->profiles->saveProfile($user->id, $this->data, false);

        // luu thong tin thiet lap
        $this->webSettings->saveOwnerSetting($user->id, $this->data);
        
        $this->optionRepository->createNewData($user->id);
        
        
    }


    /**
     * tim kiếm thông tin người dùng 
     * @param Request $request
     * @return json
     */
    public function getUserSelectOptions(Request $request)
    {
        extract($this->apiDefaultData);

        if($options = $this->repository->getUserSelectOptions($request, ['@limit'=>10])){
            $data = $options;
            $status = true;
        }else{
            $message = 'Không có kết quả phù hợp';
        }

        return $this->json(compact(...$this->apiSystemVars));
    }
}
