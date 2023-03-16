<?php

namespace App\Repositories\Profiles;

use App\Repositories\Base\BaseRepository;

class AcademicRepository extends BaseRepository
{
    /**
     * class chứ các phương thức để validate dử liệu
     * @var string $validatorClass 
     */
    protected $validatorClass = 'App\Validators\Profiles\AcademicValidator';
    /**
     * @var string $resource
     */
    protected $resourceClass = 'App\Http\Resources\AcademicResource';
    /**
     * @var string $collectionClass
     */
    protected $collectionClass = 'App\Http\Resources\AcademicCollection';
    /**
     * get model
     * @return string
     */
    public function getModel()
    {
        return \App\Models\Academic::class;
    }

    public function getOptions($args = [])
    {
        return $this->getDataOptions($args, "Không", 'id', 'title');
    }

    
    
    /**
     * get option
     * @param Request $request
     * @param array $args
     * @return array
     */
    public function getSelectOptions($request, array $args = [])
    {
        return $this->getRequestDataOptions($request, $args, 'Không', 'id', 'title');
    }

}