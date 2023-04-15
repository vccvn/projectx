<?php
namespace App\Masks\Dynamics;

use App\Masks\Categories\CategoryCollection;
use App\Masks\Metadatas\MetadataCollection;
use App\Masks\Posts\PostCollection;
use App\Models\Dynamic;
use Crazy\Magic\Mask;

class DynamicMask extends Mask
{
    public $meta = [];
    // xem thêm ExampleMask
    /**
     * thêm các thiết lập của bạn
     * ví dụ thêm danh sách cho phép truy cập vào thuộc tính hay gọi phương thức trong model
     * hoặc map vs các quan hệ dữ liệu
     *
     * @return void
     */
    protected function init(){
        $this->allow([
            'getViewUrl', 'getFullTitle', 'getSeoKeywords', 'getFeatureImage',
            'isJson', 'toFormData'
        ]);
        $this->map([
            'metadatas'        => MetadataCollection::class,
            'categories'       => CategoryCollection::class,
            'posts'            => PostCollection::class
        ]);
    }

    /**
     * lấy data từ model sang mask
     * @param Dynamic $dynamic Tham số không bắt buộc phải khai báo. 
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
    
    /**
     * sẽ được gọi sau khi thiết lập xong
     *
     * @return void
     */
    protected function onLoaded()
    {
        if ($metadatas = $this->relation('metadatas')) {
            $jsf = $this->model->getJsonFields();
            foreach ($metadatas as $m) {
                if(in_array($m->name, $jsf)){
                    $value = json_decode($m->value, true);
                }else{
                    $value = $m->value;
                }
                
                $this->meta[$m->name] = $value;
            }
        }
    }
    
    /**
     * gán dự liệu meta cho product
     * @return void
     */
    public function applyMeta()
    {
        if(!$this->meta){
            if ($metadatas = $this->relation('metadatas', true)) {
                $jsf = $this->model->getJsonFields();
                foreach ($metadatas as $m) {
                    if(in_array($m->name, $jsf)){
                        $value = json_decode($m->value, true);
                    }else{
                        $value = $m->value;
                    }
                    $this->{$m->name} = $value;
                    $this->meta[$m->name] = $value;
                }
            }
        }
        else{
            foreach ($this->meta as $key => $value) {
                $this->{$key} = $value;
                
            }
        }
    }

    
    // khai báo thêm các hàm khác bên dưới nếu cần
}