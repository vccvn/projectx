<?php

namespace App\Http\Controllers\Admin\Personal;

use Illuminate\Http\Request;
use App\Http\Controllers\Admin\AdminController;
use Crazy\Helpers\Arr;
use App\Repositories\Profiles\ProfileSkillRepository;

class ProfileSkillController extends AdminController
{
    protected $module = 'profile.skills';

    protected $moduleName = 'Thông tin cá nhân';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(ProfileSkillRepository $profileSkillRepository)
    {
        $this->repository = $profileSkillRepository;
        $this->repository->addFixableParam('profile_id', get_owner_id());
        $this->init();
    }

    /**
     * khoi chay cac thiet lap
     *
     * @return void
     */
    public function start()
    {
        
    }

    /**
     * hiển thị danh sách kỹ năng cá nhân
     *
     * @param Request $request
     * @return void
     */
    public function showSkills(Request $request)
    {
        $actions = ["create", "update", "detail", "delete", "sort"];
        $urls = [];
        foreach ($actions as $act) {
            $urls[$act. '_url'] = $this->getModuleRoute($act);
        }
        $urls['add_url'] = route($this->routeNamePrefix.'skills.add');

        add_js_data('profile_skills', [
            'urls' => $urls
        ]);
        add_js_data('profile_data', [
            'add_work_url' => route($this->routeNamePrefix.'works.add')
        ]);
        
        $skills = $this->getResults($request);
        return $this->view($this->module, compact('skills'));
    }


    /**
     * xử lý thông tin trước khi lưu
     *
     * @param Request $request
     * @param Arr $data
     * @return void
     */
    public function beforeAjaxCreate(Request $request, Arr $data)
    {
        $data->profile_id = $request->user()->id;
    }

    /**
     * sắp xếp lại vị trí sau khi tạo mới
     *
     * @param Request $request
     * @param App\Models\ProfileSkill $result
     * @return void
     */
    public function afterAjaxCreate(Request $request, $result)
    {
        $this->repository->updatePriority($result->id, $result->priority);
    }
    
    public function sortItems(Request $request)
    {
        extract($this->apiDefaultData);

        // validate
        $validator = $this->repository->validator($request, 'Profiles\SortSkillValidator');
        if(!$validator->success()){
            $message = 'Đã có lỗi xảy ra. Vui lòng kiểm tra lại';
            $errors = $validator->errors();
        }
        elseif (!$this->repository->sortItems($request->user()->id, $request->data)) {
            $message = 'Lỗi không xác định. Vui lòng thử lại sau giây láy';
        }
        else{
            $status = true;
        }
        return $this->json(compact(...$this->apiSystemVars));
    }
    
}
