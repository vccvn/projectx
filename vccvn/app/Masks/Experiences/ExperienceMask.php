<?php
namespace App\Masks\Experiences;

use App\Models\Experience;
use Crazy\Magic\Mask;

class ExperienceMask extends Mask
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
        $this->allow('getDate', 'getTime');
    }

    /**
     * lấy data từ model sang mask
     * @param Experience $experience Tham số không bắt buộc phải khai báo. 
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
        $from = parse_date_time($this->started_at);
        $to = parse_date_time($this->finished_at);
        
        if($this->org_name){
            if(!$this->school){
                $this->school = $this->org_name;
            }
            if(!$this->company){
                $this->company = $this->org_name;
            }
        }

        $this->from_year = $from['year'];
        if($to['year'] < 2050){
            $this->to_year = $to['year'];
        }else{
            $this->to_year = 'Hiện tại';
        }

        
        $this->started = $this->getDate('started_at');
        $this->finished = $this->getDate('finished_at');
    }
    
    
    // khai báo thêm các hàm khác bên dưới nếu cần
}