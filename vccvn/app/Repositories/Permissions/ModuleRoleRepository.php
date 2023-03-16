<?php

namespace App\Repositories\Permissions;

use App\Repositories\Base\BaseRepository;

class ModuleRoleRepository extends BaseRepository
{

    /**
     * get model
     * @return string
     */
    public function getModel()
    {
        return \App\Models\PermissionModuleRole::class;
    }

    /**
     * lấy các role id của một module nào đó
     * @param int $module_id
     * @return array
     */
    public function getModuleRoleChecked($module_id = 0)
    {
        $data = [];
        if($module_id && $roles = $this->getBy('module_id', $module_id)){
            foreach ($roles as $key => $moduleRole) {
                $data[] = $moduleRole->role_id;
            }
        }
        return $data;
    }
    
    /**
     * cập nhật danh sách quyển cho module
     * @param int $module_id
     * @param array $role_id_list
     * @return void
     */
    public function updateModuleRoles(int $module_id, array $role_id_list = [])
    {
        $ingore = [];
        if(count($roles = $this->getBy('module_id', $module_id))){
            foreach ($roles as $role) {
                // nếu role nằm trong số id them thì bỏ qua
                if(in_array($role->role_id, $role_id_list)) $ingore[] = $role->role_id;
                // nếu ko thì xóa
                else $role->delete();
            }
        }
        if(count($role_id_list)){
            foreach ($role_id_list as $role_id) {
                if(!in_array($role_id, $ingore)){
                    // nếu ko nằm trong danh sách bỏ qua thì ta thêm mới
                    $this->save(compact('module_id', 'role_id'));
                }
            }
        }
    }

    
}