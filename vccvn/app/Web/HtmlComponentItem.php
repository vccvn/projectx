<?php

namespace App\Web;

use Crazy\Files\Filemanager;
use Crazy\Helpers\Arr;
use ArrayAccess;
use ArrayIterator;
use Countable;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\Jsonable;
use Illuminate\Support\Facades\View;
use IteratorAggregate;
use JsonSerializable;

class HtmlComponentItem implements Countable, ArrayAccess, IteratorAggregate, JsonSerializable, Arrayable, Jsonable
{
    protected $componentData = [];
    public $shared = [];

    protected $rendered = '';

    public function __construct($config = [])
    {
        if ($config && is_array($config)) {
            foreach ($config as $key => $value) {
                $this->componentData[$key] = $value;
            }
        }
    }


    public function share($key, $value = null)
    {
        $share = is_array($key) ? $key : [$key => $value];
        foreach ($share as $k => $v) {
            $this->shared[$k] = $v;
        }
        if(isset($this->componentData['children']) && $this->componentData['children']) $this->componentData['children']->share($share);
    }

    public function reRender($data = [])
    {
        $a = '';
        $share = $this->shared;
        if($data && is_array($data)){
            $share = array_merge($share, $data);
        }
        $component = $this->component;

        if ($component->type == 'blade') {
            $d = $this->componentData['data'];
            $shareData = array_merge($share, [
                'data' => $d,
                'component' => $component,
                'children' => isset($this->componentData['children']) ? $this->componentData['children']: null
            ]);
            if ($component->ref == 'theme') {
                if (View::exists($blade = 'clients.' . theme_component($component->path))) {
                    $a .= view($blade, $shareData)->render();
                }
            } else if (View::exists($blade = 'client-libs.components.' . $component->path)) {
                $a .= view($blade, $shareData)->render();
            }
        } else if ($component->type == 'html') {
            $a .= $this->componentData['data']->html;
        }
        return $a;
    }

    public function render($data = [])
    {
        if(!$this->rendered) $this->rendered = $this->reRender($data);
        return $this->rendered;
    }

    public function view($data = [])
    {
        return $this->render($data);
    }
    
    public function __toString()
    {
        return $this->render();
    }

    /**
     * lấy giá trị phần tử
     * @param string|int $key
     * @param mixed $default
     * @return mixed
     */
    public function get($key, $default = null)
    {
        if (is_null($key)) return $this->componentData;
        // nếu tồn tải key name trong mang data
        if (array_key_exists($key, $this->componentData)) {
            $a = $this->componentData[$key];
            $b = (is_string($a) && strlen($a) == 0) || is_null($a) || (is_array($a) && !count($a) && is_array($default)) ? $default : $a;
            return $b;
        }
        return $default;
    }



    /**
     * gán giá trị
     * @param string|int $key
     * @param mixed
     * @return object instance
     */
    public function set($key, $value)
    {
        if (is_array($key)) {
            foreach ($key as $k => $v) {
                $this->set($k, $v);
            }
        } else {
            $this->componentData[$key] = $value;
        }

        return $this;
    }


    public function count()
    {
        return count($this->componentData);
    }


    /**
     * xóa phần tử
     * @param string $keys
     * @return object instance
     */
    public function remove(...$keys)
    {
        if (count($keys)) {
            foreach ($keys as $key) {
                unset($this->componentData[$key]);
            }
        } else {
            $this->componentData = [];
        }
        return $this;
    }


    /**
     * lấy giá trị phần tụ theo tên thuộc tính
     * @param string $key
     * @return mixed
     */
    public function __get($key)
    {
        return $this->get($key);
    }

    /**
     * gan gia tri cho phan tu
     * @param string $key
     * @param mixed $value
     * 
     * @return object
     */
    public function __set($key, $value)
    {
        return $this->set($key, $value);
    }

    /**
     * kiểm tra tồn tại
     * 
     * @return boolean
     */
    public function  __isset($key)
    {
        return isset($this->componentData[$key]);
    }

    /**
     * xóa phần tử
     * @param string $key
     */
    public function __unset($key)
    {
        unset($this->componentData[$key]);
    }

    public function offsetSet($offset, $value)
    {
        if (is_null($offset)) {
            $this->componentData[] = $value;
        } else {
            $this->componentData[$offset] = $value;
        }
    }

    public function offsetExists($offset)
    {
        return isset($this->componentData[$offset]);
    }

    public function offsetUnset($offset)
    {
        unset($this->componentData[$offset]);
    }

    public function offsetGet($offset)
    {
        return isset($this->componentData[$offset]) ? $this->componentData[$offset] : null;
    }


    /**
     * Get an iterator for the items.
     *
     * @return \ArrayIterator
     */
    public function getIterator()
    {
        return new ArrayIterator($this->componentData);
    }

    public function toArray()
    {
        return $this->componentData;
    }


    public function toJson($options = 0)
    {
        return json_encode($this->toArray());
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
        }, $this->toArray());
    }
}
