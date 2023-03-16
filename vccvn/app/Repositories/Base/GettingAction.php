<?php

namespace App\Repositories\Base;

/**
 * các phương thúc với owner
 */
trait GettingAction
{

    /**
     * has pagination
     *
     * @var boolean
     */
    public $hasPaginateParam = false;
    /**
    * get model
    *
    * @return \App\Models\Model
    */
   public function model()
   {
       return new $this->_model;
   }

    /**
     * Get All
     * @return \App\Models\Model[]
     */
    public function getAll()
    {
        return $this->_model->all();
    }



    /**
     * lay ra 1 ban ghi theo tieu chi
     * @param string $prop
     * @param string $value
     * @return \App\Models\Model
     */
    public function findBy($prop='name',$value=null)
    {
        if($prop && $value!==null){
            return $this->first([$prop=>$value]);
        }
        return null;
    }

    /**
     * lấy nhanh thông tin theo một trường nào đó
     * @param string $column
     * @param mixed $value
     * @return \App\Models\Model[]
     */

    public function getBy($prop='name',$value=null)
    {
        if($prop && $value!==null){
            return $this->get([$prop=>$value]);
        }
        return [];
    }



    /**
     * lấy về các bản ghi phù hợp với tham số đã cung cấp
     * @param array $args
     * @return \App\Models\Model[]|\App\Masks\MaskCollection
     */
    public function get($args = [])
    {
        $this->hasPaginateParam = false;
        $this->beforeGetData($args);
        $paginate = null;
        $limit = null;
        if(is_array($args)){
            if(isset($args['@paginate'])){
                $paginate = $args['@paginate'];
                unset($args['@paginate']);
            }
            if(isset($args['@limit'])){
                $limit = $args['@limit'];
                unset($args['@limit']);
            }
        }
        if(!$paginate) $paginate = $this->_paginate;

        $query = $this->query($args);
        // $this->lastQueryBuilder = $query;

        if($limit){
            $this->totalCount = $query->count();
            $this->buildLimitQuery($query, $limit);
        }
        if($paginate){
            $this->hasPaginateParam = true;
            $collection = $query->paginate($paginate);
            $this->totalCount = $collection->total();
        }else{
            $collection = $query->get();
        }


        return $collection;
    }

    /**
     * chi lay ma ko dem
     * @param array $args
     * @return \App\Models\Model[]
     */

    public function getOnly($args = [])
    {
        $this->hasPaginateParam = false;
        $this->beforeGetData($args);
        $paginate = null;
        $limit = null;
        if(is_array($args)){
            if(isset($args['@paginate'])){
                $paginate = $args['@paginate'];
                unset($args['@paginate']);
            }
        }
        if(is_array($args)){
            if(isset($args['@limit'])){
                $limit = $args['@limit'];
                unset($args['@limit']);
            }
        }
        if(!$paginate) $paginate = $this->_paginate;
        $query = $this->query($args);
        if($limit) $this->buildLimitQuery($query, $limit);
        if($paginate){
            $this->hasPaginateParam = true;
            $collection = $query->paginate($paginate);
        }else{
            $collection = $query->get();
        }

        return $collection;
    }

    /**
     * lấy ra kết quả đầu tiên
     *
     * @param array $args
     * @return \App\Models\Model
     */
    public function first($args = [])
    {
        $this->beforeGetData($args);
        $query = $this->query($args);
        // $this->last_query_builder = $query;
        if(is_array($args)){
            //
        }
        return $query->first();
    }


    /**
     * dem so ban ghi
     *
     * @param array $args
     * @return int
     */
    public function count($args = [])
    {
        $this->beforeGetData($args);
        if(is_array($args)){
            if(isset($args['@paginate'])){
                unset($args['@paginate']);
            }
            if(isset($args['@limit'])){
                unset($args['@limit']);
            }
        }
        $query = $this->query($args);
        // $this->lastQueryBuilder = $query;

        return $query->count();
    }


    /**
     * dem so ban ghi theo tieu chi
     * @param string $name
     * @param string $value
     * @return int
     */
    public function countBy($prop='name',$value=null)
    {
        if($prop && $value!==null){
            return $this->count([$prop=>$value]);
        }
        return 0;
    }

    /**
     * tính tổng
     *
     * @param string $column
     * @param array $args
     * @return int
     */
    public function sum($column, $args = [])
    {
        $this->beforeGetData($args);
        return $this->query($args)->sum($column);
    }

    /**
     * tính trung bình
     *
     * @param string $column
     * @param array $args
     * @return int|float
     */
    public function avg($column, $args = [])
    {
        $this->beforeGetData($args);
        return $this->query($args)->avg($column);
    }



    public function countLast()
    {
        $data = $this->lastParams;
        $query = $this->query($data);
        return $query->count();
    }

    /**
     * lấy dữ liệu option
     *
     * @param array $args
     * @param string $defaultFirst
     * @param string $valueKey
     * @param string $textKey
     * @return array
     */
    public function getDataOptions(array $args = [], $defaultFirst = null, $valueKey = 'id', $textKey = 'name') : array
    {
        $a = array_filter($args, function($value){
            if(is_string($value) || is_numeric($value)){
                return strlen($value) > 0;
            }elseif (is_array($value)) {
                if(count($value)) return true;
                else return false;
            }
            return true;
        });
        $data = [];
        if($defaultFirst) $data = ["" => $defaultFirst];
        if(!$textKey) $textKey = 'name';
        $textTemp = preg_match('/\{\$[^\}]+\}/i', $textKey) ? $textKey : null;
        if($list = $this->get($a)){
            foreach ($list as $item) {
                $val = $item->{$valueKey};
                if(is_null($val)) $val = '';
                $data[$val] = $textTemp ? str_eval($textKey, $item->getAttrData()) : (
                    isset($item->{$textKey})?$item->{$textKey} : ''
                );
            }
        }

        return $data;
    }


    /**
     * lấy danh sách option được yêu cầu trực tiếp bở request
     *
     * @param \Illuminate\Http\Request $request thông tin request
     * @param array $args $mảng tham số
     * @param string $defaultFirst
     * @param string $valueKey tên cột sẽ làm giá trị
     * @param string $textKey tên cộ sẽ hiển thị
     * @return array
     */
    public function getRequestDataOptions($request, array $args = [], $defaultFirst = null, $valueKey = 'id', $textKey = 'name') : array
    {
        if($request->ignore && is_array($request->ignore)){
            $this->whereNotIn($valueKey, $request->ignore);
        }
        $this->buildFilter($request);
        $args = array_merge($this->getPaginateArgs($request), $args);
        $data = $this->getDataOptions($args, $defaultFirst, $valueKey, $textKey);
        return $data;
    }


    public function chunkById(...$args)
    {
        return $this->query()->chunkById(...$args);
    }

    public function chunk(...$args)
    {
        return $this->query()->chunk(...$args);
    }

    /**
     * lấy ra tổng số bản ghi
     *
     * @return int
     */
    public function total()
    {
        return $this->totalCount;
    }
}
