<?php

namespace App\Http\Controllers\Manager;

use Illuminate\Http\Request;

use App\Repositories\Profiles\WorkRepository;


class WorkController extends ManagerController
{
    protected $module = 'works';

    protected $moduleName = 'Nghề nghiệp';

    protected $flashMode = true;
    
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(WorkRepository $workRepository)
    {
        $this->repository = $workRepository;
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
