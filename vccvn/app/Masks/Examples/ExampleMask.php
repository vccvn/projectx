<?php
namespace App\Masks\Examples;

use App\Models\Model;
use Crazy\Magic\Mask;

class ExampleMask extends Mask{

    /**
     * lấy data từ model sang mask
     * @param Model $model tham so này không bắt buộc phải khai báo
     */
    public function toMask(Model $model)
    {
        // mặc định
        $data = $this->getAttrData();
        // hoặc 
        // $data = $model->toArray();
        // hoặc 
        // $data = [
        //     'column' => $this->column
        // ];
        return $data;
        // return $this->toArray();
    }

    /**
     * làm gì đó trong khi khoi tao
     * cũng có thể thực hiện trong hàm toMask()
     */
    protected function init()
    {
        // truyền vào tên phương thức hoặc thuộc tính cho phép truy cập trực tiếp vào model
        // $this->allow(['name', 'category', 'owner']);
    }

    // khai báo thêm các hàm khác bên dưới nếu cần
}