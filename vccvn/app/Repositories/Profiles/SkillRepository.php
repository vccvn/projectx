<?php

namespace App\Repositories\Profiles;

use App\Repositories\Base\BaseRepository;

class SkillRepository extends BaseRepository
{
    /**
     * class chứ các phương thức để validate dử liệu
     * @var string $validatorClass 
     */
    protected $validatorClass = 'App\Validators\Profiles\SkillValidator';
    /**
     * @var string $resourceClass
     */
    protected $resourceClass = 'App\Http\Resources\SkillResource';
    /**
     * @var string $collectionClass
     */
    protected $collectionClass = 'App\Http\Resources\SkillCollection';
    /**
     * get model
     * @return string
     */
    public function getModel()
    {
        return \App\Models\Skill::class;
    }

    
    public function init()
    {
        $this->setJoinable([
            ['leftJoin', 'works', 'works.id', '=', 'skills.work_id']
        ]);
        $columns = [
            'work_title' => 'works.title',
            'skill_name' => 'skills.name'
            
        ];
        $this->setSearchable($columns)->setSortable($columns);
        
        $this->setSelectable(['skills.*', 'work_title' => 'works.title']);
    }

    
    
    /**
     * lấy thông tin option
     *
     * @param array $args
     * @return void
     */
    public function getOptions($args = [], $defaultFirst = null)
    {
        return $this->getDataOptions($args, $defaultFirst);
    }

    
    
    /**
     * get option
     * @param Request $request
     * @param array $args
     * @return array
     */
    public function getSelectOptions($request, array $args = [])
    {
        return $this->getRequestDataOptions($request, $args);
    }


}