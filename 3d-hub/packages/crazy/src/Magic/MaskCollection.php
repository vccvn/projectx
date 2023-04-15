<?php
namespace Crazy\Magic;

// biến đổi model thành một object để tránh bị crack

use Countable;
use ArrayAccess;
use ArrayIterator;
use IteratorAggregate;
use JsonSerializable;

use Illuminate\Contracts\Support\Jsonable;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\AbstractPaginator;

use ReflectionClass;

abstract class MaskCollection implements Countable, ArrayAccess, IteratorAggregate, JsonSerializable, Jsonable, Arrayable {

    protected $mask = '';

    protected $items = [];

    protected $total = 0;

    protected $paginator = null;

    protected $isPaginator = false;

    protected $accessAllowed = [
        'perPage', 'currentPage', 'lastPage'
    ];

    public function __construct($collection, $total = 0, $mask = null)
    {
        if($mask && class_exists($mask)){
            $this->mask = $mask;
        }
        elseif(method_exists($this, 'getMask')){
            $this->mask = $this->getMask();
        }
        $this->total = $total;
        if(count($collection)){
            if(is_a($collection, LengthAwarePaginator::class) || is_a($collection, AbstractPaginator::class)){
                $this->paginator = $collection;
                $this->isPaginator = true;
                $this->total = $collection->total();

            }
            if($this->mask && class_exists($this->mask)){
                foreach($collection as $key => $item){
                    $rc = new ReflectionClass($this->mask);
                    $this->items[$key] = $rc->newInstanceArgs( [$item] );
                }
            }else{
                foreach($collection as $key => $item){
                    $this->items[$key] = new MaskExample($this->mask);
                }
            }
        }
    }

    /**
     * lấy link phân trang
     *
     * @param string $blade
     * @param array $args
     * @return View
     */
    public function links(string $blade, array $args = [])
    {
        if($this->isPaginator){
            $paginator = $this->paginator;
            if($args) $paginator->appends($args);
            return $paginator->links($blade);
        }
        return null;
    }

    public function getPagination(string $blade, array $args = [])
    {
        return $this->links($blade, $args);
    }

    // protected abstract function getMask();

    // public function getIterator()
    // {
    //     return (function () {
    //         while(list($key, $val) = each($this->items)) {
    //             yield $key => $val;
    //         }
    //     })();
    // }
    
    /**
     * Get an iterator for the items.
     *
     * @return \ArrayIterator
     */
    public function getIterator()
    {
        return new ArrayIterator($this->items);
    }

    
    /**
     * Count the number of items in the collection.
     *
     * @return int
     */
    public function count()
    {
        return count($this->items);
    }

    public function total()
    {
        return $this->total;
    }
    

    /**
     * Bắt dầu hiển thị từ số
     *
     * @return int
     */
    public function from()
    {
        if($this->isPaginator){
            $currrent = $this->currentPage();
            if($currrent < 1) $currrent = 1;
            $perPage = $this->perPage();
            if(!$perPage) $perPage = 10;
            return ($currrent -1) * $perPage + 1;
        }
        return $this->total()?1:0;
    }

    /**
     * hiển thị tới số
     *
     * @return int
     */
    public function to()
    {
        $total = $this->total;
        if($this->isPaginator){
            $currrent = $this->currentPage();
            if($currrent < 1) $currrent = 1;
            $perPage = $this->perPage();
            if(!$perPage) $perPage = 10;
            $t = $currrent * $perPage;
            return $t > $total ? $total : $t;
        }
        return $total;
    }



    /**
     * Determine if an item exists at an offset.
     *
     * @param  mixed  $key
     * @return bool
     */
    public function offsetExists($key)
    {
        return array_key_exists($key, $this->items);
    }

    /**
     * Get an item at a given offset.
     *
     * @param  mixed  $key
     * @return mixed
     */
    public function offsetGet($key)
    {
        return $this->items[$key];
    }

    /**
     * Set the item at a given offset.
     *
     * @param  mixed  $key
     * @param  mixed  $value
     * @return void
     */
    public function offsetSet($key, $value)
    {
        if (is_null($key)) {
            $this->items[] = $value;
        } else {
            $this->items[$key] = $value;
        }
    }

    /**
     * Unset the item at a given offset.
     *
     * @param  string  $key
     * @return void
     */
    public function offsetUnset($key)
    {
        unset($this->items[$key]);
    }

    
    /**
     * Convert the object into something JSON serializable.
     *
     * @return array
     */
    public function jsonSerialize()
    {
        return array_map(function ($value) {
            if ($value instanceof JsonSerializable) {
                return $value->jsonSerialize();
            } elseif ($value instanceof Jsonable) {
                return json_decode($value->toJson(), true);
            } elseif ($value instanceof Arrayable) {
                return $value->toArray();
            }

            return $value;
        }, $this->items);
    }


    
    public function toArray()
    {
        $data = [];
        if(count($this->items)){
            foreach ($this->items as $key => $item) {
                $data[$key] = $item->toArray();
            }
        }
        return $data;
    }
    public function toRaw()
    {
        // if()
        // $a = [
        //     'current_page' => $this->currentPage(),
        //     'data' => $this->items->toArray(),
        //     'first_page_url' => $this->url(1),
        //     'from' => $this->firstItem(),
        //     'last_page' => $this->lastPage(),
        //     'last_page_url' => $this->url($this->lastPage()),
        //     'next_page_url' => $this->nextPageUrl(),
        //     'path' => $this->path(),
        //     'per_page' => $this->perPage(),
        //     'prev_page_url' => $this->previousPageUrl(),
        //     'to' => $this->lastItem(),
        //     'total' => $this->total(),
        // ];
    }

    public function toJson($options = 0)
    {
        return json_encode($this->toArray());
    }


    public function __call($name, $arguments)
    {
        if(in_array($name, $this->accessAllowed) && $this->isPaginator){
            return call_user_func_array([$this->paginator, $name], $arguments);
        }
        return null;
    }
    public function __toString()
    {
        return $this->toJson();
    }


    
}