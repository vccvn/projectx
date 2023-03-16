<?php

namespace App\Repositories\Teams;

use App\Repositories\Base\BaseRepository;

class MemberRepository extends BaseRepository
{
    /**
     * class chứ các phương thức để validate dử liệu
     * @var string $validatorClass 
     */
    protected $validatorClass = 'App\Validators\Teams\MemberValidator';
    
    /**
     * tên class mặt nạ. Thường có tiền tố [tên thư mục] + \ vá hậu tố Mask
     *
     * @var string
     */
    protected $maskClass = 'Teams\MemberMask';

    /**
     * tên collection mặt nạ
     *
     * @var string
     */
    protected $maskCollectionClass = 'Teams\MemberCollection';

    
    /**
     * @var array $sortByRules kiểu sắp xếp
     */
    protected $sortByRules = [
        1 => 'id-DESC',
        2 => 'users.name-ASC',
        3 => 'users.name-DESC',
        4 => 'is_leader-DESC',
        5 => 'rand()'
    ];



    /**
     * get model
     * @return string
     */
    public function getModel()
    {
        return \App\Models\TeamMember::class;
    }

    /**
     * Cập nhật thông tin nhóm trưởng
     * @param int $team_id
     * @param int $member_id
     * @param bool $check
     * @return bool
     */
    public function updateTeamLeader(int $team_id, int $member_id, $check = true)
    {
        if ($check) {
            $teamLeader = $this->first(compact('team_id', 'member_id'));
            if (!$teamLeader) return false;
            elseif (!$teamLeader->is_leader) {
                $this->update($teamLeader->id, ['is_leader' => 1]);
            }
        }
        if (count($list = $this->where('team_id', $team_id)->where('member_id', '!=', $member_id)->where('is_leader', 1)->get())) {
            foreach ($list as $member) {
                $this->update($member->id, ['is_leader' => 0]);
            }
        }
        return true;
    }

    /**
     * lấy danh sách member
     *
     * @param array $args
     * @return \App\Masks\Teams\MemberCollection
     */
    public function getTeamMembers($args = [])
    {
         // sap xep danh sach
         $a = false;
         foreach (['', 'type', 'Type', '_type'] as $k) {
             if(isset($args['@sort'.$k])){
                 if(!$a){
                     $this->parseSortBy($args['@sort'.$k]);
                     $a = true;
                 }
                 unset($args['@sort'.$k]);
             }    
         }

         $this->join('users', 'users.id', '=', 'team_members.member_id');
         $this->join('teams', 'teams.id', '=', 'team_members.team_id');
         $this->select('team_members.*', 'users.name', 'users.avatar', 'teams.name as team_name');
        //  dump($this);
         return $this->parseCollection($this->get($args));

    }
}
