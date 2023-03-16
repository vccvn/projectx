<?php

namespace App\Repositories\Profiles;

use App\Repositories\Base\BaseRepository;

class ExperienceRepository extends BaseRepository
{
    /**
     * class chứ các phương thức để validate dử liệu
     * @var string $validatorClass 
     */
    protected $validatorClass = 'Profiles\ExperienceValidator';
    /**
     * @var string $resource
     */
    protected $resourceClass = 'ExperienceResource';
    /**
     * @var string $collectionClass
     */
    protected $collectionClass = 'ExperienceCollection';
    /**
     * get model
     * @return string
     */
    public function getModel()
    {
        return \App\Models\Experience::class;
    }

}