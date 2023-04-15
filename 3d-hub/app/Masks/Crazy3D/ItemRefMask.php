<?php
namespace App\Masks\Crazy3D;

use App\Models\Crazy3DItemRef;
use Crazy\Magic\Mask;

class ItemRefMask extends Mask
{
    protected $hidden = ['item_id', 'ref', 'ref_id', '__data__', 'item'];

    // xem thêm ExampleMask
    /**
     * thêm các thiết lập của bạn
     * ví dụ thêm danh sách cho phép truy cập vào thuộc tính hay gọi phương thức trong model
     * hoặc map vs các quan hệ dữ liệu
     *
     * @return void
     */
    protected function init(){
        $this->map([
            'item' => ModelItemMask::class
        ]);
    }

    /**
     * lấy data từ model sang mask
     * @param Crazy3DItemRef $crazy3DItemRef Tham số không bắt buộc phải khai báo. 
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
        
        try {
            if(is_array($this->model->__data__)){
                $data =  $this->model->__data__;
            }
            else{
                $data = json_decode($this->model->__data__, true);
            }
            
        
        } catch (\Throwable $th) {
            $data = [];
        }
        if(array_key_exists('secret_key', $data) && $item = $this->relation('item')){
            
            $this->type = 'model';
            
            $this->secret_key = $data['secret_key'];
            
            if(array_key_exists('settings', $data) && is_array($item->settings)){
                $settongs = $item->settings;
                
                if(array_key_exists('props', $data['settings']) && is_array($data['settings']['props'])){

                    if(array_key_exists('props', $settongs)) $settongs['props'] = array_merge($settongs['props'], $data['settings']['props']);
                    else $settongs['props'] = $data['settings']['props'];
                }
                if(array_key_exists('meshes', $data['settings']) && is_array($data['settings']['meshes'])){
                    if(array_key_exists('meshes', $settongs) && is_array($settongs['meshes'])){
                        $meshOverrideByNAme = [];
                        foreach ($data['settings']['meshes'] as $k => $mesh) {
                            $meshOverrideByNAme[$mesh['name']] = $mesh['data'];
                        }

                        foreach ($settongs['meshes'] as $key => $m) {
                            if(array_key_exists($m['name'], $meshOverrideByNAme)){
                                $settongs['meshes'][$key]['data'] = array_merge($settongs['meshes'][$key]['data'], $meshOverrideByNAme[$m['name']]);
                            }
                        }
                    }else{
                        $settongs['meshes'] = $data['meshes'];
                    }
                }
                if(!array_key_exists('options', $settongs) || !$settongs['options']){
                    $settongs['options'] = [
                        "pivot" =>  [
                          "x" => "center",
                          "y" => "center",
                          "z" => "center"
                        ]
                        ];
                    
                }
                
                $item->settings = $settongs;
                
                $this->data=$item;
            }
        }

    }
    
    
    // khai báo thêm các hàm khác bên dưới nếu cần
}