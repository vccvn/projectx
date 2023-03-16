<?php

namespace App\Http\Controllers\Admin\Personal;

use Illuminate\Http\Request;
use App\Http\Controllers\Admin\AdminController;

use App\Repositories\Profiles\AcademicRepository;

class AcademicController extends AdminController
{
    protected $module = 'academics';

    protected $moduleName = 'Học vấn';

    protected $flashMode = true;
    
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(AcademicRepository $academicRepository)
    {
        $this->repository = $academicRepository;
        $this->init();
    }


    /**
     * tim kiếm thông 
     * @param Request $request
     * @return json
     */
    public function getSelectOptions(Request $request)
    {
        extract($this->apiDefaultData);
        if($options = $this->repository->getSelectOptions($request, ['@limit'=>50])){
            $data = $options;
            $status = true;
        }else{
            $message = 'Không có kết quả phù hợp';
        }
        return $this->json(compact(...$this->apiSystemVars));
    }
}
