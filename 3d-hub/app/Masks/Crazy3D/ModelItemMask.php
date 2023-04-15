<?php
namespace App\Masks\Crazy3D;

use App\Masks\Categories\CategoryMask;
use App\Masks\Users\UserMask;
use App\Models\Crazy3DModelItem;
use App\Models\Staff;
use Crazy\Magic\Mask;

class ModelItemMask extends Mask
{

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
            'user' => UserMask::class
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
        
        foreach ($data as $key => $value) {
            $this->{$key} = $value;
        }
        $this->thumbnail = $this->getThumbnail();
        $this->download_url = $this->download_url?$this->download_url:($this->zip_file?asset('public/static/sources/nodels/'.$this->secret_id .'/' . $this->zip_file):'');
        
    }
    
    
    // khai báo thêm các hàm khác bên dưới nếu cần
}