<?php

namespace App\Repositories\Profiles;

use App\Repositories\Base\BaseRepository;

class ProfileSkillRepository extends BaseRepository
{
    /**
     * class chứ các phương thức để validate dử liệu
     * @var string $validatorClass 
     */
    protected $validatorClass = 'App\Validators\Profiles\ProfileSkillValidator';
    /**
     * @var string $resource
     */
    protected $resourceClass = 'App\Http\Resources\ProfileSkillResource';
    /**
     * @var string $collectionClass
     */
    protected $collectionClass = 'App\Http\Resources\ProfileSkillCollection';


    /**
     * @var string
     */
    protected $maskClass = 'Profiles\ProfileSkillMask';

    /**
     * @var string
     */
    protected $maskCollectionClass = 'Profiles\ProfileSkillCollection';


    protected $paginate = null;

    /**
     * get model
     * @return string
     */
    public function getModel()
    {
        return \App\Models\ProfileSkill::class;
    }

    public function init(){
        $this->setJoinable([
            ['leftJoin', 'skills', 'skills.id', '=', 'profile_skills.skill_id'],
            ['leftJoin', 'works', 'skills.work_id', '=', 'works.id'],
            
        ]);
        $this->setSelectable(['skills.name', 'skills.type', 'work_title' => 'works.title', 'profile_skills.*']);
        $this->defaultSortBy = ['profile_skills.priority' => 'ASC'];
    }

    
    public function getSkills($args = [])
    {
        $this->responseMode = 'mask';
        $this->buildJoin();
        $this->buildSelect();
        $this->buildGroupBy();
        $this->where('profile_skills.profile_id', get_owner_id());
        return $this->parseCollection($this->get($args));
    }


    
    /**
     * lấy thông tin options
     *
     * @param array $args
     * @return array
     */
    public function getProfileSkillOptions($args = [])
    {
        $this->join('skills', 'skills.id', '=', 'profile_skills.skill_id');
        $this->where('profile_skills.profile_id', get_owner_id())->select('skills.name', 'profile_skills.id');
        $data = [];
        if(count($skills = $this->get($args))){
            foreach ($skills as $skill) {
                $data[$skill->id] = $skill->name;
            }
        }
        return $data;
    }


    /**
     * sap xep lai thu tu
     * @param integer $skill_id
     * @param integer $priority
     * @return void
     */
    public function updatePriority($id, $priority=0)
    {
        // nếu tìm không thấy profile_skill_id thì trả về false luôn
        if(!($profileSkill = $this->find($id))) return false;
        $c = $this->countBy('profile_id',$profileSkill->profile_id);
        if($profileSkill->priority==0 || $priority == 0){
            if($profileSkill->priority==0){
                $profileSkill->priority = $c;
                $profileSkill->save();
                return true;
            }
            return $this->updatePriority($id, $c);
        }
        // nếu thứ tữ khác 0 và khác thứ tự cụ
        if($priority != $profileSkill->priority){
            // nếu thứ tự lớn hơn tổng số thì gán thứ tự bằng tổng số
            if($priority > $c) $priority = $c;
            
            // xử lý trường hợp thay đổi vị trí trong khoảng 0 < priority < max

            $query = $this->newRepo()->where('profile_id',$profileSkill->profile_id)->where('id', '!=', $profileSkill->id);
            
            // vị trí bắt đầu
            $begin = ($priority<$profileSkill->priority)?$priority:$profileSkill->priority;
            // vị trí kết thúc
            $end = ($priority>$profileSkill->priority)?$priority:$profileSkill->priority;    
            
            $query->whereBetween('priority',[$begin,$end]);
            
            if($list = $query->get()){
                if($priority > $profileSkill->priority){
                    foreach($list as $item){
                        $item->priority = $item->priority - 1;
                        $item->save();
                    }
                    
                }
                else{
                    foreach($list as $item){
                        $item->priority = $item->priority + 1;
                        $item->save();
                    }
                }   
            }
            $profileSkill->priority = $priority;
            $profileSkill->save();
            return true;
        }
        return false;
    }

    /**
     * sửa thứ tự hiển thị
     *
     * @param int $profile_id
     * @return void
     */
    public function repairPriority($profile_id)
    {
        if(( $max = count($list = $this->orderBy('priority','DESC')->get(['profile_id' => $profile_id])) ) > 0){
            // nếu có danh sách sẽ duyệt qua và sap91 xep71 từ cao đến thấp 
            foreach($list as $item){
                if($item->priority>$max){
                    $item->priority = $max;
                    $item->save();
                }
                $max--;
            }
        }
    }

    /**
     * sap xep 
     *
     * @param integer $profile_id
     * @param array $items
     * @return bool
     */
    public function sortItems(int $profile_id, array $items = [])
    {
        $status = true;
        if(count($list = $this->get(['profile_id' => $profile_id]))){
            foreach ($list as $skill) {
                if(!array_key_exists($skill->id, $items)){
                    $skill->delete();
                }elseif ($skill->priority != $items[$skill->id]) {
                    $skill->priority = $items[$skill->id];
                    $skill->save();
                }
            }
        }else{
            $status = false;
        }
        return $status;
    }

    
}