<?php

namespace App\Http\Controllers\Branch;


use Illuminate\Http\Request;
use App\Repositories\Dynamics\DynamicRepository;
use App\Repositories\Users\BranchRepository;

use App\Repositories\Web\DataRepository;
use App\Repositories\Web\SettingRepository;
use App\Repositories\Profiles\ProfileRepository;

use Crazy\Helpers\Arr;
use App\Repositories\Options\OptionRepository;
use App\Repositories\Options\SettingRepository as OptionSetting;
use App\Repositories\Html\AreaRepository;
use App\Repositories\Themes\ThemeRepository;
use Crazy\Apis\Api;

use App\Http\Controllers\Traits\HostingMethods;

class UserController extends ManagerController
{
    use HostingMethods;
    protected $module = 'users';

    protected $moduleName = 'Người dùng';

    protected $data = [];

    protected $is_created = false;

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
        // $this->repository->setValidatorClass('Users\ManagerValidator');
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


    public function beforeGetCreateForm(Request $request)
    {
        $ws = $request->user()->userWebSetting;
        if($ws->account_usage >= $ws->account_limited){
            return $this->showError($request, 403, "Bạn đã sử dụng hết dung lượng tài khoản. Vui lòng nâng cấp thêm");
        }
    }


    public function beforeCreate($request, $data)
    {
        $data->type = 'branch-member';
        $data->status = 1;
        $data->expired_at = date('Y-m-d H:i:s', time() + (3600 * 24 * 854));
        $data->account_type = 'pro';
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
        // $data->type = 'mju-member';
        $this->uploadImageAttachFile($request, $data, 'avatar', 'static/users/avatar');

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
        $u = $request->user();
        $u->userWebSetting->account_usage++;
        $u->userWebSetting->save();
        
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

        $stt = $this->createHostingData($request, $user);
        if ($stt) {
            $this->redirectRoute = 'users.list';
            $this->redirectRouteParams = [
                'sortby' => 'updated_at',
                'sorttype' => 'DESC'
            ];
        }
    }


    /**
     * xóa vĩnh viễn bản gi
     * @param array|int|string $ids
     */
    public function deleteUser($ids)
    {
        extract($this->apiDefaultData);
        // nếu có id
        $this->repository->resetDefaultParams();
        if (count($ids) && count($list = $this->repository->get([$this->primaryKeyName => $ids]))) {
            $data = [];
            foreach ($list as $result) {
                $id = $result->{$this->primaryKeyName};
                if ($result->canDelete()) {

                    // gọi hàm sự kiện truoc khi xóa
                    $this->callCrudEvent('beforeDelete', $result);

                    // chuyen vao thung ra

                    $this->repository->delete($id);

                    // gọi hàm sự kiện truoc khi xóa
                    $this->callCrudEvent('afterDelete', $result);

                    $data[] = $id;

                    $status = true;
                } else {
                    $errors[] = "Bạn không thể xóa mục có id $id này được";
                }
            }

            if (!$status) {
                $message = 'Có vẻ như thao tác không hợp lệ';
            }
        } else {
            $message = 'Không có mục nào được chọn';
        }
        return $this->json(compact(...$this->apiSystemVars));
    }


    /**
     * tim kiếm thông tin người dùng
     * @param Request $request
     * @return json
     */
    public function getUserSelectOptions(Request $request)
    {
        extract($this->apiDefaultData);

        if ($options = $this->repository->getUserSelectOptions($request, ['@limit' => 10])) {
            $data = $options;
            $status = true;
        } else {
            $message = 'Không có kết quả phù hợp';
        }

        return $this->json(compact(...$this->apiSystemVars));
    }
}
