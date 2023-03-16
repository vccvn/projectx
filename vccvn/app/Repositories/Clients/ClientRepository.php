<?php

namespace App\Repositories\Clients;

use App\Repositories\Base\BaseRepository;
use Crazy\Helpers\Arr;

class ClientRepository extends BaseRepository
{
    /**
     * class chứ các phương thức để validate dử liệu
     * @var string $validatorClass 
     */
    protected $validatorClass = 'App\Validators\Clients\ClientValidator';
    /**
     * @var string $resourceClass
     */
    protected $resourceClass = 'ClientResource';
    /**
     * @var string $collectionClass
     */
    protected $collectionClass = 'ClientCollection';
    
    /**
     * @var array $sortByRules kiểu sắp xếp
     */
    protected $sortByRules = [
        1 => 'id-DESC',
        2 => 'name-ASC',
        3 => 'name-DESC',
        4 => 'rand()'
    ];
    
    /**
     * get model
     * @return string
     */
    public function getModel()
    {
        return \App\Models\Client::class;
    }



    public function beforeGetData($args = []){
        
        // sap xep danh sach
        $a = false;
        foreach (['', 'type', 'Type', '_type'] as $k) {
            if(isset($args['@sort'.$k])){
                if(!$a){
                    $this->parseSortBy($args['@sort'.$k]);
                    $a = true;
                }
                unset($args['@sort'.$k]);
            }    
        }
        
    }

    

    
    /**
     * xử lý order by cho hàm lấy sản phẩm
     *
     * @param array|string $sortBy
     * @return void
     */
    public function parseSortBy($sortBy)
    {
        if(is_array($sortBy)){
            // truong hop mang toan index la so
            if(Arr::isNumericKeys($sortBy)){
                foreach ($sortBy as $by) {
                    $this->checkSortBy($by);
                }
            }else{
                foreach ($sortBy as $column => $type) {
                    if(is_numeric($column)){
                        $this->checkSortBy($type);
                    }else{
                        $this->order_by($column, $type);
                    }
                }
            }
        }else{
            $this->checkSortBy($sortBy);
        }
    }


    /**
     * kiểm tra tính hợp lệ của tham sớ truyền vào
     *
     * @param string $sortBy
     * @param string $type
     * @return void
     */
    protected function checkSortBy($sortBy = null, $type = null)
    {
        if(in_array($sortBy, $this->sortByRules)){
            $this->orderByRule($sortBy);
        }elseif (array_key_exists($sortBy, $this->sortByRules)) {
            $this->orderByRule($this->sortByRules[$sortBy]);
        }elseif($sortBy){
            $this->order_by($sortBy, $type?$type:'ASC');
        }
    }


    /**
     * order by rule
     *
     * @param string $rule
     * @return void
     */
    protected function orderByRule($rule)
    {
        if($rule == 'rand()'){
            $this->orderByRaw($rule);
            
        }
        else{
            $a = explode('-', $rule);
            $this->order_by($a[0], $a[1]);
        }
    }
}