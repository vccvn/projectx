<?php

use App\Engines\Breakcrumb;
use App\Repositories\Categories\CategoryRepository;
use App\Repositories\Customers\CustomerRepository;
use App\Repositories\Orders\OrderRepository;
use App\Repositories\Clients\ClientRepository;
use App\Repositories\Locations\DistrictRepository;
use App\Repositories\Locations\RegionRepository;
use App\Repositories\Locations\WardRepository;
use App\Repositories\Sliders\SliderRepository;
use App\Repositories\Sliders\ItemRepository;
use App\Repositories\Files\FileRepository;
use App\Repositories\Forms\FormRepository;
use App\Repositories\Metadatas\MetadataRepository;

define("SYSTEM_RANDOM_STRING", md5(uniqid() . time() . rand(1000, 9999)));

if (!function_exists('json_path')) {
    /**
     * lấy dường dẫn từ thư mục json
     * @param string $path
     * @return string
     */
    function json_path($path = null)
    {
        return base_path('json') . ($path ? '/' . ltrim($path, '/') : '');
    }
}

if (!function_exists('get_client_file_uploads')) {
    /**
     * lấy file mà người dùng đạ upload len và được lưu trong mục quản lý file
     * @param array $args
     * 
     * @return Collection
     */
    function get_client_file_uploads(array $args = [])
    {
        if (!isset($args['ref_id']) || !$args['ref_id']) return [];
        return (new FileRepository())->get($args);
    }
}

if (!function_exists('get_media_file')) {
    /**
     * lấy file mà người dùng đạ upload len và được lưu trong mục quản lý file
     * @param array $args
     * 
     * @return Collection
     */
    function get_media_file(array $args = [])
    {
        return (new FileRepository())->mode('mask')->detail($args);
    }
}


if (!function_exists('get_ref_files')) {
    /**
     * lấy file mà người dùng đạ upload len và được lưu trong mục quản lý file
     * @param array $args
     * 
     * @return Collection
     */
    function get_ref_files(array $args = [])
    {
        if (!isset($args['ref_id']) || !$args['ref_id']) return [];
        $params = [];
        foreach ($args as $key => $value) {
            if (in_array($key, ['ref', 'ref_id'])) {
                $params['file_refs.' . $key] = $value;
            } else {
                $params[$key] = $value;
            }
        }
        return (new FileRepository())->join('file_refs', 'file_refs.file_id', '=', 'files.id')->select('files.*')->get($params);
    }
}



if (!function_exists('get_customer_select_options')) {
    /**
     * lấy danh khách hàng
     * @param array $args
     */
    function get_customer_select_options(array $args = [])
    {
        $data = [' -- Chọn một  -- '];
        $rep = new CustomerRepository();
        $params = array_filter($args, function ($value) {
            return is_string($value) ? (strlen($value) > 0) : (is_array($value) ? (count($value) > 0) : true);
        });
        if ($list = $rep->get(array_merge(['@limit' => 10, '@order_by' => 'RAND()', 'deleted' => 0], $params))) {
            foreach ($list as $item) {
                $data[$item->id] = $item->name;
            }
        }
        return $data;
    }
}


if (!function_exists('get_order_select_options')) {
    /**
     * lấy danh sách sản phẩm
     * @param array $args
     */
    function get_order_select_options(array $args = [])
    {
        $data = [' -- Chọn một  -- '];
        $rep = new OrderRepository();
        $params = array_filter($args, function ($value) {
            return is_string($value) ? (strlen($value) > 0) : (is_array($value) ? (count($value) > 0) : true);
        });
        if ($list = $rep->get(array_merge(['@limit' => 10, '@order_by' => ['id' => 'DESC'], 'deleted' => 0], $params))) {
            foreach ($list as $item) {
                $data[$item->id] = 'Đơn hàng #' . $item->id;
            }
        }
        return $data;
    }
}


if (!function_exists('get_client_select_options')) {
    /**
     * lấy danh khách hàng
     * @param array $args
     */
    function get_client_select_options(array $args = [], ...$params)
    {
        $rep = new ClientRepository();
        $pars = array_filter($args, function ($value) {
            return is_string($value) ? (strlen($value) > 0) : (is_array($value) ? (count($value) > 0) : true);
        });
        return $rep->getDataOptions($pars, ...$params);
    }
}



if (!function_exists('get_web_data')) {
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


if (!function_exists('set_web_data')) {
    /**
     * lưu data
     * @param string|array $args
     */
    function set_web_data($key, $value = null)
    {
        return App\Web\Data::set($key, $value);
    }
}

if (!function_exists('get_slider_active_id')) {
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

if (!function_exists('admin_slider_item_url')) {
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
            $url = route('admin.sliders.items.' . $module, $params);
        } elseif ($slider = get_web_data('slider')) {
            $url = route('admin.sliders.items.' . $module, array_merge($params, [
                'slider' => $slider->id,
            ]));
        }
        return $url;
    }
}



if (!function_exists('admin_check_slider')) {
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
        if ($isCheck) return $status;
        $request = request();

        if (($slider_id = $request->route('slider')) && $slider = (new SliderRepository)->first(['id' => $slider_id, 'deleted' => 0])) {
            $isCheck = true;
            if ($slider->deleted) {
                $status = false;
            } else {
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





if (!function_exists('get_category')) {
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



if (!function_exists('get_categories')) {
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






if (!function_exists('check_model_data')) {
    /**
     * lấy thông tin của data theo model nào đó
     * @param string $model 
     * @param int $id
     * @return bool
     */
    function check_model_data(string $model = 'post', $id = 0)
    {
        return get_web_data('model_data.' . $model . '.' . $id) ? true : false;
    }
}

if (!function_exists('get_model_data')) {
    /**
     * lấy thông tin của data theo model nào đó
     * @param string $model 
     * @param int $id
     * @param bool $getifnotexists
     * @return \App\Models\Model
     */
    function get_model_data(string $model = 'post', $id = 0, $getifnotexists = true)
    {
        $list = [
            'post', 'dynamic', 'page', 'product', 'project',
            'category', 'post_category', 'project_category', 'product_category',
            'product_attribute', 'user', 'owner_user'
        ];
        if (!($data = get_web_data('model_data.' . $model . '.' . $id))) {
            if ($getifnotexists && in_array($model, $list) && function_exists($fn = 'get_' . $model)) {
                $data = call_user_func_array('get_' . $model, [['id' => $id]]);
                set_web_data('model_data.' . $model . '.' . $id, $data);
            }
        }
        return $data;
    }
}

if (!function_exists('set_model_data')) {
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
            'category', 'post_category', 'project_category', 'product_category',
            'product_attribute', 'user', 'owner_user'
        ];
        if (in_array($model, $list)) {
            set_web_data('model_data.' . $model . '.' . $id, $data);
        }
        return $data;
    }
}





if (!function_exists('set_pagination')) {
    /**
     * thiết lập phân trang
     * @param mixed $pagination
     */
    function set_pagination($pagination)
    {
        set_web_data('__pagination', $pagination);
    }
}


if (!function_exists('get_pagination')) {
    /**
     * lấy nút phân trang
     * @param string $blade
     * @param array $args
     * @return mixed
     */
    function get_pagination($blade, $args = [])
    {
        $pagination = get_web_data('__pagination');
        if ($pagination) {
            if ($args) {
                $pagination->appends($args);
            }
            return $pagination->links($blade, $args);
        }
        return null;
    }
}




if (!function_exists('set_current')) {
    /**
     * cai dat du lieu hien tai
     * @param string $key
     * @param mixed $data
     */
    function set_current($key, $data)
    {
        set_web_data('__current__data__.' . str_slug($key), $data);
    }
}


if (!function_exists('get_current')) {
    /**
     * lấy ra data hiện tai của một đối tượng thiết lập trước đó
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    function get_current($key, $default = null)
    {
        return get_web_data('__current__data__.' . str_slug($key), $default);
    }
}


if (!function_exists('set_active_model')) {
    /**
     * cai dat du lieu hien tai
     * @param string $key
     * @param App\Models\Model $model
     */
    function set_active_model($key, $model)
    {
        if (!check_model_data($key, $model->id)) {
            set_model_data($key, $model->id, $model);
        }
        set_web_data('__active__data__.' . str_slug($key), $model->id);
    }
}




if (!function_exists('get_active_model')) {
    /**
     * lấy ra data hiện tai của một đối tượng thiết lập trước đó
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    function get_active_model($key, $default = null)
    {
        if (is_array($key)) {
            foreach ($key as $k => $v) {
                if ($id = get_web_data('__active__data__.' . str_slug($v))) {
                    $model = get_model_data($v, $id);
                    return $model ? $model : $default;
                }
            }
        } else {
            if ($id = get_web_data('__active__data__.' . str_slug($key))) {
                $model = get_model_data($key, $id);
                return $model ? $model : $default;
            }
        }

        return $default;
    }
}

if (!function_exists('get_slider')) {
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
if (!function_exists('get_slider_options')) {
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



if (!function_exists('get_region_options')) {
    /**
     * lấy dữ liệu tỉnh
     * @param array $args
     * @return array
     */
    function get_region_options($args = [], $defaultFirst = "Chọn một")
    {
        return app(RegionRepository::class)->getDataOptions($args, $defaultFirst);
    }
}


if (!function_exists('get_district_options')) {
    /**
     * lấy dữ liệu huyện
     * @param array $args
     * @return array
     */
    function get_district_options($args = [], $defaultFirst = "Chọn một")
    {
        return app(DistrictRepository::class)->getDataOptions($args, $defaultFirst);
    }
}
if (!function_exists('get_ward_options')) {
    /**
     * lấy dữ liệu xã
     * @param array $args
     * @return array
     */
    function get_ward_options($args = [], $defaultFirst = "Chọn một")
    {
        return app(WardRepository::class)->getDataOptions($args, $defaultFirst);
    }
}



if (!function_exists('get_contact_form_options')) {
    /**
     * lấy dữ liệu xã
     * @param array $args
     * @return array
     */
    function get_contact_form_options($args = [], $defaultFirst = "Form Mặc định")
    {
        $repository = new FormRepository;
        return $repository->getDataOptions($args, $defaultFirst);
    }
}

if (!function_exists('get_forms')) {
    /**
     * lấy dữ liệu xã
     * @param array $args
     * @return array
     */
    function get_forms($args = [])
    {
        $repository = new FormRepository;
        return $repository->mode('mask')->getData($args);
    }
}

if (!function_exists('get_form')) {
    /**
     * lấy dữ liệu xã
     * @param array $args
     * @return array
     */
    function get_form($args = [])
    {
        $repository = new FormRepository;
        return $repository->mode('mask')->detail($args);
    }
}



if (!function_exists('get_metadatas')) {

    /**
     * lấy dữ liệu meta
     *
     * @param string $ref
     * @param int $ref_id
     * @param boolean $convert_to_crazy_object
     * @return array|\Crazy\Helpers\Arr|null
     */
    function get_metadatas($ref = 'data', $ref_id = SYSTEM_RANDOM_STRING, $convert_to_crazy_object = false)
    {
        $metadata = app(MetadataRepository::class)->getMetaMeta($ref, $ref_id);
        return $metadata && $ref_id != SYSTEM_RANDOM_STRING && $convert_to_crazy_object ? crazy_arr($metadata) : $metadata;
    }
}




if (!function_exists('get_metadata')) {

    /**
     * lấy dữ liệu meta
     *
     * @param string $ref
     * @param int $ref_id
     * @param string $name
     * @param mixed $default
     * @param boolean $convert_to_crazy_object
     * @return array|\Crazy\Helpers\Arr|null
     */
    function get_metadata($ref = 'data', $ref_id = 0, $name = null, $default = null, $convert_to_crazy_object = false)
    {
        $metadata = app(MetadataRepository::class)->getMetaMeta($ref, $ref_id);
        if($metadata){
            if($name != null)
                return array_key_exists($name, $metadata) ? $metadata[$name] : $default;
            return $convert_to_crazy_object ? crazy_arr($metadata): $metadata;
        }
        if($name!==null) return $default;
        if($convert_to_crazy_object) return null;
        return [];
    }
}
