<?php

namespace App\Repositories\Teams;

use App\Repositories\Base\BaseRepository;

class TeamRepository extends BaseRepository
{
    /**
     * class chứ các phương thức để validate dử liệu
     * @var string $validatorClass 
     */
    protected $validatorClass = 'App\Validators\Teams\TeamValidator';
    /**
     * @var string $resourceClass
     */
    protected $resourceClass = 'TeamResource';
    /**
     * @var string $collectionClass
     */
    protected $collectionClass = 'TeamCollection';


    /**
     * tên class mặt nạ. Thường có tiền tố [tên thư mục] + \ vá hậu tố Mask
     *
     * @var string
     */
    protected $maskClass = 'Teams\TeamMask';

    /**
     * tên collection mặt nạ
     *
     * @var string
     */
    protected $maskCollectionClass = 'Teams\TeamCollection';

    /**
     * get model
     * @return string
     */
    public function getModel()
    {
        return \App\Models\Team::class;
    }

}