<?php

namespace App\Repositories\Base;

use App\Engines\CacheEngine;

/**
 * danh sách method
 * @method BaseRepository select(...$columns)
 * @method BaseRepository selectRaw($string)
 * @method BaseRepository from($table)
 * @method BaseRepository fromRaw($string)
 * @method BaseRepository join(\Cloure $callback)
 * @method BaseRepository join(string $table, string $tableColumn, string $operator, string $leftTableColumn)
 * @method BaseRepository leftJoin($table, $tableColumn, $operator, $leftTableColumn)
 * @method BaseRepository crossJoin($_ = null)
 * @method BaseRepository where($_ = null)
 * @method BaseRepository whereRaw($_ = null)
 * @method BaseRepository whereIn($column, $values = [])
 * @method BaseRepository whereNotIn($column, $values = [])
 * @method BaseRepository whereBetween($column, $values = [])
 * @method BaseRepository whereNotBetween($column, $values = [])
 * @method BaseRepository whereDay($_ = null)
 * @method BaseRepository whereMonth($_ = null)
 * @method BaseRepository whereYear($_ = null)
 * @method BaseRepository whereDate($_ = null)
 * @method BaseRepository whereTime($_ = null)
 * @method BaseRepository whereColumn($_ = null)
 * @method BaseRepository orWhere($_ = null)
 * @method BaseRepository orWhereRaw($_ = null)
 * @method BaseRepository orWhereIn($column, $values = [])
 * @method BaseRepository orWhereNotIn($column, $values = [])
 * @method BaseRepository orWhereBetween($column, $values = [])
 * @method BaseRepository orWhereNotBetween($column, $values = [])
 * @method BaseRepository orWhereDay($_ = null)
 * @method BaseRepository orWhereMonth($_ = null)
 * @method BaseRepository orWhereYear($_ = null)
 * @method BaseRepository orWhereDate($_ = null)
 * @method BaseRepository orWhereTime($_ = null)
 * @method BaseRepository orWhereColumn($leftColumn, $operator = '=', $rightColumn)
 * @method BaseRepository groupBy($column)
 * @method BaseRepository having($_ = null)
 * @method BaseRepository havingRaw($_ = null)
 * @method BaseRepository orderBy($_ = null)
 * @method BaseRepository orderByRaw($_ = null)
 * @method BaseRepository skip($_ = null)
 * @method BaseRepository take($_ = null)
 * @method BaseRepository with($_ = null)
 * @method BaseRepository load($_ = null)
 * @method mixed filter(\Illuminate\Http\Reques $request, array $args)
 * @method mixed detail(\Illuminate\Http\Reques $request, array $args)
 * @method mixed get(array $args)
 * @method mixed getBy(array $args)
 * @method mixed find($id)
 * @method mixed findBy(string $column, mixed $value)
 * @method mixed first(array $args)
 * @method mixed count(array $args)
 */
class CacheTask
{
    /**
     * doi tuong repository
     *
     * @var BaseRepository
     */
    protected $repository;

    /**
     * khóa để truy cập cache
     *
     * @var string
     */
    protected $key = null;
    /**
     * tham số
     *
     * @var array
     */
    protected $params = [];
    /**
     * expired time (minute)
     *
     * @var integer
     */
    protected $time = 0;

    /**
     * các phương thúc lấy dữ liệu
     *
     * @var array
     */
    protected static $getDataMethods = [
        'get' => 'get', 'getby' => 'getBy', 'findby' => 'findBy', 'first' => 'first', 'count' => 'count',
        'countby' => 'coumtBy', 'getresults' => 'getResults', 'detail' => 'detail', 'getdata' => 'getData'
    ];


    /**
     * khoi tạo task
     *
     * @param BaseRepository|ApiRepository $repository
     * @param string $key
     * @param integer $time
     * @param array $params
     */
    public function __construct($repository, $key = null, $time = 0, $params = [])
    {
        $this->repository = $repository;
        $this->key = $key;
        $this->time = $time;
        $this->params = $params;
    }

    /**
     * lấy key đúng chuẩn
     *
     * @return string
     */
    protected function getKey()
    {
        return 'repository-' . (static::class). '-'. $this->repository->getTable() . '-' . $this->key;
    }
    /**
     * truy cập phần tử trong repository
     *
     * @param string $name
     * @return mixed
     */
    public function __get($name)
    {
        return $this->repository->{$name};
    }


    /**
     * thêm tham số cho repository
     *
     * @param string $name
     * @param mixed $value
     */
    public function __set($name, $value)
    {
        $this->repository->{$name} = $value;
    }

    /**
     * gọi các phương thức get data hoặc repository
     *
     * @param string $name
     * @param array $arguments
     * @return mixed
     */
    public function __call($name, $arguments)
    {
        $dataMethods = $this->repository->getCacheMethods();
        // nếu tên phương thức trùng với một giá trị nào đó trong mảng các phương thúc lấy dữ liệu
        // của repository hiện tại thì gọi phương thức lấy dữ liệu cache
        if(in_array($name, $dataMethods)){
            return $this->getCache($name, $arguments);
        }
        // tương tự diều kiệm trên nhưng kiểm tra key, nhằm giảm độ khó trong việc viết hoa viết thường
        elseif(array_key_exists($key = strtolower($name), $dataMethods)){
            return $this->getCache($dataMethods[$key], $arguments);
        }
        // nếu tên phương thức trùng với một giá trị nào đó trong mảng các phương thúc lấy dữ liệu
        // của base repository mặc định thì gọi phương thức lấy dữ liệu cache
        elseif(in_array($name, static::$getDataMethods)){
            return $this->getCache($name, $arguments);
        }
        // tương tự diều kiệm trên nhưng kiểm tra key, nhằm giảm độ khó trong việc viết hoa viết thường
        elseif(array_key_exists($key = strtolower($name), static::$getDataMethods)){
            return $this->getCache(static::$getDataMethods[$key], $arguments);
        }
        // nếu không thuộc 2 trường hợp trên thì gọi đến các phương thức trong repository
        call_user_func_array([$this->repository, $name], $arguments);
        return $this;
        
    }
    /**
     * lấy cache hoặc dử liệu mới
     * @param string $method
     * @param array $arguments
     * @return mixed
     */
    public function getCache($method, array $arguments=[])
    {
        $time = $this->time ? $this->time : system_setting('cache_data_time', 0);
        if(!$time){
            return call_user_func_array([$this->repository, $method], $arguments);
        }
        $key = $this->getKey();
        if(!($data = CacheEngine::get($key, $params = array_merge($this->params, $arguments)))){
            $data = call_user_func_array([$this->repository, $method], $arguments);
            CacheEngine::set($key, $data, $time, $params);
        }
        return $data;
    }
    
}
