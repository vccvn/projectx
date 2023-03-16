<?php

namespace App\Repositories\Sliders;

use App\Engines\CacheEngine;
use App\Repositories\Base\BaseRepository;

class SliderRepository extends BaseRepository
{
    /**
     * class chứ các phương thức để validate dử liệu
     * @var string $validatorClass 
     */
    protected $validatorClass = 'App\Validators\Sliders\SliderValidator';
    /**
     * @var string $resourceClass
     */
    protected $resourceClass = 'SliderResource';
    /**
     * @var string $collectionClass
     */
    protected $collectionClass = 'SliderCollection';
    
    /**
     * tên class mặt nạ. Thược có tiền tố [tên thư mục] + \ vá hậu tố Mask
     *
     * @var string
     */
    protected $maskClass = 'Sliders\SliderMask';

    /**
     * tên collection mặt nạ
     *
     * @var string
     */
    protected $maskCollectionClass = 'Sliders\SliderCollection';

    protected $responseMode = 'mask';

    /**
     * get model
     * @return string
     */
    public function getModel()
    {
        return \App\Models\Slider::class;
    }

    
    /**
     * sap xep lai thu tu
     * @param integer $id
     * @param integer $priority
     * @return void
     */
    public function updatePriority($id, $priority=0)
    {
        // nếu tìm không thấy id thì trả về false luôn
        if(!($slider = $this->findBy('id', $id))) return false;
        $c = $this->count();
        if($slider->priority==0 || $priority == 0){
            if($slider->priority==0){
                $slider->priority = $c;
                $slider->save();
                return true;
            }
            return $this->updatePriority($id, $c);
        }
        // nếu thứ tữ khác 0 và khác thứ tự cụ
        if($priority != $slider->priority){
            // nếu thứ tự lớn hơn tổng số thì gán thứ tự bằng tổng số
            if($priority > $c) $priority = $c;
            
            // xử lý trường hợp thay đổi vị trí trong khoảng 0 < priority < max

            $query = $this->newRepo()->where('id', '!=', $slider->id);
            
            // vị trí bắt đầu
            $begin = ($priority<$slider->priority)?$priority:$slider->priority;
            // vị trí kết thúc
            $end = ($priority>$slider->priority)?$priority:$slider->priority;    
            
            $query->whereBetween('priority',[$begin,$end]);
            
            if($list = $query->get()){
                if($priority > $slider->priority){
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
            $slider->priority = $priority;
            $slider->save();
            return true;
        }
        return false;
    }

    /**
     * sửa thứ tự hiển thị
     *
     * @return void
     */
    public function repairPriority()
    {
        if(( $max = count($list = $this->orderBy('priority','DESC')->get()) ) > 0){
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
     * @param array $items
     * @return bool
     */
    public function sortSliders(array $items = [])
    {
        $status = true;
        if(count($list = $this->get())){
            foreach ($list as $slider) {
                if(!array_key_exists($slider->id, $items)){
                    $slider->delete();
                }elseif ($slider->priority != $items[$slider->id]) {
                    $slider->priority = $items[$slider->id];
                    $slider->save();
                }
            }
        }else{
            $status = false;
        }
        return $status;
    }


    /**
     * lấy thông tin slider
     *
     * @param array|int $args
     * @return \App\Masks\Sliders\SliderMask|\App\Models\Slider|null
     */
    public function getSlider($args = [])
    {
        $this->with('items');
        return $this->detail($args);

    }
}