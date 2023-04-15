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
    public function __construct(UserRepository $UserRepository)
    {
        $this->repository = $UserRepository;
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
        $this->uploadImageAttachFile($request, $data, 'avatar', 'static/users/avatar');

        // $this->data = $data->all();
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
        // $this->profiles->saveProfile($model->id, $this->data);

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
