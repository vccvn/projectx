<?php

namespace App\Repositories\Categories;

use App\Repositories\Base\BaseRepository;

/**
 * danh sách method
 * @method CategoryRefRepository select(...$columns) thêm các cột cần select
 * @method CategoryRefRepository selectRaw($string) select dạng nguyen bản
 * @method CategoryRefRepository from($table) 
 * @method CategoryRefRepository fromRaw($string)
 * @method CategoryRefRepository join(string $table, string $tableColumn, string $operator = '=', string $leftTableColumn) join vs 1 bang khac
 * @method CategoryRefRepository leftJoin($table, $tableColumn, $operator, $leftTableColumn)
 * @method CategoryRefRepository crossJoin($_ = null)
 * @method CategoryRefRepository where($_ = null)
 * @method CategoryRefRepository whereRaw($_ = null)
 * @method CategoryRefRepository whereIn($column, $values = [])
 * @method CategoryRefRepository whereNotIn($column, $values = [])
 * @method CategoryRefRepository whereBetween($column, $values = [])
 * @method CategoryRefRepository whereNotBetween($column, $values = [])
 * @method CategoryRefRepository whereDay($_ = null)
 * @method CategoryRefRepository whereMonth($_ = null)
 * @method CategoryRefRepository whereYear($_ = null)
 * @method CategoryRefRepository whereDate($_ = null)
 * @method CategoryRefRepository whereTime($_ = null)
 * @method CategoryRefRepository whereColumn($_ = null)
 * @method CategoryRefRepository orWhere($_ = null)
 * @method CategoryRefRepository orWhereRaw($_ = null)
 * @method CategoryRefRepository orWhereIn($column, $values = [])
 * @method CategoryRefRepository orWhereNotIn($column, $values = [])
 * @method CategoryRefRepository orWhereBetween($column, $values = [])
 * @method CategoryRefRepository orWhereNotBetween($column, $values = [])
 * @method CategoryRefRepository orWhereDay($_ = null)
 * @method CategoryRefRepository orWhereMonth($_ = null)
 * @method CategoryRefRepository orWhereYear($_ = null)
 * @method CategoryRefRepository orWhereDate($_ = null)
 * @method CategoryRefRepository orWhereTime($_ = null)
 * @method CategoryRefRepository orWhereColumn($leftColumn, $operator = '=', $rightColumn)
 * @method CategoryRefRepository groupBy($column)
 * @method CategoryRefRepository having($_ = null)
 * @method CategoryRefRepository havingRaw($_ = null)
 * @method CategoryRefRepository orderBy($_ = null)
 * @method CategoryRefRepository orderByRaw($_ = null)
 * @method CategoryRefRepository skip($_ = null)
 * @method CategoryRefRepository take($_ = null)
 * @method CategoryRefRepository with($_ = null)
 * @method CategoryRefRepository withCount($_ = null)
 * @method CategoryRefRepository load($_ = null)
 */

class CategoryRefRepository extends BaseRepository
{
    /**
     * class chứ các phương thức để validate dử liệu
     * @var string $validatorClass 
     */
    protected $validatorClass = 'CategoryRefs\CategoryRefValidator';
    /**
     * @var string $resourceClass
     */
    protected $resourceClass = 'CategoryRefResource';
    /**
     * @var string $collectionClass
     */
    protected $collectionClass = 'CategoryRefCollection';

    /**
     * tên class mặt nạ. Thược có tiền tố [tên thư mục] + \ vá hậu tố Mask
     *
     * @var string
     */
    protected $maskClass = 'CategoryRefs\CategoryRefMask';

    /**
     * tên collection mặt nạ
     *
     * @var string
     */
    protected $maskCollectionClass = 'CategoryRefs\CategoryRefCollection';

    /**
     * get model
     * @return string
     */
    public function getModel()
    {
        return \App\Models\CategoryRef::class;
    }

}