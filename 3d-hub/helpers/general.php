<?php

use App\Engines\BreaDcrumb;
use App\Repositories\Categories\CategoryRepository;
// use App\Repositories\Customers\CustomerRepository;
use App\Repositories\Orders\OrderRepository;
// use App\Repositories\Clients\ClientRepository;
// use App\Repositories\Locations\DistrictRepository;
// use App\Repositories\Locations\RegionRepository;
// use App\Repositories\Locations\WardRepository;
use App\Repositories\Sliders\SliderRepository;
use App\Repositories\Sliders\ItemRepository;
use App\Repositories\Files\FileRepository;
// use App\Repositories\Promos\ServicePromoRepository;
// use App\Repositories\Services\PackageRepository;
// use App\Repositories\Services\ServiceRepository;

if(!function_exists('json_path')){
    /**
     * lấy dường dẫn từ thư mục json
     * @param string $path
     * @return string
     */
    function json_path($path = null)
    {
        return base_path('json').($path?'/'.ltrim($path, '/'):'');
    }
}

if(!function_exists('get_client_file_uploads')){
    /**
     * lấy file mà người dùng đạ upload len và được lưu trong mục quản lý file
     * @param array $args
     * 
     * @return Collection
     */
    function get_client_file_uploads(array $args = []){
        if(!isset($args['ref_id']) || !$args['ref_id']) return [];
        return (new FileRepository())->get($args);
    }
}

if(!function_exists('get_web_data')){
    /**
     * lấy data dc luu
     * @param string $args
     * @param mixed $default
     * @return mixed
     */
    function get_web_data($key = null, $default = null)
    {
        return App\Web\Data::get($key, $default);
    }
}


if(!function_exists('set_web_data')){
    /**
     * lưu data
     * @param string|array $args
     */
    function set_web_data($key, $value = null)
    {
        return App\Web\Data::set($key, $value);
    }
}

if(!function_exists('get_slider_active_id')){
    /**
     * lấy dương dẫn mục nội dung
     * @return int
     */
    function get_slider_active_id()
    {
        admin_check_slider();
        return ItemRepository::getSliderID();
    }
}

if(!function_exists('admin_slider_item_url')){
    /**
     * lấy dương dẫn mục nội dung
     * @param string $module
     * @param array $params
     * @return string
     */
    function admin_slider_item_url($module, array $params = [])
    {
        admin_check_slider();
        $url = null;
        if (isset($params['slider']) && $params['slider']) {
            $url = route('admin.sliders.items.'.$module, $params);
        }elseif($slider = get_web_data('slider')){
            $url = route('admin.sliders.items.'.$module, array_merge($params, [
                'slider' => $slider->id,
            ]));
        }
        return $url;
    }
}



if(!function_exists('admin_check_slider')){
    /**
     * kiểm tra mục nội dung đã được set hay chưa
     * @param string $module
     * @param array $params
     * @return string
     */
    function admin_check_slider()
    {
        static $isCheck = false;
        static $status = false;
        if($isCheck) return $status;
        $request = request();
        
        if(($slider_id = $request->route('slider')) && $slider = (new SliderRepository)->first(['id' => $slider_id, 'deleted' => 0])){
            $isCheck = true;
            if($slider->deleted){
                $status = false;
            }else{
                ItemRepository::getSliderID($slider->id);
                set_web_data('slider', $slider);
                view()->share('slider', $slider);
                $isCheck = true;
                return true;
            }
        }

        return false;
    }
}





if(!function_exists('get_category')){
    /**
     * lấy mục nội dung
     * @param array $params
     * @return \App\Models\Category
     */
    function get_category(array $params = [])
    {
        return app(CategoryRepository::class)->first(get_parse_query_args($params));
    }
}



if(!function_exists('get_categories')){
    /**
     * lấy mục nội dung
     * @param array $params
     * @return \App\Models\Category[]
     */
    function get_categories(array $params = [])
    {
        return app(CategoryRepository::class)->get(get_parse_query_args($params));
    }
}






if(!function_exists('check_model_data')){
    /**
     * lấy thông tin của data theo model nào đó
     * @param string $model 
     * @param int $id
     * @return bool
     */
    function check_model_data(string $model = 'post', $id = 0)
    {
        return get_web_data('model_data.'.$model.'.'.$id) ? true : false;
    }
}

if(!function_exists('get_model_data')){
    /**
     * lấy thông tin của data theo model nào đó
     * @param string $model 
     * @param int $id
     */
    function get_model_data(string $model = 'post', $id = 0, $getifnotexists = true)
    {
        $list = [
            'post', 'dynamic', 'page', 'product', 
            'category', 'post_category', 'project_category', 'product_category', 
            'product_attribute', 'user',
        ];
        if(!($data = get_web_data('model_data.'.$model.'.'.$id))){
            if($getifnotexists && in_array($model, $list) && function_exists($fn = 'get_'.$model)){
                $data = call_user_func_array('get_'.$model, [['id' => $id]]);
                set_web_data('model_data.'.$model.'.'.$id, $data);
            }
        }
        return $data;
    }
}

if(!function_exists('set_model_data')){
    /**
     * set model data để không bị query quá nhiều
     * @param string $model 
     * @param int $id
     * @param mixed $data
     */
    function set_model_data(string $model = 'post', $id = 0, $data = null)
    {
        $list = [
            'post', 'dynamic', 'page', 'product', 'project', 
            'category', 'post_category', 'project_category', 'product_category', 'product_attribute', 'user',
        ];
        if(in_array($model, $list)){
            set_web_data('model_data.'.$model.'.'.$id, $data);
        }
        return $data;
    }
}






if(!function_exists('set_pagination')){
    /**
     * thiết lập phân trang
     * @param mixed $pagination
     */
    function set_pagination($pagination)
    {
        set_web_data('__pagination', $pagination);
    }
}


if(!function_exists('get_pagination')){
    /**
     * lấy nút phân trang
     * @param string $blade
     * @param array $args
     * @return mixed
     */
    function get_pagination($blade, $args = [])
    {
        $pagination = get_web_data('__pagination');
        if($pagination){
            if($args){
                $pagination->appends($args);
            }
            return $pagination->links($blade, $args);
        }
        return null;
    }
}




if(!function_exists('set_current')){
    /**
     * cai dat du lieu hien tai
     * @param string $key
     * @param mixed $data
     */
    function set_current($key, $data)
    {
        set_web_data('__current__data__.'.str_slug($key), $data);
    }
}


if(!function_exists('get_current')){
    /**
     * lấy ra data hiện tai của một đối tượng thiết lập trước đó
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    function get_current($key, $default = null)
    {
        return get_web_data('__current__data__.'.str_slug($key), $default);
    }
}


if(!function_exists('set_active_model')){
    /**
     * cai dat du lieu hien tai
     * @param string $key
     * @param App\Models\Model $model
     */
    function set_active_model($key, $model)
    {
        set_model_data($key, $model->id, $model);
        set_web_data('__active__data__.'.str_slug($key), $model->id);
    }
}


if(!function_exists('get_active_model')){
    /**
     * lấy ra data hiện tai của một đối tượng thiết lập trước đó
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    function get_active_model($key, $default = null)
    {
        if($id = get_web_data('__active__data__.'.str_slug($key))){
            $model = get_model_data($key, $id);
            return $model?$model:$default;
        }

        return $default;
    }
}


if(!function_exists('get_slider')){
    /**
     * lấy dữ liệu slider
     * @param array|int $args
     * @return \App\Masks\Sliders\SliderMask
     */
    function get_slider($args = null)
    {
        $slider = app(SliderRepository::class)->getSlider($args);
        return $slider;
    }
}
if(!function_exists('get_slider_options')){
    /**
     * lấy dữ liệu slider
     * @param array $args
     * @return array
     */
    function get_slider_options($args = [])
    {
        return app(SliderRepository::class)->getDataOptions($args);
    }
}

