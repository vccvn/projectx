<?php
namespace App\Masks\Files;

use App\Models\File;
use Crazy\Magic\Mask;

class FileMask extends Mask
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
        $this->allow(['getUrl', 'getThumbnail', 'sizeinfo']);
    }

    /**
     * lấy data từ model sang mask
     * @param File $file Tham số không bắt buộc phải khai báo. 
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
        $this->url = $this->getUrl();
        $this->thumbnail = $this->getThumbnail();
        $size = $this->size;
        $size_unit = "KB";
        if($this->size>=1024){
            $size = round($this->size*10/1024)/10;
            $size_unit = 'MB';
            if($size>=1024){
                $size = round($size*10/1024)/10;
                $size_unit = 'GB';
                if($size>=1024){
                    $size = round($size*10/1024)/10;
                    $size_unit = 'TB';
                    
                }
            }
        }
        $this->size = $size;
        
        $this->size_unit = $size_unit;


    }
    
    
    // khai báo thêm các hàm khác bên dưới nếu cần
}