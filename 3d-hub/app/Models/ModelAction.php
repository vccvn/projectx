<?php

namespace App\Models;

use Carbon\Carbon;

trait ModelAction
{
   protected $_meta = [];

    /**
     * @var array $jsonFields các cột dùng kiểu json
     */
    protected $jsonFields = [];

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
        if(!$format) $format = 'd/m/Y - H:m';
        return date($format, strtotime($this->created_at));
    }

    /**
     * lấy thời gian cập nhật bản ghi
     *
     * @param string $format
     * @return string
     */
    public function updateTimeFormat($format=null)
    {
        if(!$format) $format = 'd/m/Y - H:m';
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
                $this->{$key} = $value;
                
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
        if(in_array('deleted', $this->fillable)){
            $this->beforeRestore();
            $this->deleted = 0;
            $this->save();
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
        $delete = parent::delete();
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
        $this->beforeDelete();
        $delete = parent::delete();
        $this->afterDelete();
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
