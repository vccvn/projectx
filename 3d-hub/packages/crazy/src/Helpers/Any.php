<?php

/**
 * @author DoanLN
 * @date 2018-12-25
 * @description 
 * cho phép tạo ra các đối tượng từ màng, 
 * truy cập cào các phần tử của mảng thông qua key bằng tên thuộc tính của đối tượng
 * 
 */

namespace Crazy\Helpers;
use Countable;
class Any implements Countable{
    /**
     * @var array $__data mảng dữ liệu
     */
    protected $__data = [];

    /**
     * @var mixed $__origin Dữ liệu gốc
     */
    protected $__origin = null;

    /**
     * prefix de lay gia tri
     * @var string
     */
    protected $__prefix = '';

    /**
     * @var boolean $__isAutoConvert trạng thái dữ liệu trả về có convert hay không
     */
    protected $__isAutoConvert = false;

    /**
     * hàm khởi tạo
     * @param array $data
     * @param string $prefix
     * @param boolean $autoConvert 
     */

    function __construct($data = null, $prefix = '', $autoConvert=false)
    {
        $this->__init($data, $prefix, $autoConvert);
    }


    /**
     * thiết lập data
     * 
     * @param array|object $data mảng dữ liệu
     * @param string $prefix
     * @param boolean      $autoConvert
     */
    public function __init($data = null, $prefix='', $autoConvert=false)
    {
        // set du lieu goc
        $this->__origin = $data;
        // neu la mang
        if(is_array($data)){
            $this->__data = [];
            // duyet mang de chen key
            foreach($data as $key => $value){
                $this->__data[$key] = $value;
            }
        }
        $this->setPrefix($prefix);
        $this->autoConvert($autoConvert);

    }

    /**
     * Kích hoạt tự động convert
     * @param boolean $active
     */
    public function autoConvert($active = true)
    {
        $this->__isAutoConvert = $active ? true : false;
    }

    /**
     * @param string $prefix
     * 
     * @return object
     */

    public function setPrefix(string $prefix = '')
    {
        $this->__prefix = $prefix;
        return $this;
    }
    
    public function getAll()
    {
        return $this->__data;
    }

    public function getOrigin()
    {
        return $this->__origin;
    }
    public function hasData()
    {
        return count($this->__data);
    }


    /**
     * gắn giá trị cho thuộc tính với name là tên thuộc tính
     * value là giá trị của thuộc tính
     * @param string $name
     * 
     * 
     */
	public function set($name, $value = null)
    {
        if(is_string($name) || is_numeric($name)) $this->__data[$this->__prefix.$name] = $value;
        return $this;
        
    }
    
    
    /**
     * lấy giá trị 
     * @param string $name
     * @param mixed $default
     * 
     * @param mixed  $value
     */
	public function get($name = null, $default = null)
    {
        if(is_null($name)) return $this->__data;
        // nếu tồn tải key name trong mang data
        if (array_key_exists($this->__prefix.$name, $this->__data)) {
            $data = $this->__data[$this->__prefix.$name]; 
            // nếu giá trị tìm được là mãng hoặc object và autoConvert được kích hoạt thì sẽ tạo object Light 
            if((is_array($data) && is_object($data)) && $this->__isAutoConvert){
                $arr = new static($data, $this->__isAutoConvert);
                $arr->setPrefix($this->__prefix);
                return $arr;
            }
            return $data;
        }
        if(count($name_arr = explode('.', $this->__prefix.$name))>1){
            $data = $this->_data;
            foreach ($name_arr as $n) {
                if(!is_array($data) || !array_key_exists($n, $data)){
                    return $default;
                }
                $data = $data[$n];
            }
            return $data;
        }
        return $default;
    }

    /**
     * loại bỏ các phần tử
     * @param array
     * 
     * @return instance
     */
    public function remove(...$keys)
    {
        if(is_array($keys)){
            foreach ($keys as $key) {
                unset($this->__data[$this->__prefix.$key]);
            }
        }
        return $this;
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
        $this->set($name,$value);
        
    }
    
    
    /**
     * lấy giá trị 
     * @param string $name
     * 
     * @param mixed  $value
     */
	public function __get($name)
    {
        return $this->get($name);
    }
    /**
     * kiểm tra isset vd isset($light->prop)
     * @param string $name
     */
	
    public function __isset($name)
    {
        return isset($this->__data[$this->__prefix.$name]);
    }

    /**
     * loại bỏ thuộc tính qua tên thuộc tính
     */
    public function __unset($name)
    {
        unset($this->__data[$this->__prefix.$name]);
	}
    
    
    /**
     * truy cập thuộc tính bằng cách gọi hàm với tham số mặc định
     * @param string $method
     * @param array $params
     */
	public function __call($method, $params)
	{
		$t = (is_array($params) && isset($params[0])) ? $params[0] : null;
		if (array_key_exists($this->__prefix.$method, $this->__data)) {
			if(!$this->__data[$this->__prefix.$method] && !is_null($t)){
				return $t;
			}
			return $this->__data[$this->__prefix.$method];
        }
        return $t;
    }
    
    public function __toString()
    {
        return json_encode($this->__data);
    }

    public function count()
    {
        return count($this->__data);
    }
}