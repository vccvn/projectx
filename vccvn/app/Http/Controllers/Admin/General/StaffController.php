<?php

namespace App\Http\Controllers\Admin\General;

use Illuminate\Http\Request;
use App\Http\Controllers\Admin\AdminController;

use Crazy\Helpers\Arr;
use App\Repositories\Users\StaffRepository;

class StaffController extends AdminController
{
    protected $module = 'staffs';

    protected $moduleName = 'Người dùng';
    
    protected $flashMode = true;


    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(StaffRepository $StaffRepository)
    {
        $this->repository = $StaffRepository;
        $this->repository->staffQuery();
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

    
    /**
     * can thiệp trước khi luu
     * @param Illuminate\Http\Request $request
     * @param Arr $data dũ liệu đã được validate
     * @return void
     */
    protected function beforeSave(Request $request, $data)
    {
        
        $this->uploadImageAttachFile($request, $data, 'avatar', get_content_path('avatar'));

        if(!$request->id){
            $data->owner_id = $this->repository->getOwnerID();
        }

        $this->data = $data->all();
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
