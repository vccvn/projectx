<?php

use App\Repositories\Crazy3D\CategoryRepository;

if(!function_exists('get_3d_parent_category_options')){
    /**
     * lấy danh sách danh mục cha
     * @param mixed $max_level
     * @return array
     */
    function get_3d_parent_category_options($max_level = 2){
        return CategoryRepository::getParentSelectOptions($max_level);
    }
}


if(!function_exists('get_3d_category_options')){
    /**
     * lấy danh sách danh mục
     * @param mixed $args
     * @return array
     */
    function get_3d_category_options($args = []){
        $params = array_filter($args, function($value){
            return is_string($value)?(strlen($value)>0):(is_array($value)?(count($value) > 0):true);
        });
        return CategoryRepository::getCategorySelectOptions(array_merge(['deleted' => 0], $params));
    }
}
if(!function_exists('get_3d_support_extensions')){
    /**
     * lấy danh sách danh mục
     * @param mixed $args
     * @return array
     */
    function get_3d_support_extensions(){
        return get_3d_config('supported_file_extensions');
    }
    
}



if(!function_exists('get_3d_status_options')){
    /**
     * lấy thông tin cấu hình cho hệ thống thanh toán
     *
     * @param string $key
     * @return Arr|mixed
     */
    function get_3d_status_options(){
        $data = [];
        if($methods = get_3d_config('status_list')){
            $data = $methods;
        }
        // dd($data);
        return $data;
        
    }
}