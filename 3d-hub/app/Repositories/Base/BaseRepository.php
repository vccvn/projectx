<?php
/**
 * @author DoanLN
 * @copyright 2018-2019
 */

namespace App\Repositories\Base;
/**
 * danh sách method
 * @method static select(...$columns) thêm các cột cần select
 * @method static selectRaw($string) select dạng nguyen bản
 * @method static from($table) 
 * @method static fromRaw($string)
 * @method static join(string $table, string $tableColumn, string $operator = '=', string $leftTableColumn) join vs 1 bang khac
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
 * @method static withCount($_ = null)
 * @method static load($_ = null)
 */
abstract class BaseRepository
{
    use BaseQuery, GettingAction, CRUDAction, FilterAction, OwnerAction, FileAction, DataAction, CacheAction;

    // tự động kiểm tra owner
    protected $checkOwner = true;

    protected $_primaryKeyName = 'id';
    /**
     * @var \Illuminate\Database\Eloquent\Model
     */
    protected $_model;

    /**
     * EloquentRepository constructor.
     */
    public function __construct()
    {
        $this->setModel();
        $this->_primaryKeyName = $this->_model->getKeyName();
        if($this->checkOwner){
            $this->ownerInit();
        }
        $this->init();
    }

    public function getKeyName()
    {
        return $this->_primaryKeyName;
    }


    /**
     * get model
     * @return string
     */
    abstract public function getModel();

    
    /**
     * chạy các lệnh thiết lập
     */
    protected function init()
    {
        
    }
    /**
     * Get one
     * @param int $id
     * @return mixed
     */
    public function find($id)
    {
        $result = $this->_model->find($id);
        return $result;
    }

    /**
     * tạo một repository mới
     *
     * @return BaseRepository
     */
    public function mewRepo()
    {
        return new static();
    }

    /**
     * kiểm tra tồn tại
     *
     * @param string|int|float ...$args
     * @return bool
     */
    public function exists(...$args)
    {
        $t = count($args);
        if($t >= 2){
            return $this->countBy(...$args) ? true : false;
        }elseif($t == 1){
            return $this->countBy('id', $args[0]) ? true : false;
        }
        return false;
    }
    public static function checkExists($id)
    {
        return (new static())->exists($id);
    }
}