<?php

namespace App\Repositories\Profiles;

use App\Repositories\Base\BaseRepository;

class WorkRepository extends BaseRepository
{

    
    /**
     * class chứ các phương thức để validate dử liệu
     * @var string $validatorClass 
     */
    protected $validatorClass = 'App\Validators\Profiles\WorkValidator';


    /**
     * get model
     * @return string
     */
    public function getModel()
    {
        return \App\Models\Work::class;
    }



    /**
     * lấy thông tin option
     *
     * @param array $args
     * @return array
     */
    public function getOptions($args = [], $defaultFirst = 'Không')
    {
        return $this->getDataOptions($args, $defaultFirst, 'id', 'title');
    }

    
    
    /**
     * get option
     * @param Request $request
     * @param array $args
     * @return array
     */
    public function getSelectOptions($request, array $args = [])
    {
        return $this->getRequestDataOptions($request, $args, null, 'id', 'title');
    }

}