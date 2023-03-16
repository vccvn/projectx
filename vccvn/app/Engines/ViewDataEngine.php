<?php
namespace App\Engines;

use App\Repositories\Html\AreaRepository;
use App\Web\HtmlAreaList;
use App\Web\Options;
use Crazy\Files\Filemanager;
use Crazy\Helpers\Arr;

class ViewDataEngine
{
    static $shared = false;

    
    public static function share($name = null, $value=null)
    {
        if(static::$shared) return true;;
        $a = $name?(is_array($name)?$name:(is_string($name)?[$name=>$value]: [])):[];
        $owner = get_owner();
        $options = new Options();
        $options->updateCache();
        set_web_data('options', $options);
        $siteinfo = siteinfo();
        $ecommerce = ecommerce_setting();
        $payment = $options->settings->payments;
        $settings = system_setting();
        $favicons = $options->settings->favicons??new Arr();
        $helper = new Helper();
        $request = request();
        $current_url = $request->getRequestUri();
        $html = new HtmlAreaList(app(AreaRepository::class)->getAreaData());
        $d = 'clients.'.theme_path() . '.';
        view()->share(array_merge(
            $a,
            compact('options', 'siteinfo', 'settings', 'ecommerce', 'payment', 'html', 'helper', 'current_url', 'request', 'favicons'), 
            [
                '_component' => $d . 'components.',
                '_template' => $d . 'templates.',
                '_layout' => $d . 'layouts.',
                '_module' => $d . 'modules.',
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
}
