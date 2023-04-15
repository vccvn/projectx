<?php

namespace App\Repositories\Base;

use Illuminate\Support\Facades\DB;

trait EloquentQuery{

    protected $table = '';

    /**
     * @var string
     */

    protected $required = 'id';

    /**
     * @var integer
     */

    public $totalCount = 0;

    /**
     * du lieu lan gan day
     * @var array
     */
    protected $lastParams = [];


    /**
     * @var \Illuminate\Database\Eloquent\Builder
     */

    protected $lastQueryBuilder = null;



    /**
     * sql functions
     * @var array $sqlclause
     */
    protected $sqlclause = [
        // select
        'select' => 'select',
        'selectraw' => 'selectRaw',
        // from
        'from' => 'from',
        'fromraw' => 'fromRaw',
        // join
        'join' => 'join',
        'leftjoin' => 'leftJoin',
        'crossjoin' => 'crossJoin',
        // where
        'where' => 'where',
        'whereraw' => 'whereRaw',
        'wherein' => 'whereIn',
        'wherenotin' => 'whereNotIn',
        'wherebetween' => 'whereBetween',
        'wherenotbetween' => 'whereNotBetween',
        'whereday' => 'whereDay',
        'wheremonth' => 'whereMonth',
        'whereyear' => 'whereYear',
        'wheredate' => 'whereDate',
        'wheretime' => 'whereTime',
        'wherecolumn' => 'whereColumn',
        // orwhere
        'orwhere' => 'orWhere',
        'orwhereraw' => 'orWhereRaw',
        'orwherein' => 'orWhereIn',
        'orwherenotin' => 'orWhereNotIn',
        'orwherebetween' => 'orWhereBetween',
        'orwherenotbetween' => 'orWhereNotBetween',
        'orwhereday' => 'orWhereDay',
        'orwheremonth' => 'orWhereMonth',
        'orwhereyear' => 'orWhereYear',
        'orwheredate' => 'orWhereDate',
        'orwheretime' => 'orWhereTime',
        'orwherecolumn' => 'orWhereColumn',
        // groupby
        'groupby' => 'groupBy',
        // having
        'having' => 'having',
        'havingraw' => 'havingRaw',
        // orderby
        'orderby' => 'orderBy',
        'orderbyraw' => 'orderByRaw',
        // limit
        'skip' => 'skip',
        'take' => 'take',

        'with' => 'with',
        'load' => 'load',

        'withcount' => 'withCount',

    ];

    /**
     * các tham số mặc định
     * @var array
     */
    public $defaultParams = [];

    /**
     * các tham số mặc định
     * @var array
     */
    public $defaultConditions = [];

    /**
     * @var array $defaultValues giá trị mặc đĩnh
     */
    public $defaultValues = [];

    /**
     * tham số có thể xóa
     * @var array
     */
    public $fixableParams = [];



    /**
     * @var array $params tham so truy van
     */
    protected $params = [];

    /**
     * @var array $actions tham so truy van
     */
    protected $actions = [];


    /**
     * @var array $args tham so truy van
     */
    protected $args = [];

    /**
     * phan trang
     * @var integer
     */
    protected $_paginate = 0;
    /**
     * Set model
     */
    public function setModel()
    {
        $this->_model = app()->make(
            $this->getModel()
        );
    }

    /**
     * đưa tất cả về 0 =))))
     * 
     */
    public function reset($all = false)
    {
        $this->totalCount = 0;
        $this->query = null;
        $this->lastQueryBuilder = null;
        $this->lastParams = [];

        if ($all) {
            $this->removeFixableParam();
        }
        return $this;
    }





    /**
     * thêm tham số
     * @param string|integer|float $paramKey
     */
    public function addDefaultParam($paramKey = null, ...$params)
    {
        $t = count($params);
        if ($t == 1) {
            if ($paramKey) {
                $this->defaultParams[$paramKey] = [$paramKey, $params[0]];
            }
        } elseif ($t > 1) {
            if ($paramKey) {
                $this->defaultParams[$paramKey] = $params;
            } else {
                $this->defaultParams[] = $params;
            }
        }

        return $this;
    }


    /**
     * xóa tham số mặc định
     * @param string $paramKey
     */
    public function resetDefaultParams($paramKey = null)
    {
        if (is_null($paramKey)) $this->defaultParams = [];
        else unset($this->defaultParams[$paramKey]);
        return $this;
    }

    /**
     * xóa tham số mặc định
     * @param string $paramKey
     */
    public function removeDefaultParam($paramKey = null)
    {
        return $this->resetDefaultParams($paramKey);
    }



    /**
     * thêm diều kiện
     * @param string $conditionName
     * @param array ...$params
     * @return BaseRepository|ApiRepository
     */
    public function addDefaultCondition($conditionName = null, ...$params)
    {

        if (count($params) > 1) {
            if (is_null($conditionName)) {
                $this->defaultConditions[] = $params;
            } else {
                $this->defaultConditions[$conditionName] = $params;
            }
        }
        return $this;
    }


    /**
     * xóa giá trị tham số mặt định
     * @param string $conditionName
     * @return BaseRepository
     */
    public function removeDefaultConditions($conditionName = null)
    {
        if (!is_null($conditionName)) unset($this->defaultConditions[$conditionName]);
        else $this->defaultConditions = [];
        return $this;
    }
    /**
     * xóa giá trị tham số mặt định
     * @param string $conditionName
     * @return BaseRepository
     */
    public function removeDefaultCondition($conditionName = null)
    {
        return $this->removeDefaultConditions($conditionName);
    }

    /**
     * thêm giá trị mặc dịnh
     *
     * @param array|string $key
     * @param mixed $value
     * @return BaseRepository
     */
    public function addDefaultValue($key, $value = null)
    {
        if (is_string($key)) {
            $this->defaultValues[$key] = $value;
        } elseif (is_array($key)) {
            foreach ($key as $k => $v) {
                $this->defaultValues[$k] = $v;
            }
        }
        return $this;
    }

    /**
     * thêm tham số có thể override
     * @param string|array $name có thể là tên cột hoặc một mảng
     * @param mixed        $value giá trị 
     * 
     * @return BaseRepository
     */
    public function addFixableParam($name, $value = null)
    {
        if (is_array($name)) {
            foreach ($name as $key => $val) {
                if (is_numeric($key)) {
                    if (is_string($val)) {
                        $this->fixableParams[$val] = $value;
                    }
                } else {
                    $this->fixableParams[$key] = $val;
                }
            }
        } elseif (is_string($name)) {
            $this->fixableParams[$name] = $value;
        }
        return $this;
    }

    /**
     * xóa giá trị tham số mặt định
     * @param array|string $name
     * 
     * @return BaseRepository
     */
    public function removeFixableParam($name = null)
    {
        if (is_array($name)) {
            foreach ($name as $val) {
                unset($this->fixableParams[$val]);
            }
        } elseif (is_string($name)) {
            unset($this->fixableParams[$name]);
        } else {
            $this->fixableParams = [];
        }
        return $this;
    }

    /**
     * xóa giá trị tham số mặt định
     * @param array|string $name
     * 
     * @return BaseRepository
     */
    public function removeDefaultValue($name = null)
    {
        if (is_array($name)) {
            foreach ($name as $val) {
                unset($this->defaultValues[$val]);
            }
        } elseif (is_string($name)) {
            unset($this->defaultValues[$name]);
        } else {
            $this->defaultValues = [];
        }
        return $this;
    }


    /**
     * xóa giá trị tham số mặt định
     * @return BaseRepository
     */
    public function clear()
    {
        $this->resetDefaultParams();
        $this->removeDefaultValue();
        $this->removeFixableParam();
        return $this;
    }


    /**
     * kiểm tra field
     * @param string $field tên cột
     * @return boolean
     */
    public function checkField($field)
    {
        return in_array($field, $this->getFields());
    }



    public function getFields()
    {
        return array_merge(['id'], $this->_model->__get_fields());
    }

    /**
     * tạo qury builder 
     * @param array $args            Mảng các tham số hoặc têm hàm và tham số hàm
     * @return \Illuminate\Database\Eloquent\Builder
     * @author DoanLN
     */
    public function query($args = [])
    {
        $keywords = null;
        $search_by = null;
        $orderby = null;
        $limit = null;
        $actions = [];
        $parameters = $this->params;
        $param_actions = $this->actions ?? [];
        if (count($parameters)) {
            $args = array_merge($parameters, (array) $args);
        }

        if ($this->fixableParams) {
            $args = array_merge($this->fixableParams, $args);
        }
        // pewfix 

        $prefix = '';
        $model = $this->model();
        if ($pre = $this->getTable()) {
            $prefix = $pre . '.';
        }
        $required = $prefix . $this->required;
        // tao query builder
        $query = $model->whereNotNull($required);

        if (count($this->defaultConditions)) {
            $this->doAction($this->defaultConditions, $query);
        }


        $args = $this->prepareArgs($args);
        // các tham số mặc định
        if (count($this->defaultParams)) {
            foreach ($this->defaultParams as $key => $param) {
                $param[0] = (count(explode('.', $param[0])) > 1) ? $param[0] : $prefix . $param[0];
                call_user_func_array([$query, 'where'], $param);
            }
        }
        // kiểm tra và tạo query các tham số truyền vào
        if (is_array($args) && count($args)) {

            // duyệt mảng tham số truyền vào
            foreach ($args as $field => $vl) {
                if (is_numeric($field)) {
                    // do action

                    $this->doAction([$vl], $query, $prefix);
                    continue;
                }
                $k = strtolower($field);
                // kiểm tra các lệnh đặc biệt bắt đầu với ký tự '@'
                if (substr($k, 0, 1) == '@') {
                    $f = substr($k, 1);
                    switch ($f) {
                        case 'search':
                            // tim kiem
                            if (!is_array($vl)) {
                                $keywords = $vl;
                            } else {
                                if (isset($vl['keywords'])) {
                                    $keywords = $vl['keywords'];
                                } elseif (isset($vl['keyword'])) {
                                    $keywords = $vl['keyword'];
                                }
                                if (isset($vl['by'])) {
                                    $search_by = $vl['by'];
                                }
                            }
                            break;

                        case 'search_by':
                            // tim kiem
                            $search_by = $vl;
                            break;

                        case 'order_by':
                            // order by
                            $orderby = $vl;
                            break;

                        case 'limit':
                            // limit (skip & take)
                            $limit = $vl;
                            break;

                        case 'actions':
                            // thược hiện các hành động với model thông qua các mảng con chứa phương thức và các tham số
                            $actions = $vl;
                            break;

                        default:
                            // nếu không rơi vào các TH trên thì kiểm tra key truyền vào có phải là phương thức của query builder hay không
                            $ff = substr($field, 1);
                            $func = null;
                            $fff = strtolower($ff);
                            if (in_array($ff, $this->sqlclause))  $func = $ff;
                            elseif (array_key_exists($fff, $this->sqlclause)) $func = $this->sqlclause[$fff];
                            if ($func) {
                                // la method cua query buildr
                                if (is_array($vl) && isset($vl[0])) {

                                    if (is_array($vl[0]) && isset($vl[0][0])) {
                                        foreach ($vl as $p) {
                                            call_user_func_array([$query, $func], $p);
                                        }
                                    } else {
                                        call_user_func_array([$query, $func], $vl);
                                    }
                                } else {
                                    $param = is_array($vl) ? $vl : [$vl];
                                    call_user_func_array([$query, $func], $param);
                                }
                            }
                            elseif (in_array($eager = substr($f, 0, 4), ['with', 'load'])) {
                                $this->eager($eager, substr($ff, 4), $vl);
                            }
                            elseif (in_array($eager2 = substr($f, 0, 9), ['withCount', 'loadCount'])) {
                                $this->eager($eager2, substr($ff, 10), $vl);
                            }
                            
                            break;
                    }
                }
                // end if start with @
                else {
                    // không bắt đầu bằng @ thì sẽ gọi hàm where với column là key và so sánh '='
                    $ifield = $field;
                    $funcfield = null;
                    $ftype = null;
                    if (count($spactor = explode(':', $field)) == 2) {
                        $ifield = $spactor[0];
                        if(in_array($stype = strtolower($spactor[1]), ['date', 'fromdate','from_date'. 'todate', 'to_date','daterange', 'date_range'])){
                            $ftype = str_replace('_', '', $stype);
                            $funcfield = 'addDate';
                        }
                    } 
                    $hasPrefix = (count(explode('.', $ifield)) > 1);
                    if (!$hasPrefix) {
                        // nếu không có prefix và ko có trong fillable thì bỏ qua
                        if (isset($this->whereable) && array_key_exists($ifield, $this->whereable)) {
                            $f = $this->whereable[$ifield];
                        } elseif (!in_array($ifield, $this->getFields()) && $ifield != 'id') continue;
                        else $f = $prefix . $ifield;
                    } else $f = $ifield;

                    if($funcfield){
                        call_user_func_array([$this, $funcfield], [$query, $ftype, $f, $vl]);
                    }
                    elseif (is_array($vl)) {
                        // nếu value là mảng sẽ gọi where in
                        $query->whereIn($f, $vl);
                    } else {
                        $query->where($f, $vl);
                    }
                }
            }
        }


        $actions = array_merge($param_actions, $actions);
        // tim kiem trong bang dua tren cac cot
        if ($keywords) $this->buildSearchQuery($query, $keywords, $search_by, $prefix);
        // thao tac voi query builder thong qua tham so actions
        if ($actions) $this->doAction($actions, $query);
        // build orderby
        if ($orderby) $this->buildOrderByQuery($query, $orderby, $prefix);
        // build limit
        if ($limit) $this->buildLimitQuery($query, $limit);

        $this->resetActionParams();
        return $query;
    }


    /**
     * xử lý data
     *
     * @param array $params
     * @return array
     */
    public function prepareArgs($params = [])
    {
        return $params;
    }


    /**
     * reset param action
     *
     * @return BaseRepository
     */
    public function resetActionParams()
    {
        $this->params = [];
        $this->actions = [];
    }


    /**
     * Eager Loading
     *
     * @param string $type
     * @param string $relation
     * @param mixed $func
     * @return static
     */
    public function eager($type = 'with', $relation = null, $func = null, $queryBuilder = null)
    {

        if(!$queryBuilder) $queryBuilder = $this;
        $trla = strtolower(substr($relation,0, 1)).substr($relation, 1);
        if (is_numeric($func)) {
            $queryBuilder->{$type}([
                $trla => function ($query) use ($func) {
                    $query->take($func);
                }
            ]);
            
        } elseif (is_callable($func)) {
            $queryBuilder->{$type}([
                $trla => $func
            ]);
        } elseif (is_array($func)) {
            $queryBuilder->{$type}([
                $trla => function ($query) use ($func) {
                    foreach ($func as $key => $value) {
                        $k = strtolower($key);
                        if (substr($k, 0, 1) == '@') {
                            $kl = substr($k, 1);
                            if ($kl == 'limit') {
                                $this->buildLimitQuery($query, $value);
                            } elseif (in_array($kl, ['sortby', 'orderby', 'sort', 'sortby', 'sorttype'])) {
                                if(is_numeric($value)){
                                    if(isset($this->sortByRules[$value])){
                                        $this->buildOrderByQuery($query, $this->sortByRules[$value]);
                                    }
                                }
                                else{
                                    $this->buildOrderByQuery($query, $value);
                                }
                                
                            }
                            else {
                                $func = null;
                                if (in_array($kl, $this->sqlclause))  $func = $kl;
                                elseif (array_key_exists($kl, $this->sqlclause)) $func = $this->sqlclause[$kl];
                                if ($func) {
                                    // la method cua query buildr
                                    if (is_array($value) && isset($value[0])) {

                                        if (is_array($value[0]) && isset($value[0][0])) {
                                            foreach ($value as $p) {
                                                call_user_func_array([$query, $func], $p);
                                            }
                                        } else {
                                            call_user_func_array([$query, $func], $value);
                                        }
                                    } else {
                                        $param = is_array($value) ? $value : [$value];
                                        call_user_func_array([$query, $func], $param);
                                    }
                                }
                                elseif (in_array($eager = substr($kl, 0, 4), ['with', 'load'])) {
                                    $this->eager($eager, substr($key, 5), $value, $query);
                                }elseif (in_array($eager2 = substr($kl, 0, 9), ['withCount', 'loadCount'])) {
                                    $this->eager($eager2, substr($key, 10), $value, $query);
                                }
                            }
                        }else{
                            if (is_array($value)) {
                                // nếu value là mảng sẽ gọi where in
                                $query->whereIn($key, $value);
                            } else {
                                $query->where($key, $value);
                            }
                        }
                    }
                }
            ]);
        } 
        if(is_string($func)){
            $queryBuilder->{$type}($trla . ' as ' .$func);
        }
        else {
            $queryBuilder->{$type}($trla);
        }
        return $queryBuilder;
    }

    /**
     * them thời gian
     *
     * @param QueryBuilder $query
     * @param string $type
     * @param string $field
     * @param string|int|float|bool|array $val
     * @return $this
     */
    public function addDate($query, $type, $field, $val = null)
    {
        if(($type=='date' && is_array($val)) || $type == 'daterange'){
            if(is_array($val)){
                if(isset($val[0]) && $dateStr = get_date_str($val[0])){
                    $query->whereDate($field, '>=', $dateStr);
                }
                if(isset($val['from']) && $dateStrl = get_date_str($val['from'])){
                    $query->whereDate($field, '>=', $dateStrl);
                }
                if(isset($val[1]) && $dateStr2 = get_date_str($val[1])){
                    $query->whereDate($field, '<=', $dateStr2);
                }
                if(isset($val['to']) && $dateStrp = get_date_str($val['to'])){
                    $query->whereDate($field, '<=', $dateStrp);
                }
            }
        }
        elseif ($dateStr = get_date_str($val)) {
            if($type=='fromdate'){
                $query->whereDate($field, '>=', $dateStr);
            }
            elseif ($type == 'todate') {
                $query->whereDate($field, '<=', $dateStr);
            }else{
                $query->whereDate($field, $dateStr);
            }
        }
    }


    /**
     * build search query
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string|array $keywords
     * @param string|array $search_by
     * @param string $prefix
     * @return BaseRepository
     */
    protected function buildSearchQuery($query, $keywords, $search_by = null, $prefix = null)
    {
        if (is_string($keywords) && strlen($keywords) > 0) {
            if ($search_by) {
                if (is_string($search_by)) {
                    // tim mot cot
                    $f = (count(explode('.', $search_by)) > 1) ? $search_by : $prefix . $search_by;
                    $query->where($f, 'like', "%$keywords%");
                } elseif (is_array($search_by)) {
                    // tim theo nhieu cot
                    $query->where(function ($q) use ($keywords, $search_by, $prefix) {
                        $b = $search_by;
                        $c = array_shift($b);
                        $f2 = (count(explode('.', $c)) > 1) ? $c : $prefix . $c;
                        $k2 = str_slug($keywords);
                        $q->where($f2, 'like', "%$keywords%");
                        foreach ($b as $col) {
                            $f3 = (count(explode('.', $col)) > 1) ? $col : $prefix . $col;
                            $q->orWhere($f3, 'like', "%$keywords%")->orWhere($f3, 'like', "%$k2%");
                        }
                    });
                }
            }
        }
        return $query;
    }


    /**
     * goi cac phuong thuc cua QueryBuilder
     *
     * @param array $actions
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string $prefix
     * @return \Illuminate\Database\Eloquent\Builder
     */
    protected function doAction($actions, $query = null, $prefix = null)
    {
        if (!$query) {
            $prefix = '';
            $model = $this->model();
            if ($pre = $this->getTable()) {
                $prefix = $pre . '.';
            }
            $required = $prefix . $this->required;
            // tao query builder
            $query = $model->whereNotNull($required);
        }
        $fields = $this->getFields();
        
        if (is_array($actions)) {

            foreach ($actions as $act) {
                // duyet qua cac action
                if (is_array($act)) {
                    if (isset($act['method']) && in_array($act['method'], $this->sqlclause)) {
                        //
                        call_user_func_array([$query, $act['method']], (isset($act['params']) && is_array($act['params'])) ? $act['params'] : []);
                        continue;
                    }
                    $aract = $act;
                    // array action
                    $f = array_shift($aract);
                    // map:
                    // $actions = [
                    //     // ....
                    //     ['where', 'name', 'doan'], // tham số đầu tiên là tên phương thức
                    //     // ....
                    // ]
                    // neu action la 1 mang 

                    if (is_string($f) && in_array($f, $this->sqlclause)) {

                        if (isset($aract[0])) {

                            if (is_array($aract[0])) {
                                call_user_func_array([$query, $f], $aract[0]);
                            } else {
                                call_user_func_array([$query, $f], $aract);
                            }
                        }
                    } elseif (is_array($f)) {
                        // map:
                        // $actions = [
                        //     // ....
                        //     ['where'=>['name','doan']],
                        //     // ....
                        // ]
                        // neu action la 1 mang 
                        foreach ($act as $func => $param) {
                            // duyet qua mang day lay ten action
                            if (is_numeric($func) && is_array($param) && count($param) > 1) {
                                $f = array_shift($param);
                                if (in_array($f, $this->sqlclause) && count($param)) {
                                    if (is_array($param[0]) && isset($param[0][0])) {
                                        foreach ($param as $p) {
                                            call_user_func_array([$query, $f], $p);
                                        }
                                    } else {
                                        call_user_func_array([$query, $f], $param);
                                    }
                                }
                            } elseif (in_array($func, $this->sqlclause)) {

                                if (!is_array($param)) {
                                    call_user_func_array([$query, $func], [$param]);
                                }
                                if (is_array($param[0]) && isset($param[0][0])) {
                                    foreach ($param as $p) {
                                        call_user_func_array([$query, $func], $p);
                                    }
                                } else {
                                    call_user_func_array([$query, $func], $param);
                                }
                            }
                        }
                    } elseif (in_array($f, $fields) || ($this->whereable && is_array($this->whereable) && in_array($f, $this->whereable))) {
                        call_user_func_array([$query, 'where'], $act);
                    } elseif (in_array($prefix . $f, $fields)) {
                        $act[0] = $prefix . $f;
                        call_user_func_array([$query, 'where'], $act);
                    } elseif ($this->whereable && is_array($this->whereable)) {
                        if (array_key_exists($f, $this->whereable)) {
                            $act[0] = $this->whereable[$f];
                            call_user_func_array([$query, 'where'], $act);
                        }
                    }
                }
            }
        }
        return $query;
    }

    /**
     * build order by
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string|array|int $orderby
     * @param string $prefix
     * @return \Illuminate\Database\Eloquent\Builder
     */
    protected function buildOrderByQuery($query, $orderby = null, $prefix = null)
    {
        if ($orderby) {
            // order by mot hoac nhieu cot
            if (is_string($orderby)) {
                // mot cot
                if (count($odb = explode('-', $orderby)) == 2) {
                    $b = strtoupper($odb[1]);
                    if ($b != 'DESC') $b = 'ASC';
                    $f = (count(explode('.', $odb[0])) > 1) ? $odb[0] : $prefix . $odb[0];
                    $query->orderBy($f, $b);
                } elseif (count($odb = array_filter(explode(' ', $orderby), function ($s) {
                    return strlen(trim($s)) > 0;
                })) == 2) {
                    $b = strtoupper($odb[1]);
                    if ($b != 'DESC') $b = 'ASC';
                    $f = (count(explode('.', $odb[0])) > 1) ? $odb[0] : $prefix . $odb[0];
                    $query->orderBy($f, $b);
                } else {
                    // ngau nhien
                    if (strtolower($orderby) == 'rand()') {
                        $query->orderByRaw($orderby);
                    } else {
                        // mac dinh
                        $f = (count(explode('.', $orderby)) > 1) ? $orderby : $prefix . $orderby;
                        $query->orderBy($f);
                    }
                }
            } elseif (is_array($orderby)) {
                // nhieu cot
                foreach ($orderby as $col => $type) {
                    if (is_numeric($col) && is_string($type)) {
                        $f = (count(explode('.', $type)) > 1) ? $type : $prefix . $type;
                        $query->orderBy($f);
                    } else {
                        $f = (count(explode('.', $col)) > 1) ? $col : $prefix . $col;
                        $query->orderBy($f, $type);
                    }
                }
            }
        }
        return $query;
    }

    /**
     * build limit query
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param array|string|int $limit
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function buildLimitQuery($query, $limit = null)
    {
        // limit
        if ($limit) {
            if (is_numeric($limit)) {
                $query->skip(0)->take($limit);
            } elseif (is_string($limit)) {
                if (count($l = explode(',', str_replace(' ', '', $limit))) == 2) {
                    $query->skip($l[0])->take($l[1]);
                }
            } elseif (is_array($limit) && isset($limit[0]) && isset($limit[1])) {
                $query->skip($limit[0])->take($limit[1]);
            }
        }
        return $query;
    }

    /**
     * lấy tên bảng
     *
     * @return string
     */
    public function getTable()
    {
        if ($this->table) return $this->table;
        $this->table = $this->_model->getTable();
        return $this->table;
    }

    /**
     * kiểm tra isset vd isset($light->prop)
     * @param string $name
     */

    public function __isset($name)
    {
        return isset($this->params[$name]);
    }

    /**
     * loại bỏ thuộc tính qua tên thuộc tính
     */
    public function __unset($name)
    {
        unset($this->params[$name]);
    }

    /**
     * gắn giá trị cho thuộc tính với name là tên thuộc tính
     * value là giá trị của thuộc tính
     * @param string $name
     * 
     * 
     */
    public function __set($name, $value)
    {
        $this->params[$name] = $value;
    }

    public function __get($name)
    {
        if (isset($this->params[$name])) return $this->params[$name];
        return null;
    }

    /**
     * them chuoi tim kiem
     * @param string $keywords
     * @param string/array $search_by
     * 
     * @return BaseRepository
     */
    public function addsearch(string $keywords = null, $search_by = null)
    {
        $this->params['@search'] = [
            'keyword' => $keywords,
            'by' => $search_by
        ];
        return $this;
    }

    /**
     * tim kiem bang like
     * @param string $column tên cột
     * @param string $value giá trị tìm kiếm
     * @return BaseRepository
     */
    public function like($column, $value = null)
    {
        return $this->where($column, 'like', '%' . $value . '%');
    }
    /**
     * tim kiem bang like
     * @param string $column tên cột
     * @param string $value giá trị tìm kiếm
     * @return BaseRepository
     */
    public function orLike($column, $value = null)
    {
        return $this->orWhere($column, 'like', '%' . $value . '%');
    }
    /**
     * order by
     * @param mixed
     * @param string
     */
    public function order_by($column = null, $type = 'asc')
    {
        $orderby = is_array($column) ? $column : [$column => $type];
        if (array_key_exists('@order_by', $this->params)) {
            $this->params['@order_by'] = array_merge($this->params['@order_by'], $orderby);
        } else {
            $this->params['@order_by'] = $orderby;
        }
        return $this;
    }

    public function groupByRaw(...$columns)
    {
        if (is_array($columns) && count($columns)) {
            foreach ($columns as $col) {
                $this->groupBy(DB::raw($col));
            }
        }
        return $this;
    }

    /**
     * limit
     *
     * @param int|string|array $start
     * @param integer $length
     * @return BaseRepository
     */
    public function limit($start = null, $length = 0)
    {
        if (is_array($start)) {
            $this->params['@limit'] = $start;
        } elseif ($length) {
            $this->params['@limit'] = [$start, $length];
        } else {
            $this->params['@limit'] = $start;
        }
        return $this;
    }

    /**
     * phân trang
     * @param integer
     * @return BaswRepository
     */
    public function paginate(int $paginate = 0)
    {
        $this->_paginate = $paginate;
        return $this;
    }

    /**
     * gọi hàm không dược khai báo từ trước
     *
     * @param string $method
     * @param array $params
     * @return BaseRepository
     */
    public function __call($method, $params)
    {
        $f = array_key_exists($key = strtolower($method), $this->sqlclause) ? $this->sqlclause[$key] : null;
        if ($f) {
            if (!isset($this->actions) || !is_array($this->actions)) {
                $this->actions = [];
            }
            $this->actions[] = compact('method', 'params');
        }
        return $this;
    }

    /**
     * kiểm tra các phương thức có chứa tham số là chuỗi
     *
     * @param string $method
     * @param string[] ...$params
     * @return boolean
     */
    public function hasActionParam($method, ...$params)
    {
        if ($this->actions) {
            foreach ($this->actions as $key => $actionParans) {
                if (isset($actionParans['method'])) {
                    if ($method == $actionParans['method']) {
                        $a = true;
                        if (isset($actionParans['params']) && is_array($actionParans['params'])) {
                            $p = $actionParans['params'];
                            foreach ($params as $key => $v) {
                                if (!isset($p[$key]) || $p[$key] != $v) $a = false;
                            }
                        } elseif (count($params)) {
                            $a = false;
                        }
                        if ($a) return true;
                    }
                } elseif (isset($actionParans[0])) {
                    if ($method == $actionParans[0]) {
                        $a = true;
                        if (isset($actionParans[1]) && is_array($actionParans[1])) {
                            $p = $actionParans[1];
                            foreach ($params as $key => $v) {
                                if (!isset($p[$key]) || $p[$key] != $v) $a = false;
                            }
                        } elseif (count($params)) {
                            $a = false;
                        }
                        if ($a) return true;
                    }
                }
            }
        }
        return false;
    }

    /**
     * Undocumented function
     *
     * @return string
     */
    public function __toString()
    {
        return json_encode($this->params);
    }
}