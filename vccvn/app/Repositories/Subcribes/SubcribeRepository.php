<?php

namespace App\Repositories\Subcribes;

use App\Repositories\Base\BaseRepository;

class SubcribeRepository extends BaseRepository
{
    /**
     * class chứ các phương thức để validate dử liệu
     * @var string $validatorClass 
     */
    protected $validatorClass = 'App\Validators\Subcribes\SubcribeValidator';
    /**
     * @var string $resourceClass
     */
    protected $resourceClass = 'SubcribeResource';
    /**
     * @var string $collectionClass
     */
    protected $collectionClass = 'SubcribeCollection';
    /**
     * get model
     * @return string
     */
    public function getModel()
    {
        return \App\Models\Subcribe::class;
    }

}