<?php

use App\Web\Config;
use App\Web\Options;

use App\Web\Data;
use Crazy\Helpers\Arr;

if(!function_exists('set_web_data')){
    /**
     * chia sẻ dữ liệu
     * @param string $key
     * @param mixed $value
     * @return boolean
     */
    function set_web_data($key, $value = null)
    {
        return Data::set($key, $value);
    }
}

if(!function_exists('get_web_data')){
    /**
     * lấy dữ liệu
     * @param string $key
     * @return mixed
     */
    function get_web_data($key)
    {
        return Data::get($key);
    }
}






if(!function_exists('get_web_type')){
    /**
     * lấy loại web
     *
     * @return string
     */
    function get_web_type(){
        $owner = get_owner();
        $web_type = $owner?$owner->userWebSetting->web_type:env('APP_WEB_TYPE', 'default');
        return $web_type;
    }
}



if(!function_exists('get_cfg_domains')){
    /**
     * lay ve danh sach ten mien
     * @return array
     */
    function get_cfg_domains()
    {
        static $domains = [];
        if(!count($domains)){
            $domains = explode(',', str_replace(' ', '', env('APP_BASE_DOMAIN_LIST')));
            
            // get_system_config('domain_list');
        }
        return $domains;
    }
}


if(!function_exists('get_cfg_domain_options')){
    /**
     * lay ve danh sach ten mien
     * @return array
     */
    function get_cfg_domain_options()
    {
        static $domains = [];
        if(!count($domains)){
            $db = get_cfg_domains();

            if(count($db)){
                foreach ($db as $dm) {
                    $domains[$dm] = '.'.$dm;
                }
            }
        }
        return $domains;
    }
}




if(!function_exists('get_domain')){
    /**
     * lấy tên miên dược cấu hình
     */
    function get_domain()
    {
        static $domain = null;
        if(!$domain) {
            $domain = strtolower(isset($_SERVER['SERVER_NAME'])?$_SERVER['SERVER_NAME']:(isset($_SERVER['HTTP_HOST'])?$_SERVER['HTTP_HOST']:'localhost'));
        }
        return $domain;
    }
}
if(!function_exists('get_non_www_domain')){
    /**
     * lấy tên miên dược ko chứa www
     */
    function get_non_www_domain()
    {
        static $domain = null;
        if(!$domain) {
            $domain = preg_replace('/^www\./', '', get_domain());
        }
        return $domain;
    }
}



if(!function_exists('get_cfg_domain')){
    /**
     * lấy tên miên dược cấu hình
     */
    function get_cfg_domain()
    {
        static $domain = null;
        if(!$domain) {
            if($list = get_cfg_domains()){
                $d = null;
                $server = get_domain();
                foreach($list as $dm){
                    $sub = str_replace(strtolower($dm), '', $server);
                    // dd($sub);
                    if($sub!=$server){
                        $domain = $dm;
                        return $dm;
                    }
                }
            }

        }
        return $domain;
    }
}


if(!function_exists('get_subdomain')){
    /**
     * lấy thông tin subdomain
     */
    function get_subdomain(){

        if(!isset($_SERVER) || (!isset($_SERVER['SERVER_NAME']) && !isset($_SERVER['HTTP_HOST']))) return null;
        $server = get_domain();

        if($server!='localhost'){
            $domain = get_cfg_domain();
            // dd($domain);
            $sub = str_replace('.'.strtolower($domain), '', $server);
            // dd($sub);
            if($sub!=$server) return $sub;
        }
        return null;
    }
}


if(!function_exists('get_sys_subdomain')){
    /**
     * lấy thông tin subdomain
     */
    function get_sys_subdomain(){

        if(!isset($_SERVER) || (!isset($_SERVER['SERVER_NAME']) && !isset($_SERVER['HTTP_HOST']))) return null;
        $server = get_domain();

        if($server!='localhost'){
            $domain = get_cfg_domain();
            // dd($domain);
            $sub = str_replace('.'.strtolower($domain), '', $server);
            // dd($sub);
            if($domain && $sub!=$server) return $sub;
        }
        return null;
    }
}
if(!function_exists('is_subdomain')){
    /**
     * lấy thông tin subdomain
     */
    function is_subdomain(){
        return get_web_data('___domain_type') == 'subdomain';
    }
}




if(!function_exists('get_session_domain')){
    /**
     * lấy về tên miền có hiệu lực với session
     * @return string
     */
    function get_session_domain(){
        static $session_domain = null;
        if(!$session_domain){
            if(($cfg = get_cfg_domain()) && $sub = get_sys_subdomain()){
                $session_domain = '.'.$cfg;
            }
        }
        return $session_domain;
    }
}



if(!function_exists('webconfig')){
    /**
     * lấy thong6tin mục config
     *
     * @param string $name
     * @return Arr
     */
    function webconfig($name = null){
        $config = Config::getConfig();
        if(!$name) return $config;
        if(!$config) return null;
        $list = ['system', 'user', 'web', 'general', "ecommerce", 'mailer', 'payments'];
        if(in_array($n = strtolower($name), $list))
            return $config->{$n};
        return null;
    }
}


if(!function_exists('get_user_config')){
    /**
     * lấy thông tin cấu hình cho user
     *
     * @param string $key
     * @return mixed
     */
    function get_user_config($key = null, $default = null){
        if($user = webconfig('user')){
            if(!is_null($key)) return $user->get($key, $default);
            return $user;
        }
        return null;
    }
}

if(!function_exists('get_system_config')){
    /**
     * lấy thông tin cấu hình cho hệ thống
     *
     * @param string $key
     * @return mixed
     */
    function get_system_config($key = null, $default = null){
        if($system = webconfig('system')){
            if(!is_null($key)) return $system->get($key, $default);
            return $system;
        }
        return null;
    }
}

if(!function_exists('get_ecommerce_config')){
    /**
     * lấy thông tin cấu hình cho hệ thống tmdt
     *
     * @param string $key
     * @return mixed
     */
    function get_ecommerce_config($key = null, $default = null){
        if($ecommerce = webconfig('ecommerce')){
            if(!is_null($key)) return $ecommerce->get($key, $default);
            return $ecommerce;
        }
        return null;
    }
}




if(!function_exists('get_general_config')){
    /**
     * lấy thông tin cấu hình chung
     *
     * @param string $key
     * @return mixed
     */
    function get_general_config($key = null, $default = null){
        if($general = webconfig('general')){
            if(!is_null($key)) return $general->get($key, $default);
            return $general;
        }
        return null;
    }
}
if(!function_exists('get_personal_config')){
    /**
     * lấy thông tin cấu hình chung
     *
     * @param string $key
     * @return mixed
     */
    function get_personal_config($key = null, $default = null){
        if($personal = webconfig('personal')){
            if(!is_null($key)) return $personal->get($key, $default);
            return $personal;
        }
        return null;
    }
}

if(!function_exists('web_cfg')){
    /**
     * lấy thông tin cấu hình web
     *
     * @param string $key
     * @return mixed
     */
    function web_cfg($key = null, $default = null){
        if($web = webconfig('web')){
            if(!is_null($key)) return $web->get($key, $default);
            return $web->all();
        }
        return $default;
    }
}



if(!function_exists('get_web_module_list')){
    /**
     * lấy danh sách module cho web
     *
     * @param string $web_type
     * @return array
     */
    function get_web_module_list($web_type = 'default'){
        $module_list = get_system_config('package_modules');
        $base = $module_list['base'];

        $modules = [];
        $account_type = web_setting('account_type', 'demo');
        if(isset($module_list[$web_type]) && isset($module_list[$web_type][$account_type])){
            $modules = $module_list[$web_type][$account_type];
        }
        return array_merge($base, $modules);
    }
}


if(!function_exists('get_option')){

    /**
     * lấy thông tin option
     *
     * @param string $key
     * @param mixed $default
     * @return \App\Web\Options|\App\Web\Option|\Crazy\Helpers\Arr|string|float|integer
     */
    function get_option($key = null, $default = null){
        static $options = null;
        if(!$options) $options = new Options();
        if(!$options) return $default;
        if(!$key) return $options;
        return $options->get($key, $default);
    }
}

if(!function_exists('get_setting')){

    /**
     * lấy thông tin option
     *
     * @param string $key
     * @param mixed $default
     * @return \App\Web\Options|\Crazy\Helpers\Arr|string|float|integer
     */
    function get_setting($key = null, $default = null){
        static $settings = null;
        if(!$settings) $settings = get_option('settings');
        if(!$settings) return $default;
        return $settings->get($key, $default);
    }
}

if(!function_exists('get_theme_option')){

    /**
     * lấy thông tin option
     *
     * @param string $key
     * @param mixed $default
     * @return \App\Web\Options|\Crazy\Helpers\Arr|string|float|integer
     */
    function get_theme_option($key = null, $default = null){
        static $theme = null;
        if(!$theme) $theme = get_option('theme');
        if(!$theme) return $default;
        if(!$key) return $theme;
        return $theme->get($key, $default);
    }
}
if(!function_exists('theme_option')){

    /**
     * lấy thông tin option
     *
     * @param string $key
     * @param mixed $default
     * @return \App\Web\Options|\Crazy\Helpers\Arr|string|float|integer
     */
    function theme_option($key = null, $default = null){
        static $theme = null;
        if(!$theme) $theme = get_option()->theme;
        if(!$theme) return $default;
        if(!$key) return $theme;
        return $theme->get($key, $default);
    }
}


if(!function_exists('system_setting')){

    /**
     * lấy thông tin setting system
     *
     * @param string $key
     * @param mixed $default
     * @return \Crazy\Helpers\Arr|string|float|integer
     */
    function system_setting($key = null, $default = null){
        static $system = null;
        if(!$system) $system = get_setting('system');
        if(!$system) return $default;
        if(is_null($key)) return $system;
        return $system->get($key, $default);
    }
}
if(!function_exists('setting')){

    /**
     * lấy thông tin setting system
     *
     * @param string $key
     * @param mixed $default
     * @return \Crazy\Helpers\Arr|string|float|integer
     */
    function setting($key = null, $default = null){
        static $system = null;
        if(!$system) $system = get_setting('system');
        if(!$system) return $default;
        if(is_null($key)) return $system;
        return $system->get($key, $default);
    }
}


if(!function_exists('siteinfo')){

    /**
     * lấy thông tin siteinfo
     *
     * @param string $key
     * @param mixed $default
     * @return \Crazy\Helpers\Arr|string|float|integer
     */
    function siteinfo($key = null, $default = null){
        static $siteinfo = null;
        if(!$siteinfo) $siteinfo = get_setting('siteinfo');
        if(!$siteinfo) return $default;
        if(is_null($key)) return $siteinfo;
        return $siteinfo->get($key, $default);
    }
}

if(!function_exists('get_display_setting')){
    /**
     * lấy thông tin siteinfo
     *
     * @param string $key
     * @param mixed $default
     * @return \Crazy\Helpers\Arr|string|float|integer
     */
    function get_display_setting($key = null, $default = null){
        static $setting = null;
        if(!$setting) $setting = get_setting('display');
        if(!$setting) return $default;
        if(is_null($key)) return $setting;
        return $setting->get($key, $default);
    }
}


if(!function_exists('get_ecommerce_setting')){

    /**
     * lấy thông tin ecommerce
     *
     * @param string $key
     * @param mixed $default
     * @return \Crazy\Helpers\Arr|string|float|integer
     */
    function get_ecommerce_setting($key = null, $default = null){
        static $ecommerce = null;
        if(!$ecommerce) $ecommerce = get_setting('ecommerce');
        if(!$ecommerce) return $default;
        if(is_null($key)) return $ecommerce;
        return $ecommerce->get($key, $default);
    }
}

if(!function_exists('get_payment_setting')){

    /**
     * lấy thông tin payment
     *
     * @param string $key
     * @param mixed $default
     * @return \Crazy\Helpers\Arr|string|float|integer
     */
    function get_payment_setting($key = null, $default = null){
        static $payment = null;
        if(!$payment) $payment = get_setting('payments');
        if(!$payment) return $default;
        if(is_null($key)) return $payment;
        return $payment->get($key, $default);
    }
}


if(!function_exists('ecommerce_setting')){

    /**
     * lấy thông tin ecommerce
     *
     * @param string $key
     * @param mixed $default
     * @return \Crazy\Helpers\Arr|string|float|integer
     */
    function ecommerce_setting($key = null, $default = null){
        return get_ecommerce_setting($key, $default);
    }
}

if(!function_exists('payment_setting')){

    /**
     * lấy thông tin payment
     *
     * @param string $key
     * @param mixed $default
     * @return \Crazy\Helpers\Arr|string|float|integer
     */
    function payment_setting($key = null, $default = null){
        return get_payment_setting($key, $default);
    }
}

if(!function_exists('post_setting')){

    /**
     * lấy thông tin post
     *
     * @param string $key
     * @param mixed $default
     * @return \Crazy\Helpers\Arr|string|float|integer
     */
    function post_setting($key = null, $default = null){
        static $options = null;
        if(!$options) $options = get_setting('posts');
        if(!$options) return $default;
        if(is_null($key)) return $options;
        return $options->get($key, $default);
    }
}




if(!function_exists('product_setting')){

    /**
     * lấy thông tin product
     *
     * @param string $key
     * @param mixed $default
     * @return \Crazy\Helpers\Arr|string|float|integer
     */
    function product_setting($key = null, $default = null){
        static $options = null;
        if(!$options) $options = get_setting('products');
        if(!$options) return $default;
        if(is_null($key)) return $options;
        return $options->get($key, $default);
    }
}

if(!function_exists('project_setting')){

    /**
     * lấy thông tin project
     *
     * @param string $key
     * @param mixed $default
     * @return \Crazy\Helpers\Arr|string|float|integer
     */
    function project_setting($key = null, $default = null){
        static $options = null;
        if(!$options) $options = get_setting('projects');
        if(!$options) return $default;
        if(is_null($key)) return $options;
        return $options->get($key, $default);
    }
}



if(!function_exists('get_post_default_meta')){

    /**
     * lấy thông tin setting default meta
     *
     * @param string $key
     * @param mixed $default
     * @return \Crazy\Helpers\Arr|string|float|integer
     */
    function get_post_default_meta($prefix = null, $key = null, $default = null){
        static $meta = null;
        if(!$meta) $meta = get_setting('default');
        if(!$prefix) return $meta;

        $p = $meta->makeByPrefix($prefix.'_');
        if(is_null($key)) return $p;

        $a = $p->get($key, $default);
        if($a == null) $a = $meta->get('general_'. $key, $default);
        return $a;
    }
}

if(!function_exists('get_post_default_meta_on_create')){

    /**
     * lấy thông tin setting default meta
     * @param int $id
     * @param string $key
     * @param mixed $default
     * @return \Crazy\Helpers\Arr|string|float|integer
     */
    function get_post_default_meta_on_create($id = null, $prefix = null, $key = null, $default = null){
        return $id ? null : get_post_default_meta($prefix, $key, $default);
    }
}




if(!function_exists('get_mailer_setting')){

    /**
     * lấy thông tin mailer
     *
     * @param string $key
     * @param mixed $default
     * @return \Crazy\Helpers\Arr|string|float|integer
     */
    function get_mailer_setting($key = null, $default = null){
        static $mailer = null;
        if(!$mailer) {
            if(get_sys_subdomain() == 'manager') $mailer = new Arr();
            else $mailer = get_setting('mailer');
        }
        if(is_null($key)) return $mailer;
        return $mailer->get($key, $default);
    }
}
if(!function_exists('mailer')){

    /**
     * lấy thông tin mailer
     *
     * @param string $key
     * @param mixed $default
     * @return \Crazy\Helpers\Arr|string|float|integer
     */
    function mailer($key = null, $default = null){
        return get_mailer_setting($key, $default);
    }
}








if(!function_exists('web_setting')){

    /**
     * lấy thông tin siteinfo
     *
     * @param string $key
     * @param mixed $default
     * @return \App\Models\WebSetting|string|float|integer
     */
    function web_setting($key = null, $default = null){
        static $web_setting = null;
        if(!$web_setting) $web_setting = get_web_data('__owner_web_setting');

        if(is_null($key)) {

            return $web_setting;
        }
        return $web_setting->{$key}??$default;
    }
}




if(!function_exists('get_payment_config')){
    /**
     * lấy thông tin cấu hình cho hệ thống thanh toán
     *
     * @param string $key
     * @return Arr|mixed
     */
    function get_payment_config($key = null, $default = null){
        if($payments = webconfig('payments')){
            if(!is_null($key)) return $payments->get($key, $default);
            return $payments;
        }
        return null;
    }
}


if(!function_exists('get_payment_select_options')){
    /**
     * lấy thông tin cấu hình cho hệ thống thanh toán
     *
     * @param string $key
     * @return Arr|mixed
     */
    function get_payment_select_options(){
        $data = [];
        if($methods = get_payment_config('methods')){

            foreach ($methods as $key => $method) {
                $data[$method['key']] = $method['title'];
            }
        }

        return $data;

    }
}


if(!function_exists('get_payment_method_inputs')){
    /**
     * lấy thông tin input của method
     * @param string $method
     * @param array $data
     * @return Arr|array
     */
    function get_payment_method_inputs($method, $data = []){
        if($methods = get_payment_config('methods')){

            foreach ($methods as $xkey => $methodData) {
                if($method == $methodData['key'] && isset($methodData['inputs']))
                {
                    $inputs = $methodData['inputs'];
                    if(is_array($data) && $data){
                        foreach ($data as $key => $value) {
                            if(isset($inputs[$key])){
                                $inputs[$key]['value'] = $value;
                            }
                        }
                    }
                    $methodData['inputs'] = $inputs;
                    return $methodData;
                }

            }
        }
        return [];

        return $data;

    }
}
if(!function_exists('get_payment_method_config_data')){
    /**
     * lấy thông tin input của method
     * @param string $method
     * @param array $data
     * @return Arr|array
     */
    function get_payment_method_config_data($method){
        if($methods = get_payment_config('methods')){

            if(array_key_exists($method, $methods) && array_key_exists('data', $methods[$method])){
                $d = [];
                foreach ($methods[$method]['data'] as $key => $value) {
                    $d[$key] = new Arr($value);
                }
                return new Arr($d);
            }

        }
        return [];

    }
}
