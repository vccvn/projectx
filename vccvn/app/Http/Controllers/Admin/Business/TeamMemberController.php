<?php

namespace App\Http\Controllers\Admin\Business;

use Illuminate\Http\Request;
use App\Http\Controllers\Admin\AdminController;
use Crazy\Helpers\Arr;

use App\Repositories\Teams\MemberRepository;

class TeamMemberController extends AdminController
{
    protected $module = 'teams.members';

    protected $moduleName = 'Thành viên nhóm';

    protected $flashMode = true;
    
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(MemberRepository $MemberRepository)
    {
        $this->repository = $MemberRepository;
        $this->repository->mode('mask');
        $this->init();
    }

    /**
     * cập nhật thông tin leader
     *
     * @param Request $request
     * @param TeamMember $result
     * @return void
     */
    public function afterAjaxSave(Request $request, $result)
    {
        if($result->is_leader){
            $this->repository->updateTeamLeader($result->team_id, $result->member_id, false);
        }
    }
    

}
