<?php
namespace App\Repositories\Base;


/**
 * @author DoanLN
 * @copyright 2018-2019
 */
abstract class ApiRepository
{
    use EloquentQuery, CRUDAction, FilterAction, FileAction, CacheAction;
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
        
        $this->init();
    }


    
    /**
     * get model
     * @return string
     */
    abstract public function getModel();

    
    /**
     * chạy các lệnh thiết lập;
     */
    protected function init()
    {
        
    }
    /**
     * Get one
     * @param $id
     * @return mixed
     */
    public function find($id)
    {
        $result = $this->_model->find($id);
        return $result;
    }


    

}