<?php
namespace App\Masks\Themes;

use App\Masks\Users\OwnerMask;
use App\Models\Theme;
use Crazy\Magic\Mask;

class ThemeMask extends Mask
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
        $this->map([
            'owner' => OwnerMask::class
        ]);
    }

    public function onLoaded()
    {
        $this->applyMeta();
        $types = ['multi-page' => 'Multi Page', 'spa' => 'SPA'];
        $web_types = get_system_config('web_type_list');
        // $owner = $this->owner;
        $this->image = $this->getImage();
        // $this->owner = [
        //     'name' => optional($owner)->name,
        //     'email' => optional($owner)->email,
        //     'avatar' => get_user_avatar(optional($owner)->avatar)
        // ];
        $this->view_type_text = $types[$this->view_type]??$this->view_type;
        $this->web_type_text = $this->web_types?implode(', ', array_filter(
            array_map(function ($type) use($web_types){
                return $web_types[trim($type)]??null;
            }, explode(', ', $this->web_types)),
            function ($type)
            {
                return $type?true:false;
            }
        )) : "";

        $this->gallery = $this->getGallery();
        // $this->edit_url = route('admin.themes.update', ['id' => $this->id]);
    }

    
    /**
     * gán dự liệu meta cho dynamic
     * @return void
     */
    public function applyMeta()
    {
        $this->checkMeta();
        if($meta = $this->meta()){
            foreach ($meta as $key => $value) {
                $this->{$key} = $value;
                
            }
        }
    }

    public function toArray()
    {
        $this->edit_url = route('admin.themes.update', ['id' => $this->id]);
        return parent::toArray();
    }

    // khai báo thêm các hàm khác bên dưới nếu cần
}