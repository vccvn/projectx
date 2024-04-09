<?php

namespace App\Http\Controllers\Admin\General;

use Illuminate\Http\Request;
use App\Http\Controllers\Admin\AdminController;

use App\Repositories\Profiles\ProfileRepository;
use Crazy\Helpers\Arr;
use App\Repositories\Users\UserRepository;

class UserController extends AdminController
{
    protected $module = 'users';

    protected $moduleName = 'Người dùng';

    protected $data = [];


    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(UserRepository $UserRepository, protected ProfileRepository $profiles)
    {
        $this->repository = $UserRepository;
        $this->repository->staffQuery();

        // $this->profiles = $profileRepository;


        $this->init();

    }

    /**
     * kiểm tra trước khi lấy thông tin và hiển thị form update
     *
     * @param Request $request
     * @return void
     */
    public function prepareGetUpdateForm(Request $request)
    {
        $owner_id = get_owner_id();
        if($request->id == $owner_id){
            if($owner_id != $request->user()->id){
                echo $this->showError($request, 403, "Bạn không thể cập nhật thông tin người dùng này!")->render();
                die;
            }
        }
    }
    public function beforeGetUpdateForm(Request $request, Arr $config, Arr $inputs, Arr $data , Arr $attribues)
    {
        if(!$data->last_name && !$data->first_name){
            $a = explode(' ', $data->name);
            $data->last_name = array_shift($a);
            $data->first_name = implode(' ', $a);
        }
    }


    /**
     * can thiệp trước khi luu
     * @param Request $request
     * @param Arr $data dũ liệu đã được validate
     * @return void
     */
    protected function beforeSave(Request $request, $data)
    {
        $data->name = $data->last_name . ' ' . $data->first_name;
        $this->uploadImageAttachFile($request, $data, 'avatar', get_content_path('avatar'));

        if(!$request->id){
            $data->owner_id = $this->repository->getOwnerID();
        }

        $this->data = $data->all();
    }



    /**
     * can thiệp sau khi luu
     * @param Illuminate\Http\Request $request
     * @param Model $model dũ liệu đã được luu
     * @return void
     */
    protected function afterSave(Request $request, $model)
    {
        // luu thong tin pro file
        $this->profiles->saveProfile($model->id, $this->data);

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
    public function getUserTagData(Request $request)
    {
        extract($this->apiDefaultData);

        if($options = $this->repository->getUserTagData($request, ['@limit'=>10])){
            $data = $options;
            $status = true;
        }else{
            $message = 'Không có kết quả phù hợp';
        }

        return $this->json(compact(...$this->apiSystemVars));
    }
}
