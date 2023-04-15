<?php

namespace App\Repositories\Sliders;

use App\Repositories\Base\BaseRepository;

class ItemRepository extends BaseRepository
{
    /**
     * class chứ các phương thức để validate dử liệu
     * @var string $validatorClass 
     */
    protected $validatorClass = 'App\Validators\Sliders\ItemValidator';
    /**
     * @var string $resourceClass
     */
    protected $resourceClass = 'SliderItemResource';
    /**
     * @var string $collectionClass
     */
    protected $collectionClass = 'SliderItemCollection';
    

    protected $defaultSortBy = [
        'priority' => 'ASC'
    ];

    /**
     * slider id
     *
     * @var integer
     */
    protected static $sliderID = 0;

    /**
     * đã kiểm tra hay chưa
     * @var boolean $checked
     */
    protected $checked = false;

    /**
     * get model
     * @return string
     */
    public function getModel()
    {
        return \App\Models\SliderItem::class;
    }


    /**
     * thiết lập slider id
     *
     * @param integer $sliderID
     * @return void
     */
    public static function setSliderID($sliderID = 0)
    {
        static::$sliderID = $sliderID;
    }

    public static function getSliderID()
    {
        return static::$sliderID;
    }


    /**
     * thiết lập thông tin slider
     *
     * @return void
     */
    public function init()
    {
        if($this->checked) return true;
        if($slider_id = static::getSliderID()){
            $this->checked = true;
            $this->addDefaultValue('slider_id', $slider_id)
            ->addDefaultParam('slider', 'slider_id', $slider_id);
        }
        $this->paginate = false;

    }

    /**
     * them slider id
     *
     * @param array $data
     * @return array
     */
    public function beforeCreate(array $data)
    {
        $slider_id = static::getSliderID();
        if($slider_id && (!isset($data['slider_id']) || !$data['slider_id'])){
            $data['slider_id'] = $slider_id;
        }
        return $data;
    }


    

    /**
     * sap xep lai thu tu
     * @param integer $item_id
     * @param integer $priority
     * @return void
     */
    public function updatePriority($id, $priority=0)
    {
        // nếu tìm không thấy item_id thì trả về false luôn
        if(!($sliderItem = $this->find($id))) return false;
        $c = $this->countBy('slider_id',$sliderItem->slider_id);
        if($sliderItem->priority==0 || $priority == 0){
            if($sliderItem->priority==0){
                $sliderItem->priority = $c;
                $sliderItem->save();
                return true;
            }
            return $this->updatePriority($id, $c);
        }
        // nếu thứ tữ khác 0 và khác thứ tự cụ
        if($priority != $sliderItem->priority){
            // nếu thứ tự lớn hơn tổng số thì gán thứ tự bằng tổng số
            if($priority > $c) $priority = $c;
            
            // xử lý trường hợp thay đổi vị trí trong khoảng 0 < priority < max

            $query = $this->newRepo()->where('slider_id',$sliderItem->slider_id)->where('id', '!=', $sliderItem->id);
            
            // vị trí bắt đầu
            $begin = ($priority<$sliderItem->priority)?$priority:$sliderItem->priority;
            // vị trí kết thúc
            $end = ($priority>$sliderItem->priority)?$priority:$sliderItem->priority;    
            
            $query->whereBetween('priority',[$begin,$end]);
            
            if($list = $query->get()){
                if($priority > $sliderItem->priority){
                    foreach($list as $item){
                        $item->priority = $item->priority - 1;
                        $item->save();
                    }
                    
                }
                else{
                    foreach($list as $item){
                        $item->priority = $item->priority + 1;
                        $item->save();
                    }
                }   
            }
            $sliderItem->priority = $priority;
            $sliderItem->save();
            return true;
        }
        return false;
    }

    /**
     * sửa thứ tự hiển thị
     *
     * @param int $slider_id
     * @return void
     */
    public function repairPriority($slider_id)
    {
        if(( $max = count($list = $this->orderBy('priority','DESC')->get(['slider_id' => $slider_id])) ) > 0){
            // nếu có danh sách sẽ duyệt qua và sap91 xep71 từ cao đến thấp 
            foreach($list as $item){
                if($item->priority>$max){
                    $item->priority = $max;
                    $item->save();
                }
                $max--;
            }
        }
    }

    /**
     * sap xep 
     *
     * @param integer $slider_id
     * @param array $items
     * @return bool
     */
    public function sortItems(int $slider_id, array $items = [])
    {
        $status = true;
        if(count($list = $this->get(['slider_id' => $slider_id]))){
            foreach ($list as $item) {
                if(!array_key_exists($item->id, $items)){
                    $item->delete();
                }elseif ($item->priority != $items[$item->id]) {
                    $item->priority = $items[$item->id];
                    $item->save();
                }
            }
        }else{
            $status = false;
        }
        return $status;
    }

}