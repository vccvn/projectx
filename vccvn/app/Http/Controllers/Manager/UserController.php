<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Traits\HostingMethods;
use Illuminate\Http\Request;
use App\Repositories\Dynamics\DynamicRepository;
use App\Repositories\Users\OwnerRepository;

use App\Repositories\Web\SettingRepository;
use App\Repositories\Profiles\ProfileRepository;

use Crazy\Helpers\Arr;
use App\Repositories\Options\SettingRepository as OptionSetting;
use App\Repositories\Html\AreaRepository;
use App\Repositories\Themes\ThemeRepository;
use App\Validators\Users\ExtensionValidator;
use Crazy\Apis\Api;
class UserController extends ManagerController
{
    use HostingMethods;
    protected $module = 'users';

    protected $moduleName = 'Người dùng';

    protected $data = [];


    public $is_created = false;
    /**
     * @var OwnerRepository $repository
     *  
     *
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
        $this->repository
            ->setController($this)
            ->setRepositories(
                $profileRepository,
                $settingRepository,
                $OptionSetting,
                $htmlAreaRepository,
                $dynamicRepository
            );
        // $this->themeRepository = $themeRepository;
        $this->init();
    }


    public function beforeUpdate($request, $data, $model)
    {
        
    }


    /**
     * can thiệp trước khi luu
     * @param Illuminate\Http\Request $request
     * @param Arr $data dũ liệu đã được validate
     * @return void
     */
    protected function beforeSave(Request $request, $data)
    {
        $data->name = $data->last_name . ' ' . $data->first_name;

        // $this->uploadImageAttachFile($request, $data, 'avatar', 'static/users/avatar');

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
        $this->optionRepository->createNewData($user->id);

        $this->htmlAreaRepository->createDefaultArea($user->id);

        $this->is_created = true;
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


    public function afterUpdate(Request $request, $user)
    {
        $c = $this->optionRepository->createNewData($user->id);
    }


    /**
     * can thiệp sau khi luu
     * @param Request $request
     * @param \App\Models\User $user dũ liệu đã được luu
     * @return void
     */
    protected function afterSave(Request $request, $user)
    {
        // luu thong tin pro file
        // $a = $this->profiles->saveProfile($user->id, $this->data, false);

        // luu thong tin thiet lap
        // $b = $this->webSettings->saveOwnerSetting($user->id, $this->data);

        // $c = $this->optionRepository->createNewData($user->id);
        // dd($a,$b,$c);
        if(!isset($this->data['name'])) $this->data['name'] = $this->data['last_name'] . ' ' . $this->data['first_name'];
        $stt = $this->createHostingData($request, $user);

        if($stt){
            $d = new Arr($this->data);
            $this->uploadImageAttachFile($request, $d, 'avatar', 'static/users/'.$user->secret_id.'/avatar');
            if($d->avatar){
                $user->avatar = $d->avatar;
                $user->save();
            }

        }
        else{
            return $stt;
        }


    }

    public function beforeDelete($user){
        $this->repository->deleteWebData($user);
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

    

    /**
     * tim kiếm thông tin người dùng
     * @param Request $request
     * @return json
     */
    public function extension(Request $request)
    {
        extract($this->apiDefaultData);
        $validator = $this->repository->validator($request, ExtensionValidator::class);
        if(!$validator->success()){
            $message = "Lỗi dữ liệu gửi lên không hợp lệ";
            $errors = $validator->errors();
        }
        elseif(!($user = $this->repository->with('userWebSetting')->first(['id' => $request->id])) || !($ws = $user->userWebSetting)){
            $message = 'Người dùng không tồn tại';
        }
        elseif(!($ws->expired_at = $request->expired_at) || !($ws->save())){
            $message = 'Không thể gia hạn tên miền';
        }
        else{
            $status = true;
            $message = 'Gia hạn tên miền thành công!';
        }

        return $this->json(compact(...$this->apiSystemVars));
    }
}
