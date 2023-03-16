<?php

namespace App\Http\Controllers\Admin\Personal;

use Illuminate\Http\Request;
use App\Http\Controllers\Admin\AdminController;
use Crazy\Helpers\Arr;

use App\Repositories\Profiles\EducationRepository;

class ProfileEducationController extends AdminController
{
    protected $module = 'profile.education';

    protected $moduleName = 'Học vấn';

    protected $flashMode = true;
    
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(EducationRepository $EducationRepository)
    {
        $this->repository = $EducationRepository;
        $this->init();
    }

    /**
     * hiển thị danh sách kỹ năng cá nhân
     *
     * @param Request $request
     * @return void
     */
    public function showEducation(Request $request)
    {
        $type = 'education';
        $actions = ["add","create", "update", "detail", "delete", "sort"];
        $urls = [];
        foreach ($actions as $act) {
            $urls[$act. '_url'] = $this->getModuleRoute($act);
        }
 
        add_js_data('profile_experiences', [
            'urls' => $urls,
            'type' => $type
        ]);
        add_js_data('profile_data', [
            'add_organization_url' => route($this->routeNamePrefix.'organizations.add'),
        ]);
        $experiences = $this->getResults($request);
        return $this->view('profile.experiences', compact('experiences', 'type'));
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
        $data->type = 'education';
        if(!$request->id){
            $data->profile_id = $request->user()->id;
        }
    }
    

}
