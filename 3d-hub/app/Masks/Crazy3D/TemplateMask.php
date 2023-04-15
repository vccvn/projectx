<?php
namespace App\Masks\Crazy3D;

use App\Models\Crazy3DTemplate;
use Crazy\Magic\Mask;

class TemplateMask extends Mask
{
    protected $hidden = [
        '__data__', 'itemrefs'
    ];

    // xem thêm ExampleMask
    /**
     * thêm các thiết lập của bạn
     * ví dụ thêm danh sách cho phép truy cập vào thuộc tính hay gọi phương thức trong model
     * hoặc map vs các quan hệ dữ liệu
     *
     * @return void
     */
    protected function init(){
        $this->allow(['getThumbnail']);
        $this->map([
            'category' => CategoryMask::class,
            'user' => UserMask::class,
            'itemrefs' => ItemRefCollection::class
        ]);
    }

    /**
     * lấy data từ model sang mask
     * @param Crazy3DModelItem $crazy3DModelItem Tham số không bắt buộc phải khai báo. 
     * Xem thêm ExampleMask
     */
    // public function toMask()
    // {
    //     $data = $this->getAttrData();
    //     // thêm data tại đây.
    //     // Xem thêm ExampleMask
    //     return $data;
        
    // }

    /**
     * sẽ được gọi sau khi thiết lập xong
     *
     * @return void
     */
    protected function onLoaded()
    {
        if(is_array($this->model->__data__)){
            $data =  $this->model->__data__;
        }
        else{
            $data = json_decode($this->model->__data__, true);
        }
        
        $d = array_assign_value($data, [
            'renderer' => ['__isObject__' => true],
            'scene' => [
                'background' => ['__isObject__' => true],
                'foreground' => [],
                'floor' => ['__isObject__' => true],
                'size' => ['__isObject__' => true]
            ]
        ]);

        $d['objects'] = $this->relation('itemrefs');
        $this->data = $d;
        $this->thumbnail_url = $this->getThumbnail();
        $this->thumbnail = $this->getThumbnail();
        
        // dd($this->itemrefs);
        // $this->objects = $this->itemrefs;

        
    }
    
    
    // khai báo thêm các hàm khác bên dưới nếu cần
}