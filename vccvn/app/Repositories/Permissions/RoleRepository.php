<?php

namespace App\Repositories\Permissions;

use App\Repositories\Base\BaseRepository;

class RoleRepository extends BaseRepository
{
    
    /**
     * class chứ các phương thức để validate dử liệu
     * @var string $validatorClass 
     */
    protected $validatorClass = 'App\Validators\Permissions\RoleValidator';


    /**
     * @var string $resourceClass
     */
    protected $resourceClass = 'App\Http\Resources\RoleResource';

    /**
     * @var string $collectionClass
     */
    protected $collectionClass = 'App\Http\Resources\RoleCollection';



    /**
     * @var string $system
     */
    protected $system = 'both';

    /**
     * get model
     * @return string
     */
    public function getModel()
    {
        return \App\Models\PermissionRole::class;
    }

    /**
     * lấy danh sách role option
     * @return array
     */
    public function getRoleOptions()
    {
        $data = [];
        if($list = $this->orderBy('level', 'ASC')->get()){
            foreach ($list as $role) {
                $data[$role->id] = $role->name;
            }
        }
        return $data;
    }

    /**
     * lay sanh sach check list hoac select
     * @return array
     */
    public static function getOptions()
    {
        return (new static())->getRoleOptions();
    }
}