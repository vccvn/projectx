<?php

use App\Repositories\Crawlers\FrameRepository;
use App\Engines\MenuEngine;
use App\Repositories\Crawlers\PostFrameRepository;
use App\Repositories\Crawlers\ProductFrameRepository;

if(!function_exists('get_crawler_frame_options')){
    /**
     * lấy danh sách option staffs
     */
    function get_crawler_frame_options(array $args = []){
        return FrameRepository::getFrameSelectOptions($args);
    }
}
if(!function_exists('get_crawler_post_frame_options')){
    /**
     * lấy danh sách option staffs
     */
    function get_crawler_post_frame_options(array $args = []){
        return PostFrameRepository::getFrameSelectOptions($args);
    }
}
if(!function_exists('get_crawler_product_frame_options')){
    /**
     * lấy danh sách option staffs
     */
    function get_crawler_product_frame_options(array $args = []){
        return ProductFrameRepository::getFrameSelectOptions($args);
    }
}


if(!function_exists('get_admin_menu')){
    /**
     * lấy về mảng thông tin menu
     * @param string $filename
     * @return array
     */
    function get_admin_menu($filename = null){
        // DynamicPost::check($request);
        if(!$filename) $filename = 'admin';
        $menu = new MenuEngine('admin/menus');
        return $menu->get($filename);

    }
}



if(!function_exists('admin_breadcrumbs')){
    /**
     * khai báo breadcrumbs
     * @param array $breadcrumbs
     * @return array
     */
    function admin_breadcrumbs($breadcrumbs = null){
        static $crumbs = [];
        if(is_null($breadcrumbs)) return $crumbs;
        if(is_array($breadcrumbs)) $crumbs = array_merge($crumbs, $breadcrumbs);
        return false;
    }
}



if(!function_exists('manager_breadcrumbs')){
    /**
     * khai báo breadcrumbs
     * @param array $breadcrumbs
     * @return array
     */
    function manager_breadcrumbs($breadcrumbs = null){
        static $crumbs = [];
        if(is_null($breadcrumbs)) return $crumbs;
        if(is_array($breadcrumbs)) $crumbs = $breadcrumbs;
        return false;
    }
}



if(!function_exists('manager_action_menu')){
    /**
     * khai báo breadcrumbs
     * @param array $breadcrumbs
     * @return array
     */
    function manager_action_menu($actionmenus = null){
        $menus = get_web_data('manager_action_menu')??[];
        if(is_null($actionmenus)) return $menus;
        if(is_array($actionmenus)) $menus = array_merge($menus, $actionmenus);
        set_web_data('manager_action_menu', $menus);
        return true;
    }
}





if(!function_exists('admin_action_menu')){
    /**
     * khai báo breadcrumbs
     * @param array $breadcrumbs
     * @return array
     */
    function admin_action_menu($actionmenus = null){
        $menus = get_web_data('admin_action_menu')??[];
        if(is_null($actionmenus)) return $menus;
        if(is_array($actionmenus)) $menus = array_merge($menus, $actionmenus);
        set_web_data('admin_action_menu', $menus);
        return true;
    }
}


if(!function_exists('get_menu_type_options')){
    /**
     * lay danh sach option cua menu type theo loai web
     */
    function get_menu_type_options(){
        static $data = null;
        if($data) $data = null;
        $owner = get_owner();
        $data = ['default' => 'Mặc định'];
        switch ($owner->web_type) {
            case 'ecomerce':
                $data['product'] = "Danh mục sản phẩm";
                break;
            case 'business':
            case 'portfolio':
                $data['project'] = "Danh mục dự án";
                break;
            
            default:
                # code...
                break;
        }
        if(count_dynamic(['use_category' => 1])){
            $data['post'] = "Danh mục bài viết";
        }
        return $data;
    }
}

if(!function_exists('set_admin_template_data')){
    function set_admin_template_data($list_name, $template)
    {
        $data = get_admin_template_data($list_name);
        if(!in_array($template, $data)) $data[] = $template;
        set_web_data('admin_templates.'.$list_name, $data);
    }
}

if(!function_exists('get_admin_template_data')){
    function get_admin_template_data($list_name)
    {
        if(!is_array($data = get_web_data('admin_templates.'.$list_name, []))) $data = [];
        return $data;
    }
}

