<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\SoftDeletingScope;

trait ModelEventMethods
{
   protected $_meta = [];

   /**
    * chế độ xóa
    *
    * @var integer
    */
   protected $deleteMode = 0;

    /**
     * @var array $jsonFields các cột dùng kiểu json
     */
    protected $jsonFields = [];

    /**
     * Indicates if the model is currently force deleting.
     *
     * @var bool
     */
    protected $forceDeleting = false;
    /**
     * lấy các cột json
     *
     * @return array
     */
    public function getJsonFields()
    {
        return $this->jsonFields;
    }


    /**
     * lấy thời gian được định dạng
     *
     * @param string $format
     * @return string
     */
    public function dateFormat($format=null)
    {
        if(!$format) $format = 'H:i - d/m/Y';
        return date($format, strtotime($this->created_at));
    }

    /**
     * lấy thời gian được định dạng
     * @param string $column
     * @param string $format
     * @return string
     */
    public function getDatetime($column = 'created_at', $format=null)
    {
        if(!$format) $format = 'Y-m-d H:i:s';
        return date($format, strtotime($this->{$column}));
    }


    /**
     * lấy thời gian cập nhật bản ghi
     *
     * @param string $format
     * @return string
     */
    public function updateTimeFormat($format=null)
    {
        if(!$format) $format = 'H:i - d/m/Y';
        return date($format, strtotime($this->updated_at));
    }

    /**
     * lay ten bang
     */
    public function __get_table()
    {
        return $this->table;
    }

    /**
     * lay danh sach cot
     */
    public function __get_fields()
    {
        return $this->fillable?$this->fillable:[];
    }


    
    /**
     * kiem tra va set meta cho user
     * @return boolean
     */
    public function checkMeta()
    {
        if(!$this->_meta){
            if($this->metadatas && count($this->metadatas)){
                $meta = [];
                foreach ($this->metadatas as $m) {
                    if(in_array($m->name, $this->jsonFields)){
                        $value = json_decode($m->value, true);
                    }else{
                        $value = $m->value;
                    }
                    
                    $meta[$m->name] = $value;
                }
                $this->_meta = $meta;
                return true;
            }
            return false;
        }
        return true;
    }

    /**
     * gán dự liệu meta cho dynamic
     * @return void
     */
    public function applyMeta()
    {
        $this->checkMeta();
        if($this->_meta){
            foreach ($this->_meta as $key => $value) {
                $val = $value;
                // if(($id = str_replace('@mediaid:', '', $value)) != $value){
                //     if($file = get_media_file(['id' => $id])){
                //         $val = $file->source;
                //     }else{
                //         $val = null;
                //     }
                // }
                $this->{$key} = $val;
                
            }
        }
    }

    public function getRela($rela)
    {
        $relations = $this->getRelations();
        return isset($relations[$rela])?$relations[$rela]:[];
    }
    

    /**
     * lay ra 1 hoac tat ca cac thong tin trong bang user_meta
     * @param  string $meta_name ten cua meta can lay thong tin
     * @return mixed             du lieu trong bang meta
     */
    public function meta($meta_name = null)
    {
        if(!$this->checkMeta()) return null;
        if(is_null($meta_name)) return $this->_meta;
        if(array_key_exists($meta_name, $this->_meta)) return $this->_meta[$meta_name];
        return null;
    }

    /**
     * lấy thuộc tính và trả về giá trị của tham số mặc định nếu ko tồn tại
     *
     * @param string $name
     * @param mixed $default
     * @return mixed
     */
    public function getAttr($name, $default = null)
    {
        if(!is_null($this->{$name})) return $this->{$name};
        return $default;
    }

    
    /**
     * lay du lieu de truyen toi form
     */
    public function toFormData()
    {
        $data = $this->toArray();

        return $data;
    }

    /**
     * lấy ra tất cả các thuộc tính dưới dạng mãng
     *
     * @return array
     */
    public function getAttrData()
    {
        return $this->attributesToArray();
    }
    

    public function isSoftDeleteMode()
    {
        return $this->deleteMode == 1 || strtolower($this->deleteMode) == 'soft';
    }


    /**
     * chuyển trạng thái về đã xoa
     * @return boolean
     */
    public function moveToTrash()
    {
        if(!$this->canMoveToTrash()) return false;
        if(in_array('deleted', $this->fillable)){
            $this->beforeMoveToTrash();
            $this->deleted = 1;
            $this->save();
            $this->afterMoveToTrash();
            return true;
        }else{
            return $this->delete();
        }
    }


    /**
     * phương thức sẽ được gọi trước khi chuyển bản ghi vào thùng rác
     * vui lòng override lại phương thức này nếu muốn sử dụng
     * @return mixed
     */
    public function beforeMoveToTrash()
    {
        # code...
        # do something...
        return true;
    }

    /**
     * phương thức sẽ được gọi trước khi chuyển bản ghi vào thùng rác
     * vui lòng override lại phương thức này nếu muốn sử dụng
     * @return mixed
     */
    public function afterMoveToTrash()
    {
        # code...
        # do something...
        return true;
    }

    /**
     * chuyển trạng thái từ đã xoa đã xóa về mình thường
     * @return boolean
     */
    public function restore()
    {
        if(in_array('deleted', $this->fillable) && !$this->isSoftDeleteMode()){
            $this->beforeRestore();
            $this->deleted = 0;
            $this->save();
            $this->afterRestore();
            return true;
        }
        elseif($this->isSoftDeleteMode()){
            $this->beforeRestore();
            $this->sysRestore();
            $this->afterRestore();
            return true;
        }
        return false;
    }

    /**
     * phương thức sẽ được gọi trước khi khôi phục bản ghi
     * vui lòng override lại phương thức này nếu muốn sử dụng
     * @return mixed
     */
    public function beforeRestore()
    {
        # code...
        # do something...
        return true;
    }

    /**
     * phương thức sẽ được gọi trước khi khôi phục bản ghi
     * vui lòng override lại phương thức này nếu muốn sử dụng
     * @return mixed
     */
    public function afterRestore()
    {
        # code...
        # do something...
        return true;
    }

    

    /**
     * xóa vĩnh viễn bản ghi
     * @return boolean
     */
    public function erase()
    {
        if(!$this->canDelete()) return false;
        $this->beforeErase();
        $delete = $this->forceDelete();
        $this->afterErase();
        return $delete;
    }

    /**
     * phương thức sẽ được gọi trước khi xóa bản ghi
     * vui lòng override lại phương thức này nếu muốn sử dụng
     * @return mixed
     */
    public function beforeErase()
    {
        # code...
        # do something...
        return true;
    }

    /**
     * phương thức sẽ được gọi trước khi xóa bản ghi
     * vui lòng override lại phương thức này nếu muốn sử dụng
     * @return mixed
     */
    public function afterErase()
    {
        # code...
        # do something...
        return true;
    }


    

    /**
     * xóa vĩnh viễn bản ghi
     * @return boolean
     */
    public function delete()
    {
        
        if(!$this->canDelete()) return false;
        if($this->isSoftDeleteMode())
        {
            $this->beforeMoveToTrash();
            $delete = parent::delete();
            if($delete){
                $this->afterMoveToTrash();
            }
           
        }else{
            $this->forceDeleting = true;
            $this->beforeDelete();
            $delete = parent::delete();
            if($delete){
                $this->afterDelete();
            }
        }
        return $delete;
    }

    /**
     * phương thức sẽ được gọi trước khi xóa bản ghi
     * vui lòng override lại phương thức này nếu muốn sử dụng
     * @return mixed
     */
    public function beforeDelete()
    {
        # code...
        # do something...
        return true;
    }

    /**
     * phương thức sẽ được gọi trước khi xóa bản ghi
     * vui lòng override lại phương thức này nếu muốn sử dụng
     * @return mixed
     */
    public function afterDelete()
    {
        # code...
        # do something...
        return true;
    }

    /**
     * kiểm tra có thể xóa hay không
     * @return boolean
     */
    public function canDelete()
    {
        return true;
    }


    
    
    /**
     * xóa vĩnh viễn bản ghi
     * @return boolean
     */
    public function forceDelete()
    {
        
        if(!$this->canForceDelete()) return false;
        $this->beforeForceDelete();
        $delete = $this->sysForceDelete();
        if($delete){
            $this->afterForceDelete();
        }
        
        
        return $delete;
    }


    /**
     * Boot the soft deleting trait for a model.
     *
     * @return void
     */
    public static function bootSoftDeletes()
    {
        static::addGlobalScope(new SoftDeletingScope);
    }

    /**
     * Initialize the soft deleting trait for an instance.
     *
     * @return void
     */
    public function initializeSoftDeletes()
    {
        $this->dates[] = $this->getDeletedAtColumn();
    }

    /**
     * Force a hard delete on a soft deleted model.
     *
     * @return bool|null
     */
    protected function sysForceDelete()
    {
        $this->forceDeleting = true;

        return tap(parent::delete(), function ($deleted) {
            $this->forceDeleting = false;

            if ($deleted) {
                $this->fireModelEvent('forceDeleted', false);
            }
        });
    }

    /**
     * Perform the actual delete query on this model instance.
     *
     * @return mixed
     */
    protected function performDeleteOnModel()
    {
        if ($this->forceDeleting || !$this->isSoftDeleteMode()) {
            $this->exists = false;

            return $this->setKeysForSaveQuery($this->newModelQuery())->forceDelete();
        }

        return $this->runSoftDelete();
    }

    /**
     * Perform the actual delete query on this model instance.
     *
     * @return void
     */
    protected function runSoftDelete()
    {
        $query = $this->setKeysForSaveQuery($this->newModelQuery());

        $time = $this->freshTimestamp();

        $columns = [$this->getDeletedAtColumn() => $this->fromDateTime($time)];

        $this->{$this->getDeletedAtColumn()} = $time;

        if ($this->timestamps && ! is_null($this->getUpdatedAtColumn())) {
            $this->{$this->getUpdatedAtColumn()} = $time;

            $columns[$this->getUpdatedAtColumn()] = $this->fromDateTime($time);
        }

        $query->update($columns);

        $this->syncOriginalAttributes(array_keys($columns));
    }

    /**
     * Restore a soft-deleted model instance.
     *
     * @return bool|null
     */
    protected function sysRestore()
    {
        // If the restoring event does not return false, we will proceed with this
        // restore operation. Otherwise, we bail out so the developer will stop
        // the restore totally. We will clear the deleted timestamp and save.
        if ($this->fireModelEvent('restoring') === false) {
            return false;
        }

        $this->{$this->getDeletedAtColumn()} = null;

        // Once we have saved the model, we will fire the "restored" event so this
        // developer will do anything they need to after a restore operation is
        // totally finished. Then we will return the result of the save call.
        $this->exists = true;

        $result = $this->save();

        $this->fireModelEvent('restored', false);

        return $result;
    }

    /**
     * Determine if the model instance has been soft-deleted.
     *
     * @return bool
     */
    public function trashed()
    {
        return ! is_null($this->{$this->getDeletedAtColumn()});
    }

    /**
     * Register a restoring model event with the dispatcher.
     *
     * @param  \Closure|string  $callback
     * @return void
     */
    public static function restoring($callback)
    {
        static::registerModelEvent('restoring', $callback);
    }

    /**
     * Register a restored model event with the dispatcher.
     *
     * @param  \Closure|string  $callback
     * @return void
     */
    public static function restored($callback)
    {
        static::registerModelEvent('restored', $callback);
    }

    /**
     * Determine if the model is currently force deleting.
     *
     * @return bool
     */
    public function isForceDeleting()
    {
        return $this->forceDeleting;
    }

    /**
     * Get the name of the "deleted at" column.
     *
     * @return string
     */
    public function getDeletedAtColumn()
    {
        return defined('static::DELETED_AT') ? static::DELETED_AT : 'deleted_at';
    }

    /**
     * Get the fully qualified "deleted at" column.
     *
     * @return string
     */
    public function getQualifiedDeletedAtColumn()
    {
        return $this->qualifyColumn($this->getDeletedAtColumn());
    }


    /**
     * phương thức sẽ được gọi trước khi xóa bản ghi
     * vui lòng override lại phương thức này nếu muốn sử dụng
     * @return mixed
     */
    public function beforeForceDelete()
    {
        # code...
        # do something...
        return true;
    }

    /**
     * phương thức sẽ được gọi trước khi xóa bản ghi
     * vui lòng override lại phương thức này nếu muốn sử dụng
     * @return mixed
     */
    public function afterForceDelete()
    {
        # code...
        # do something...
        return true;
    }

    /**
     * kiểm tra có thể xóa hay không
     * @return boolean
     */
    public function canForceDelete()
    {
        return true;
    }


    /**
     * kiểm tra có thể xóa hay không
     * @return boolean
     */
    public function canMoveToTrash()
    {
        return true;
    }

    /**
     * xóa file đính kèm
     */
    public function deleteAttachFile()
    {
        return true;
    }

    /**
     * lấy tên file cũ
     */
    public function getAttachFilename()
    {
        return null;
    }

    /**
     * xóa dữ liễu trong bảng liên quan
     *
     * @param string|array ...$relations
     * @return bool
     */
    protected function deleteList(...$relations)
    {
        if(count($relations)){
            foreach ($relations as $relationName) {
                if(is_array($relationName)){
                    if(count($relationName)){
                        $rels = array_values($relationName);
                        $this->deleteList(...$rels);
                    }
                }elseif(is_string($relationName)){
                    $this->deleteRelationMany($relationName);
                }
            }
        }
    }

    private function deleteRelationMany($relation)
    {
        if($relations = $this->{$relation}){
            if(count($relations)){
                foreach ($relations as $key => $rel) {
                    $rel->delete();
                }
            }
        }
    }


    

    //
    public function getShortDesc($length=null, $after = '...')
    {
        $desc = null;
        $trim = true;;
        if(isset($this->description) && $this->description){
            $desc = $this->description;
        }
        elseif(isset($this->short_desc) && $this->short_desc){
            return $this->short_desc;
        }
        elseif(isset($this->content) && $this->content){
            $desc = $this->content;
        }
        elseif(isset($this->detail) && $this->detail){
            $desc = $this->detail;
        }
        if($trim){
            if(!$length) $length = 120;
            $cnt = strip_tags(html_entity_decode($desc));
            if($length < strlen($cnt)){
                $a = explode(' ', str_limit(strip_tags($cnt),$length));
                $b = array_pop($a);
                return implode(' ', $a).$after;
            }else{
                return strip_tags($desc);
            }
        }
        return $desc;
    }

    public function shortContent($length=null, $after = '...')
    {
        $desc = null;
        $trim = true;;
        if(isset($this->content) && $this->content){
            $desc = $this->content;
        }
        if($trim){
            if(!$length) $length = 120;
            
            $cnt = strip_tags(html_entity_decode($desc));
            if($length < strlen($cnt)){
                $a = explode(' ', str_limit(strip_tags($cnt),$length));
                $b = array_pop($a);
                return implode(' ', $a).$after;
            }else{
                return strip_tags($desc);
            }
        }
        return $desc;
    }



    /**
     * tinh thoi gian
     * toi uu sau
     */
    public function calculatorTime($date1=null,$date2 = null){
        if(!$date1) $date1 = 'created_at';
        $date = time();
        if($this->{$date1}){
            $date = strtotime($this->{$date1});
        }else{
            $date = strtotime($date1);
        }
        if(!$date2) $date2 = Carbon::now()->toDateTimeString();
        $s = 1;
        $i = $s*60;
        $h = $i*60;
        $d = $h*24;
        $m = $d*30;
        $y = $d*365;
        
        $diff = abs(strtotime($date2) - $date);
        $years = floor($diff / $y);
        if($years > 0)
            return $years.' năm trước';
        $months = floor(($diff - $years * $y) / ($m));
        if($months > 0)
            return $months.' tháng trước';
        $days = floor(($diff - $years * $y - $months*$m) / $d);
        if($days > 0)
            return $days.' ngày trước';
        $hours = floor(($diff - $years * $y - $months*$m - $days*$d) / $h);
        if($hours > 0)
            return $hours.' giờ trước';
        $minutes = floor(($diff - $years * $y - $months*$m - $days*$d - $hours*$h) / $i);
        if($minutes > 0)
            return $minutes.' phút trước';
        $seconds = floor(($diff - $years * $y - $months*$m - $days*$d - $hours*$h - $minutes*$i));
            return $seconds.' giây trước';
    }
    public function calculator_time($date1=null,$date2 = null){
        return $this->calculatorTime($date1,$date2);
    }
    public function timeAgo($date1=null,$date2 = null){
        return $this->calculatorTime($date1,$date2);
    }

    public function getTimeAgo($unit = 'minute', $date1=null,$date2 = null)
    {
        if(!is_string($unit) || !in_array($u = strtolower($unit), ['second', 'minute', 'hour', 'day', 'month', 'year'])) return 0;
        if(!$date1) $date1 = 'created_at';
        $date = time();
        if($this->{$date1}){
            $date = strtotime($this->{$date1});
        }else{
            $date = strtotime($date1);
        }
        if(!$date2) $date2 = Carbon::now()->toDateTimeString();
        $s = 1;
        $i = $s*60;
        $h = $i*60;
        $d = $h*24;
        $m = $d*30;
        $y = $d*365;
        
        $diff = abs(strtotime($date2) - $date);
        $years = floor($diff / $y);
        if($u == 'year')
            return $years;
        $months = floor(($diff - $years * $y) / ($m));
        if($u == 'month')
            return $months;
        $days = floor(($diff - $years * $y - $months*$m) / $d);
        if($u == 'day')
            return $days;
        $hours = floor(($diff - $years * $y - $months*$m - $days*$d) / $h);
        if($u == 'hour')
            return $hours;
        $minutes = floor(($diff - $years * $y - $months*$m - $days*$d - $hours*$h) / $i);
        if($u == 'minute')
            return $minutes;
        $seconds = floor(($diff - $years * $y - $months*$m - $days*$d - $hours*$h - $minutes*$i));
            return $seconds;
    }

}
