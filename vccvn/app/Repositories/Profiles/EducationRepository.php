<?php

namespace App\Repositories\Profiles;

use App\Repositories\Base\BaseRepository;

class EducationRepository extends BaseRepository
{
    /**
     * class chứ các phương thức để validate dử liệu
     * @var string $validatorClass 
     */
    protected $validatorClass = 'App\Validators\Profiles\EducationValidator';
    
    /**
     * tên class mặt nạ. Thược có tiền tố [tên thư mục] + \ vá hậu tố Mask
     *
     * @var string
     */
    protected $maskClass = 'Experiences\ExperienceMask';

    /**
     * tên collection mặt nạ
     *
     * @var string
     */
    protected $maskCollectionClass = 'Experiences\ExperienceCollection';

    /**
     * get model
     * @return string
     */
    public function getModel()
    {
        return \App\Models\Experience::class;
    }

    public function init()
    {
        $this->addDefaultParam('type', 'type', 'education');
        $this->addDefaultValue('type', 'education');
        if($profile_id = get_owner_id()){
            $this->addDefaultParam('profile_id', 'profile_id', $profile_id);
        }
        $this->setJoinable([
            ['leftJoin', 'organizations', 'organizations.id', '=', 'experiences.org_id']
        ])->setSelectable(['experiences.*', 'org_name' => 'organizations.name']);

        $this->mode('mask');
        $this->defaultSortBy = [
            'experiences.finished_at' => 'DESC',
            'experiences.started_at'  => 'DESC',
            'experiences.id'          => 'DESC'
        ];
    }

    
    public function getExperiences($args = [])
    {
        $this->buildJoin();
        $this->buildSelect();
        $this->buildGroupBy();
        $args['@order_by'] = [
            'experiences.finished_at' => 'DESC',
            'experiences.started_at'  => 'DESC',
            'experiences.id'          => 'DESC'
        ];
        return $this->parseCollection($this->get($args));
    }

}