<?php

namespace App\Repositories\Base;

use App\Engines\CacheEngine;

/**
 * danh sách method
 * @method static select(...$columns)
 * @method static selectRaw($string)
 * @method static from($table)
 * @method static fromRaw($string)
 * @method static join(\Cloure $callback)
 * @method static join(string $table, string $tableColumn, string $operator, string $leftTableColumn)
 * @method static leftJoin($table, $tableColumn, $operator, $leftTableColumn)
 * @method static crossJoin($_ = null)
 * @method static where($_ = null)
 * @method static whereRaw($_ = null)
 * @method static whereIn($column, $values = [])
 * @method static whereNotIn($column, $values = [])
 * @method static whereBetween($column, $values = [])
 * @method static whereNotBetween($column, $values = [])
 * @method static whereDay($_ = null)
 * @method static whereMonth($_ = null)
 * @method static whereYear($_ = null)
 * @method static whereDate($_ = null)
 * @method static whereTime($_ = null)
 * @method static whereColumn($_ = null)
 * @method static orWhere($_ = null)
 * @method static orWhereRaw($_ = null)
 * @method static orWhereIn($column, $values = [])
 * @method static orWhereNotIn($column, $values = [])
 * @method static orWhereBetween($column, $values = [])
 * @method static orWhereNotBetween($column, $values = [])
 * @method static orWhereDay($_ = null)
 * @method static orWhereMonth($_ = null)
 * @method static orWhereYear($_ = null)
 * @method static orWhereDate($_ = null)
 * @method static orWhereTime($_ = null)
 * @method static orWhereColumn($leftColumn, $operator = '=', $rightColumn)
 * @method static groupBy($column)
 * @method static having($_ = null)
 * @method static havingRaw($_ = null)
 * @method static orderBy($_ = null)
 * @method static orderByRaw($_ = null)
 * @method static skip($_ = null)
 * @method static take($_ = null)
 * @method static with($_ = null)
 * @method static load($_ = null)
 * @method mixed filter(\Illuminate\Http\Request $request, array $args)
 * @method mixed detail(\Illuminate\Http\Request $request, array $args)
 * @method mixed get(array $args)
 * @method mixed getBy(array $args)
 * @method mixed find($id)
 * @method mixed findBy(string $column, mixed $value)
 * @method mixed first(array $args)
 * @method mixed count(array $args)
 * @method static trashed(boolean|numeric $status) set trang thai lay du lieu
 * @method static notTrashed() set trang thai lay du lieu chua xoa
 */

class CacheTask
{
    /**
     * doi tuong repository
     *
     * @var static
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
     * @param static|ApiRepository $repository
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
        // dump(system_setting());
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
