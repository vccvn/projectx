<?php

use App\Repositories\Crazy3D\CategoryRepository as Crazy3DCategoryRepository;
use App\Repositories\Projects\CategoryRepository;
use App\Repositories\Projects\ProjectRepository;



if (!function_exists('get_project_sortby_options')) {
    /**
     * thông tin sap xep san phẩm
     *
     * @return array
     */
    function get_project_sortby_options()
    {
        $options = get_general_config('projects.list.sortby', []);
        return $options;
    }
}


if(!function_exists('get_projects')){
    /**
     * lấy mục nội dung
     * @param array $params
     * @return \App\Models\Project[]
     */
    function get_projects($params = [])
    {
        return app(ProjectRepository::class)->mode('mask')->getData(get_parse_query_args($params));
    }
}


if(!function_exists('get_project')){
    /**
     * lấy mục nội dung
     * @param array $params
     * @return \App\Models\Project
     */
    function get_project($params = [])
    {
        return app(ProjectRepository::class)->mode('mask')->detail(get_parse_query_args($params));
    }
}



if(!function_exists('get_project_parent_category_options')){
    /**
     * lấy danh sách danh mục cha
     * @param mixed $max_level
     * @return array
     */
    function get_project_parent_category_options($max_level = 2){
        return CategoryRepository::getParentSelectOptions($max_level);
    }
}

if(!function_exists('get_project_category_options')){
    /**
     * lấy danh sách danh mục
     * @param mixed $args
     * @return array
     */
    function get_project_category_options($args = []){
        $params = array_filter($args, function($value){
            return is_string($value)?(strlen($value)>0):(is_array($value)?(count($value) > 0):true);
        });
        return CategoryRepository::getCategorySelectOptions(array_merge(['deleted' => 0], $params));
    }
}


if(!function_exists('get_product_category')){
    /**
     * lấy mục nội dung
     * @param array $params
     * @return \App\Models\Category
     */
    function get_project_category(array $params = [])
    {
        return app(CategoryRepository::class)->mode('mask')->first(get_parse_query_args($params));
    }
}


if (!function_exists('get_project_category_sortby_options')) {
    /**
     * thông tin sap xep danh mục dự án
     *
     * @return array
     */
    function get_project_category_sortby_options()
    {
        $options = get_general_config('categories.list.sortby', []);
        return $options;
    }
}

