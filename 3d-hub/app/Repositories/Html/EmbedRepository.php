<?php

namespace App\Repositories\Html;

use App\Repositories\Base\BaseRepository;

class EmbedRepository extends BaseRepository
{
    /**
     * class chứ các phương thức để validate dử liệu
     * @var string $validatorClass 
     */
    protected $validatorClass = 'App\Validators\Html\EmbedValidator';
    /**
     * @var string $resourceClass
     */
    protected $resourceClass = 'HtmlEmbedResource';
    /**
     * @var string $collectionClass
     */
    protected $collectionClass = 'HtmlEmbedCollection';
    
    protected $defaultSortBy = [
        'priority' => 'ASC'
    ];
    /**
     * get model
     * @return string
     */
    public function getModel()
    {
        return \App\Models\HtmlEmbed::class;
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
        if(!($result = $this->findBy('id', $id))) return false;
        $c = $this->count();
        if($result->priority==0 || $priority == 0){
            if($result->priority==0){
                $result->priority = $c;
                $result->save();
                return true;
            }
            return $this->updatePriority($id, $c);
        }
        // nếu thứ tữ khác 0 và khác thứ tự cụ
        if($priority != $result->priority){
            // nếu thứ tự lớn hơn tổng số thì gán thứ tự bằng tổng số
            if($priority > $c) $priority = $c;
            
            // xử lý trường hợp thay đổi vị trí trong khoảng 0 < priority < max

            $query = $this->newRepo()->where('id', '!=', $result->id)->where('area_id', $result->area_id);
            
            // vị trí bắt đầu
            $begin = ($priority<$result->priority)?$priority:$result->priority;
            // vị trí kết thúc
            $end = ($priority>$result->priority)?$priority:$result->priority;    
            
            $query->whereBetween('priority',[$begin,$end]);
            
            if($list = $query->get()){
                if($priority > $result->priority){
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
            $result->priority = $priority;
            $result->save();
            return true;
        }
        return false;
    }

    
    /**
     * sửa thứ tự hiển thị
     *
     * @param int $area_id
     * @return void
     */
    public function repairPriority($area_id)
    {
        if(( $max = count($list = $this->orderBy('priority','DESC')->get(['area_id' => $area_id])) ) > 0){
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
     * @param integer $area_id
     * @param array $embeds
     * @return bool
     */
    public function sortEmbeds(int $area_id, array $embeds = [])
    {
        $status = true;
        $ids = array_keys($embeds);
        if(count($list = $this->get(['id' => $ids]))){
            foreach ($list as $item) {
                if ($item->priority != $embeds[$item->id] || $item->area_id != $area_id) {
                    $item->priority = $embeds[$item->id];
                    $item->area_id = $area_id;
                    $item->save();
                }
            }
        }else{
            $status = false;
        }
        return $status;
    }

}