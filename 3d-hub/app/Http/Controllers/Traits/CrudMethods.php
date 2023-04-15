<?php

namespace App\Http\Controllers\Traits;

use Crazy\Helpers\Arr;
use Illuminate\Http\Request;
// use Crazy\Html\HTML;


use Crazy\Laravel\Router;


/**
 * các thuộc tính và phương thức của form sẽ được triển trong ManagerController / hoặc admin controller
 *
 * @method void beforeSaveValidate( Request $request )
 * @method void beforeAjaxValidate( Request $request )
 * @method void beforeCreateValidate( Request $request )
 * @method void beforeAjaxCreateValidate( Request $request )
 * @method void beforeStoreValidate( Request $request )
 * @method void beforeUpdateValidate( Request $request )
 * @method void beforeAjaxUpdateValidate( Request $request )
 * @method void beforeValidate( Request $request )
 * @method void beforeAjaxValidate( Request $request )
 * @method void beforeHandleValidate( Request $request )
 * 
 * @method void beforeSave( Request $request, Arr $data ) 
 * @method void beforeAjaxSave( Request $request, Arr $data ) 
 * @method void beforeCreate( Request $request, Arr $data ) 
 * @method void beforeAjaxCreate( Request $request, Arr $data ) 
 * @method void beforeStore( Request $request, Arr $data ) 
 * @method void beforeUpdate( Request $request, Arr $data )
 * @method void beforeAjaxUpdate( Request $request, Arr $data )
 * @method void beforeMoveToTrash( Request $request, Arr $data ) 
 * @method void beforeRestore( Request $request)
 * @method void beforeDelete( \App\Models\Model $result)
 * 
 * @method void afterSave( Request $request, \App\Models\Model $result )
 * @method void afterAjaxSave( Request $request, \App\Models\Model $result )
 * @method void afterCreate( Request $request, \App\Models\Model $result ) 
 * @method void afterAjaxCreate( Request $request, \App\Models\Model $result ) 
 * @method void afterStore( Request $request, \App\Models\Model $result ) 
 * @method void afterUpdate( Request $request, \App\Models\Model $result ) 
 * @method void afterAjaxUpdate( Request $request, \App\Models\Model $result ) 
 * @method void afterMoveToTrash( Request $request, \App\Models\Model $result ) 
 * @method void afterRestore( Request $request, \App\Models\Model $result )
 * @method void afterDelete( Request $request, \App\Models\Model $result )
 * 
 * @method mixed done( Request $request, Arr $data )
 */
trait CrudMethods
{
   
    /**
     * route chuyển hướng sau khi lưu
     * @var string $redirectRoute
     */
    protected $redirectRoute = null;

    /**
     * @var array $redirectRouteParams
     */
    protected $redirectRouteParams = [];



    /**
     * @var string $primaryKeyName ten khoa chinh
     */
    protected $primaryKeyName = 'id';

    /**
     * @var array $apiDefaultData đử liệu mặc định trả về api
     * 
     */
    protected $apiDefaultData = [
        'status' => false,
        'message' => 'Thao tác thành công!',
        'data' => null,
        'errors' => []
    ];


    /**
     * danh sách trả về9
     * @var array $apiSystemVars
     */
    protected $apiSystemVars = ['status', 'data','message', 'errors'];

    
    protected $crudAction = null;

    /**
     * lưu dữ liệu bao gồm cập nhật hoặc tạo mới
     * @param Request $request
     * 
     * @return redirect
     */
    public function crudInit()
    {
        if($this->repository) $this->primaryKeyName = $this->repository->getKeyName();
        // do some thing
    }

    /**
     * bắt sự kiện
     * @param string $event
     * @param array ...$params
     * @return mixed
     */
    public final function callCrudEvent(string $event, ...$params)
    {
        if(method_exists($this, $event)){
            return call_user_func_array([$this, $event], $params);
        }
        return null;
    }



    /**
     * luu data tao moi
     * @param Illuminate\Http\Request $request
     */
    public function create(Request $request)
    {
        return $this->save($request);
    }

    
    /**
     * luu data cap nhat
     * @param Illuminate\Http\Request $request
     * @param int $id
     */
    public function update(Request $request, $id = null)
    {
        return $this->save($request, $id);
    }

    /**
     * lấy id của request
     * @param Request $request
     * @return array
     */
    public function getIdListFromRequest(Request $request)
    {
        $ids = [];
        $listKey = ['id', 'ids'];
        if($this->primaryKeyName != 'id'){
            $listKey[] = $this->primaryKeyName;
        }
        foreach ($listKey as $key) {
            if($list = $request->input($key)){
                if(is_array($list)) $ids = array_merge($ids, $list);
                else $ids[] = $list;
            }
        }
        return $ids;
    }

    /**
     * xóa tạm thời bản gi
     * @param Request $request
     */
    public function moveToTrash(Request $request)
    {
        extract($this->apiDefaultData);
        $ids = $this->getIdListFromRequest($request);
        // nếu có id
        if(count($ids) && count($list = $this->repository->get([$this->primaryKeyName => $ids]))){
            $data = [];
            foreach ($list as $result) {
                $id = $result->{$this->primaryKeyName};
                if($result->canMoveToTrash()){
                    
                    // gọi hàm sự kiện truoc khi xóa
                    $this->callCrudEvent('beforeMoveToTrash', $result);

                    // chuyen vao thung ra

                    $this->repository->moveToTrash($id);

                    // gọi hàm sự kiện truoc khi xóa
                    $this->callCrudEvent('afterMoveToTrash', $result);

                    $data[] = $id;

                    $status = true;
                }else{
                    $errors[] = "Bạn không thể di chuyển mục có id $id này vào thùng rác được";
                }
            }
            if($status){
                if(($t = count($data)) > 1){
                    $message = "Đã xóa thành công $t $this->moduleName";
                }
                else{
                    $message = "Đã xóa $this->moduleName thành công!";
                }
            }else{
                $message = "Không thể chuyển một số mục vào thùng rác được!";
            }
        }else{
            $message = 'Không có mục nào được chọn';
        }
        return $this->json(compact(...$this->apiSystemVars));
        
    }

    

    /**
     * xóa vĩnh viễn bản gi
     * @param Request $request
     */
    public function delete(Request $request)
    {
        extract($this->apiDefaultData);
        $ids = $this->getIdListFromRequest($request);
        // nếu có id
        $this->repository->resetDefaultParams();
        if(count($ids) && count($list = $this->repository->get([$this->primaryKeyName => $ids]))){
            $data = [];
            foreach ($list as $result) {
                $id = $result->{$this->primaryKeyName};
                if($result->canDelete()){
                    
                    // gọi hàm sự kiện truoc khi xóa
                    $this->callCrudEvent('beforeDelete', $result);

                    // chuyen vao thung ra

                    $this->repository->delete($id);

                    // gọi hàm sự kiện truoc khi xóa
                    $this->callCrudEvent('afterDelete', $result);

                    $data[] = $id;

                    $status = true;
                }else{
                    $errors[] = "Bạn không thể xóa mục có id $id này được";
                }
            }

            if(!$status){
                $message = 'Có vẻ như thao tác không hợp lệ';
            }
        }else{
            $message = 'Không có mục nào được chọn';
        }
        return $this->json(compact(...$this->apiSystemVars));
        
    }


    /**
     * khôi phục bản gi xóa tạm
     * @param Request $request
     */
    public function restore(Request $request)
    {
        extract($this->apiDefaultData);
        $this->repository->resetDefaultParams();
        $ids = $this->getIdListFromRequest($request);
        // nếu có id
        if(count($ids) && count($list = $this->repository->get([$this->primaryKeyName => $ids]))){
            $data = [];
            foreach ($list as $result) {
                $id = $result->{$this->primaryKeyName};
                // gọi hàm sự kiện truoc khi khôi phục
                $this->callCrudEvent('beforeRestore',$result);

                // chuyen vao thung ra

                $this->repository->restore($id);

                // gọi hàm sự kiện truoc khi khôi phục
                $this->callCrudEvent('afterRestore', $result);
                
                $data[] = $id;

                $status = true;

            }
            if(!$status){
                $message = 'Có vẻ như thao tác không hợp lệ';
            }
        }else{
            $message = 'Không có mục nào được chọn';
        }
        return $this->json(compact(...$this->apiSystemVars));
        
    }
}