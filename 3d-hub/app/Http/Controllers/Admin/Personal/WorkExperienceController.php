<?php

namespace App\Http\Controllers\Admin\Personal;

use Illuminate\Http\Request;
use App\Http\Controllers\Admin\AdminController;
use Crazy\Helpers\Arr;

use App\Repositories\Profiles\WorkExperienceRepository;

class WorkExperienceController extends AdminController
{
    protected $module = 'profile.experiences';

    protected $moduleName = 'Kinh Nghiệm làm việc';

    protected $flashMode = true;
    
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(WorkExperienceRepository $WorkExperienceRepository)
    {
        $this->repository = $WorkExperienceRepository;
        $this->init();
    }

    
    /**
     * hiển thị danh sách kỹ năng cá nhân
     *
     * @param Request $request
     * @return void
     */
    public function showExperiences(Request $request)
    {
        $type = 'work';
        $actions = ["add", "create", "update", "detail", "delete", "sort"];
        $urls = [];
        foreach ($actions as $act) {
            $urls[$act. '_url'] = $this->getModuleRoute($act);
        }

        add_js_data('profile_experiences', [
            'urls' => $urls,
            'type' => $type
        ]);
        add_js_data('profile_data', [
            'add_work_url' => route($this->routeNamePrefix.'works.add'),
            'add_organization_url' => route($this->routeNamePrefix.'organizations.add'),
        ]);
        $experiences = $this->getResults($request);
        return $this->view($this->module, compact('experiences', 'type'));
    }


    
    /**
     * xử lý thông tin trước khi lưu
     *
     * @param Request $request
     * @param Arr $data
     * @return void
     */
    public function beforeAjaxSave(Request $request, Arr $data)
    {
        $date = new Arr(web_cfg('profile.date'));
        $data->has_finish_date = $data->has_start_date ? $data->has_finish_date : 0;
        $data->started_at = $data->has_start_date ? $data->started : $date->start;
        $data->finished_at = $data->has_finish_date ? $data->finished : $date->finish;
        $data->type = 'work';
        if(!$request->id){
            $data->profile_id = $request->user()->id;
        }
    }
    
}
