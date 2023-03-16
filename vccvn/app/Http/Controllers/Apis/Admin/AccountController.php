<?php

namespace App\Http\Controllers\Apis\Admin;

use App\Http\Controllers\Apis\ApiController;
use App\Models\User;
use Illuminate\Http\Request;

use App\Repositories\Dynamics\DynamicRepository;
use App\Repositories\Options\SettingRepository as OptionSetting;
use App\Repositories\Html\AreaRepository;
use App\Repositories\Web\SettingRepository;
use App\Repositories\Profiles\ProfileRepository;
use App\Repositories\Users\BranchRepository;
use Crazy\Helpers\Arr;

class AccountController extends ApiController
{
    protected $module = 'accounts';

    protected $moduleName = 'Account';

    protected $flashMode = true;


    protected $data = [];

    /**
     * @var User $master
     */
    public $master = null;

    public $is_created = false;
    /**
     * repository chinh
     *
     * @var BranchRepository
     */
    public $repository;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(
        BranchRepository $userRepository,
        ProfileRepository $profileRepository,
        SettingRepository $settingRepository,
        OptionSetting $OptionSetting,
        AreaRepository $htmlAreaRepository,
        DynamicRepository $dynamicRepository
        // ThemeRepository $themeRepository
    ) {
        $this->repository = $userRepository;
        $this->repository->setValidatorClass('Account\ApiAccount');
        $this->repository->enableManagerQuery();
        $this->profiles = $profileRepository;
        $this->webSettings = $settingRepository;
        $this->optionRepository = $OptionSetting;
        $this->htmlAreaRepository = $htmlAreaRepository;
        $this->dynamicRepository = $dynamicRepository;
        // $this->themeRepository = $themeRepository;
        $this->repository
            ->setController($this)
            ->setRepositories(
                $profileRepository, 
                $settingRepository, 
                $OptionSetting, 
                $htmlAreaRepository, 
                $dynamicRepository
            );
        $this->init();
    }




    /**
     * xử lý dữ liệu
     * @param Request $request
     * 
     * @return mixed
     */
    public function checkData(Request $request)
    {
        extract($this->apiDefaultData);

        $this->callCrudEvent('beforeValidate', $request);
        // validate
        $validator = $this->repository->validator($request);
        if (!$validator->success()) {
            $message = 'Đã có lỗi xảy ra. Vui lòng kiểm tra lại';
            $errors = $validator->errors();
        } else {
            // tao doi tuong data de de truy cap phan tu
            $data = new Arr($validator->inputs());
            // goi cac ham su kien truoc khi luu
            // $res = $this->callCrudEvent('done', $request, $data);
            $status = true;
            // $data = $res;
        }
        return $this->json(compact(...$this->apiSystemVars));
    }


    public function beforeCreate(Request $request, Arr $data)
    {
        $data->master_id = $this->master->id;
        if(!$data->storage_limited) $data->storage_limited = 500; 
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
        $data->username = $this->repository->getUsernameByEmail($data->email);
        // $this->uploadImageAttachFile($request, $data, 'avatar', 'static/users/0/avatar');

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
        $this->is_created = true;
        $this->htmlAreaRepository->createDefaultArea($user->id);

        if($request->update_owner_settings){
            $this->webSettings->saveOwnerSetting($user->id, $this->data);
        }
        $this->master->userWebSetting->account_usage++;
        $this->master->userWebSetting->save();
        

    }



    /**
     * can thiệp sau khi luu
     * @param Illuminate\Http\Request $request
     * @param \App\Models\User $user dũ liệu đã được luu
     * @return void
     */
    protected function afterSave(Request $request, $user)
    {
        return $this->repository->createOwnerData($user, $this->data, $this->is_created);
    }

    public function upgrade(Request $request)
    {
        // return $request->all();
        extract($this->apiDefaultData);

        $validator = $this->repository->validator($request, 'Account\Upgrade');
        if (!$validator->success()) {
            $errors = $validator->errors();
        } elseif (!($user = $this->repository->update($request->account_id, ['status' => 1]))) {
            $message = 'Tài khoản không tồn tại';
        } else {
            $this->webSettings->saveOwnerSetting($user->id, $validator->inputs());
            $status = true;
            $message = 'Gia hạn thành công';
        }

        return $this->json(compact(...$this->apiSystemVars));
    }

    public function extension(Request $request)
    {
        extract($this->apiDefaultData);

        $validator = $this->repository->validator($request, 'Account\Extension');
        if (!$validator->success()) {
            $errors = $validator->errors();
        } elseif (!($user = $this->repository->findBy('id', $request->id))) {
            $message = 'Tài khoản không tồn tại';
        } else {
            $this->webSettings->saveOwnerSetting($user->id, $validator->inputs());
            $status = true;
            $message = 'Gia hạn thành công';
        }

        return $this->json(compact(...$this->apiSystemVars));
    }

}
