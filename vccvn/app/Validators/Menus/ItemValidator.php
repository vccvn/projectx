<?php

namespace App\Validators\Menus;

use App\Repositories\Dynamics\DynamicRepository;
use App\Repositories\Pages\PageRepository;
use App\Repositories\Posts\CategoryRepository as PostCategoryRepository;
use App\Repositories\Projects\CategoryRepository as ProjectCategoryRepository;
use App\Repositories\Products\CategoryRepository as ProductCategoryRepository;

use App\Validators\Base\BaseValidator;
use Crazy\Laravel\Router;

class ItemValidator extends BaseValidator
{
    /**
     * ref type khả dụng
     *
     * @var array
     */
    public $refTypes = [
        'page'                 => PageRepository::class,
        'dynamic'              => DynamicRepository::class, 
        'post_category'        => PostCategoryRepository::class, 
        'product_category'     => ProductCategoryRepository::class, 
        'project_category'     => ProjectCategoryRepository::class
    ];
    public function extends()
    {
        /* kiem tra loai item */
        $this->addRule('check_type', function($attr, $value){
            if(!$value) return false;
            $types = array_merge(['url','route'], array_keys($this->refTypes));
            return in_array($value, $types);
        });

        /* kiem tra route */
        $this->addRule('check_route', function($attr, $value){
            if(!$value) return false;
            if(Router::getByName($value)) return true;
            return false;
        });

        // kiem tra ref id
        $this->addRule('check_ref_id', function($attr, $value){
            if(!$value) return false;
            if(array_key_exists($this->type, $this->refTypes)){
                $result = app($this->refTypes[$this->type])->First(['id' => $value]);
                return $result ? true : false;
            }
            return false;
        });
    }

    /**
     * ham lay rang buoc du lieu
     */
    public function rules()
    {
    
        $rules = [
            'type'                         => 'check_type',
            'sub_type'                     => 'in_list:default,custom,item,mega',
            'icon'                         => 'mixed',
            'class'                        => 'mixed',
            'link_class'                   => 'mixed',
            'active_key'                   => 'mixed',
            'target'                       => 'mixed',
            'show_submenu'                 => 'mixed'
        ];
        switch ($this->type) {
            case 'url':
                $rules['text'] = $this->icon?'mixed':'required';
                $rules['url'] = 'required';
                break;

            case 'route':
                $rules['text'] = $this->icon?'mixed':'required';
                $rules['route'] = 'required|check_route';
                break;

            default:
                if(array_key_exists($this->type, $this->refTypes)){
                    $rules[$this->type.'_id'] = 'check_ref_id';
                    if($this->text) $rules['text'] = 'mixed';
                }
                
                break;
        }
        return $rules;
    }

    /**
     * các thông báo
     */
    public function messages()
    {
        return [
            'type.check_type'                      => 'Loại item không hợp lệ',
            'sub_type.in_list'                     => 'Loại sub menu không hợp lệ',
            'text.required'                        => 'Text hiển thị Không được bỏ trống',
            'url.required'                         => 'URL Không được bỏ trống',
            'route.required'                       => 'Route Không được bỏ trống',
            'route.check_route'                    => 'Route Không hợp lệ',
            'page_id.*'                            => 'Trang không hợp lệ',
            'dynamic_id.*'                         => 'Kênh không hợp lệ',
            'post_category_id.*'                   => 'Danh mục không hợp lệ',
            'product_category_id.*'                => 'Danh mục không hợp lệ',
            'project_category_id.*'                => 'Danh mục không hợp lệ',
            
        ];
    }
}