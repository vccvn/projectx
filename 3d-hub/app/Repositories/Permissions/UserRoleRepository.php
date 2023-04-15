<?php

namespace App\Repositories\Permissions;

use App\Repositories\Base\BaseRepository;

class UserRoleRepository extends BaseRepository
{
    /**
     * class chứ các phương thức để validate dử liệu
     * @var string $validatorClass 
     */
    protected $validatorClass = 'App\Validators\Permissions\UserRoleRValidator';
    
    /**
     * get model
     * @return string
     */
    public function getModel()
    {
        return \App\Models\PermissionUserRole::class;
    }

    /**
     * lấy các role id của một module nào đó
     * @param int $role_id
     * @return array
     */
    public function getUserRoleChecked($role_id = 0)
    {
        $data = [];
        if($role_id && $users = $this->getBy('role_id', $role_id)){
            foreach ($users as $key => $user) {
                $data[] = $user->role_id;
            }
        }
        return $data;
    }
    
    /**
     * cập nhật danh sách quyển cho module
     * @param int $role_id
     * @param array $user_id_list
     * @return void
     */
    public function updateUserRole(int $role_id, array $user_id_list = [])
    {
        $ingore = [];
        if(count($users = $this->getBy('role_id', $role_id))){
            foreach ($users as $user) {
                // nếu role nằm trong số id them thì bỏ qua
                if(in_array($user->user_id, $user_id_list)) $ingore[] = $user->user_id;
                // nếu ko thì xóa
                else $user->delete();
            }
        }
        if(count($user_id_list)){
            foreach ($user_id_list as $user_id) {
                if(!in_array($user_id, $ingore)){
                    // nếu ko nằm trong danh sách bỏ qua thì ta thêm mới
                    $this->save(compact('user_id', 'role_id'));
                }
            }
        }
    }
}