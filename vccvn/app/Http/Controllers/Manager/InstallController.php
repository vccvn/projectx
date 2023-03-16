<?php

namespace App\Http\Controllers\Manager;


use App\Http\Controllers\Traits\HostingMethods;
use App\Models\User;
use Illuminate\Http\Request;
use App\Repositories\Dynamics\DynamicRepository;
use App\Repositories\Users\OwnerRepository;

use App\Repositories\Web\DataRepository;
use App\Repositories\Web\SettingRepository;
use App\Repositories\Profiles\ProfileRepository;

use Crazy\Helpers\Arr;
use App\Repositories\Options\SettingRepository as OptionSettings;
use App\Repositories\Html\AreaRepository;
use App\Repositories\Themes\ThemeRepository;


class InstallController extends ManagerController
{


    use HostingMethods;
    protected $module = 'install';

    protected $moduleName = 'Người dùng';

    protected $data = [];


    public $is_created = false;
    /**
     * repository chinh
     *
     * @var OwnerRepository
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
        OptionSettings $OptionSettings,
        AreaRepository $htmlAreaRepository,
        DynamicRepository $dynamicRepository
        // ThemeRepository $themeRepository
    ) {
        $this->repository = $userRepository;
        $this->repository->setValidatorClass('Users\AdminValidator');
        $this->repository->enableManagerQuery();
        $this->profiles = $profileRepository;
        $this->webSettings = $settingRepository;
        $this->optionRepository = $OptionSettings;
        $this->htmlAreaRepository = $htmlAreaRepository;
        $this->dynamicRepository = $dynamicRepository;
        $this->repository
            ->setController($this)
            ->setRepositories(
                $profileRepository,
                $settingRepository,
                $OptionSettings,
                $htmlAreaRepository,
                $dynamicRepository
            );
        // $this->themeRepository = $themeRepository;
        $this->init();
    }


    public function installForm()
    {
        return $this->viewModule('index');
    }

    /**
     * lấy mảng thông tin khởi tạo
     *
     * @param array $data
     * @return array
     */
    public function getDataDefault($data = [])
    {
        $data['username'] = $this->repository->getUsernameByEmail($data['email']);
        $data = array_merge($data, [
            "type" => "admin",
            "status" => 1,
            "account_type" => "max",
            "expired_at" => date('Y-m-d H:i:s', time() + 60 * 60 * 24 * 365 * 10 + 60 * 60 * 24 * 2),
            "web_type" => "default",
            "subdomain" => $data['username'],
            "base_domain" => get_cfg_domain(),
            "name" => $data['username']
        ]);
        return $data;
    }

    /**
     * tạo user
     *
     * @param array $data
     * @return User|null
     */
    public function createUser($data)
    {
        $user = $this->repository->create($data);
        if ($user) {
            $this->optionRepository->createNewData($user->id);
            $this->htmlAreaRepository->createDefaultArea($user->id);
        }
        return $user;
    }

    /**
     * đăng nhập
     * @param Request
     * @return json
     */
    public function createInstall(Request $request)
    {
        extract($this->apiDefaultData);

        $validator = $this->repository->validator($request, 'Users/Admin');
        if (!$validator->success()) {
            $message = "Thông tin không hợp lệ!";
            $errors = $validator->errors();
        } elseif (!($inputData = $this->getDataDefault($validator->inputs())) || !($user = $this->createUser($inputData))) {
            $message = "Không thể tạo thông tin user";
        } elseif (!$this->repository->createOwnerData($user, $inputData, true)) {
            $message = 'Lỗi không xác định';
        } else {
            $data = ['redirect' => route('home')];
            $status = true;
            $message = 'Thiết lập thành công';
        }
        return $this->json(compact(...$this->apiSystemVars));
    }
}
