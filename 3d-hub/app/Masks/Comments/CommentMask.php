<?php
namespace App\Masks\Comments;

use App\Masks\Pages\PageMask;
use App\Masks\Posts\PostMask;
use App\Masks\Posts\SearchMask;
use App\Masks\Products\ProductMask;
use App\Masks\Projects\ProjectMask;
use App\Models\Comment;
use Crazy\Magic\Mask;

class CommentMask extends Mask
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
        $this->allow([
            'refer'
        ]);
        $this->map([
            'publishChildren' => CommentCollection::class,
            'page' => PageMask::class,
            'post' => PostMask::class,
            'product' => ProductMask::class,
            'project' => ProjectMask::class,
            'refer' => SearchMask::class
        ]);
    }

    /**
     * lấy data từ model sang mask
     * @param Comment $comment Tham số không bắt buộc phải khai báo. 
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
        $avatar = ($this->author_id && $author = get_model_data('user', $this->author_id)) ? get_user_avatar($author->avatar) : asset('images/default/avatar.png');
        $this->author_avatar = $avatar;
    }
    
    /**
     * lọc các ký tự html
     *
     * @return string
     */
    public function htmlMessage()
    {
        return implode("\n<br>", array_map('htmlentities', nl2array($this->message)));
    }
    
    // khai báo thêm các hàm khác bên dưới nếu cần
}