<?php
namespace App\Engines;

use App\Repositories\Html\AreaRepository;
use App\Web\HtmlAreaList;
use App\Web\Options;
use Crazy\Files\Filemanager;
use Crazy\Helpers\Arr;

class ViewManager
{
    static $shared = false;

    static $themeFolder = '';
    public static function share($name = null, $value=null)
    {
        if(static::$shared) return true;
        $a = $name?(is_array($name)?$name:(is_string($name)?[$name=>$value]: [])):[];
        $owner = get_owner();
        $options = new Options();
        $options->updateCache();
        set_web_data('options', $options);
        $siteinfo = siteinfo();
        $ecommerce = ecommerce_setting();
        $payment = $options->settings->payments;
        $favicons = $options->settings->favicons??new Arr();
        $settings = system_setting();
        $helper = new Helper();
        $request = request();
        $current_url = $request->getRequestUri();
        $theme = get_active_theme();
        $html = new HtmlAreaList(
            app(AreaRepository::class)->cache('component-areas-'.$theme->id, $settings->cache_data_time?$settings->cache_data_time:0)->mode('mask')->getAreaData()
        );
        // dd($html->post_settings->components->getComponents()[0]->data->all());
        set_web_data('__html__', $html);
        static::$themeFolder = 'clients.'.theme_path(null, true);
        $d = static::$themeFolder . '.';
        $m = $d . ($theme->mobile_version != 'dual' ? '' : (
            is_mobile() ? 'mobile.' : 'desktop.'
        ));
        view()->share(array_merge(
            $a,
            compact('options', 'siteinfo', 'settings', 'ecommerce', 'payment', 'html', 'helper', 'current_url', 'request', 'favicons'), 
            [
                '_component' => $d . 'components.',
                '_template' => $m . 'templates.',
                '_layout' => $m . 'layouts.',
                '_module' => $m . 'modules.',
                '_base' => $d,
                '_theme' => $d,
                '_lib' => 'client-libs.' 
            ]
        ));
        static::$shared = true;
        if($theme = get_active_theme()){
            if($theme->slug){
                $filemanager = new Filemanager();
                $list = $filemanager->getList(base_path('themes/containers/'.$theme->slug.'/helpers'), 'php');
                if($list){
                    foreach ($list as $file) {
                        require_once $file->path;
                    }
                }
            }
        }

        return true;
    }

    /**
     * lấy view trong theme
     *
     * @param string $blade
     * @param array $data
     * @param bool $only_blade_path
     * @return \Illuminate\View\View
     */
    public static function theme($blade, $data = [], $only_blade_path = false)
    {
        $d = static::$themeFolder . '.';
        $theme = get_active_theme();
        if(!$only_blade_path && $theme->mobile_version == 'dual'){
            $f = is_mobile() ? 'mobile.' : 'desktop.';

            $bp = $d . $f . $blade;
        }else{
            $bp = $d .  $blade;
        }
        

        $a = explode('.', $bp);
        $b = array_pop($a);
        $current = implode('.', $a) . '.';
        $remove_list = ['siteinfo', 'settings', 'options', 'html'];
        foreach ($remove_list as $key => $varName) {
            unset($data[$varName]);
        }
        $viewdata = array_merge($data, ['_current' => $current]);
        // dd($viewdata);
        return view($bp, $viewdata);
    }


    
    /**
     * lấy view trong theme
     *
     * @param string $blade
     * @param bool $only_blade_path
     * @return boolean
     */
    public static function checkThemeView($blade, $only_blade_path = false)
    {
        $d = static::$themeFolder . '.';
        $theme = get_active_theme();
        if(!$only_blade_path && $theme->mobile_version == 'dual'){
            $f = is_mobile() ? 'mobile.' : 'desktop.';

            $bp = $d . $f . $blade;
        }else{
            $bp = $d .  $blade;
        }
        // dd($viewdata);
        return view()->exists($bp);
    }

    /**
     * lấy view thu muc templates cua theme
     *
     * @param string $blade
     * @param array $data
     * @return \Illuminate\View\View
     */
    public static function themeTemplate($blade, $data = [])
    {
        $d = 'templates.';
        $bp = $d .  $blade;
        return static::theme($bp, $data);
    }

    /**
     * lấy view trong thu muc component cua theme
     *
     * @param string $blade
     * @param array $data
     * @return \Illuminate\View\View
     */
    public static function themeComponent($blade, $data = [])
    {
        $d = 'components.';
        $bp = $d .  $blade;
        return static::theme($bp, $data);
    }



    /**
     * lấy view trong thu muc component cua theme
     *
     * @param string $blade
     * @param array $data
     * @return \Illuminate\View\View
     */
    public static function themeModule($blade, $data = [])
    {
        $d = 'modules.';
        $bp = $d .  $blade;
        return static::theme($bp, $data);
    }


    /**
     * lấy view trong thu muc component cua theme
     *
     * @param string $blade
     * @return boolean
     */
    public static function checkModule($blade)
    {
        $d = 'modules.';
        $bp = $d .  $blade;
        return static::checkModule($bp);
    }


    
    /**
     * lấy view trong thu viện có sẵn
     *
     * @param string $blade
     * @param array $data
     * @return \Illuminate\View\View
     */
    public static function library($blade, $data = [])
    {
        $d = 'client-libs.';
        $bp = $d .  $blade;
        return view($bp, $data);
    }

    
    /**
     * lấy view trong thu viện có sẵn
     *
     * @param string $blade
     * @param array $data
     * @return \Illuminate\View\View
     */
    public static function libTemplate($blade, $data = [])
    {
        $d = 'templates.';
        $bp = $d .  $blade;
        return static::library($bp, $data);
    }

    /**
     * lấy view trong thu viện có sẵn
     *
     * @param string $blade
     * @param array $data
     * @return \Illuminate\View\View
     */
    public static function libComponent($blade, $data = [])
    {
        $d = 'components.';
        $bp = $d .  $blade;
        return static::library($bp, $data);
    }

    
}
