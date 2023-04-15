<?php

namespace App\Masks\Crazy3D;

use App\Models\Category;
use Crazy\Magic\Mask;

class CategoryMask extends Mask
{
    static $withItems = 0;
    static $withTemplates = 0;
    static $withProjects = 0;
    /**
     * set eager loading
     *
     * @param string|array $key
     * @param integer $total
     * @return void
     */
    public static function setEagerLoad($key, $total = 0)
    {
        $a = ['templates', 'projects', 'items'];

        if (is_string($key) && in_array($key, $a) && is_numeric($total) && $total >= 0) {
            switch ($key) {
                case 'templates':
                    static::$withTemplates = $total;
                    break;
                case 'projects':
                    static::$withProjects = $total;
                    break;
                default:
                    static::$withItems = $total;
                    break;
            }
        }
        elseif(is_array($key)){
            foreach ($key as $k => $t) {
                static::setEagerLoad($k, $t);
            }
        }
    }

    // xem thêm ExampleMask
    /**
     * thêm các thiết lập của bạn
     * ví dụ thêm danh sách cho phép truy cập vào thuộc tính hay gọi phương thức trong model
     * hoặc map vs các quan hệ dữ liệu
     *
     * @return void
     */
    protected function init()
    {
        $this->map([
            'items' => ModelItemCollection::class,
            'templates' => TemplateCollection::class,
            'projects' => ProjectCollection::class,

        ]);
    }

    /**
     * lấy data từ model sang mask
     * @param Category $category Tham số không bắt buộc phải khai báo. 
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
        // dd($this->model);
        $this->thumbnail = $this->getFeatureImage();
        // dump($this->model);
        if (!$this->relation('items') && static::$withItems > 0) {
            if (count($items = $this->model->items()->orderBy('id', 'DESC')->take(static::$withItems)->get())) {
                $this->parseRNewelation('items', $items);
            } else {
                $this->items = [];
            }

            // dump($this->items);
        }
        if (!$this->relation('templates') && static::$withTemplates > 0) {
            if (count($templates = $this->model->templates()->orderBy('id', 'DESC')->take(static::$withTemplates)->get())) {
                $this->parseRNewelation('templates', $templates);
            } else {
                $this->templates = [];
            }

            // dump($this->items);
        }
        if (!$this->relation('projects') && static::$withProjects > 0) {
            if (count($projects = $this->model->projects()->orderBy('id', 'DESC')->take(static::$withProjects)->get())) {
                $this->parseRNewelation('projects', $projects);
            } else {
                $this->projects = [];
            }

            // dump($this->items);
        }
    }


    // khai báo thêm các hàm khác bên dưới nếu cần
}
