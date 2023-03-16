<?php

use App\Repositories\Clients\ClientRepository;
use App\Repositories\Projects\CategoryRepository;
use App\Repositories\Projects\ProjectRepository;
use App\Repositories\Teams\MemberRepository;
use App\Repositories\Teams\TeamRepository;
use App\Repositories\Testimonials\TestimonialRepository;





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


if(!function_exists('get_clients')){
    /**
     * lấy danh sách khách hàng
     * @param array $params
     * @return \App\Masks\Clients\ClientMask
     */
    function get_clients(array $params = [])
    {
        return app(ClientRepository::class)->mode('mask')->getData(get_parse_query_args($params));
    }
}

if(!function_exists('get_client_options')){
    /**
     * lấy danh sách khách hàng dưới dạng option
     * @param mixed ...$params
     * @return array
     */
    function get_client_options(...$params)
    {
        return app(ClientRepository::class)->getDataOptions(...$params);
    }
}
if(!function_exists('get_team_options')){
    /**
     * lấy danh sách khách hàng dưới dạng option
     * @param mixed ...$params
     * @return array
     */
    function get_team_options(...$params)
    {
        return app(TeamRepository::class)->getDataOptions(...$params);
    }
}



if(!function_exists('get_team_members')){
    /**
     * lấy danh sách khách hàng
     * @param array $params
     * @return \App\Masks\Teams\MemberCollection
     */
    function get_team_members(array $params = [])
    {
        return app(MemberRepository::class)->cache('get-team-member', null, $params)->mode('mask')->getTeamMembers(get_parse_query_args($params));
    }
}




if(!function_exists('get_testimonials')){
    /**
     * lấy danh sách khách hàng
     * @param array $params
     * @return \App\Masks\Testimonials\TestimonialMask
     */
    function get_testimonials(array $params = [])
    {
        return app(TestimonialRepository::class)->mode('mask')->getData(get_parse_query_args($params));
    }
}


