<?php

namespace App\Web;

use App\Engines\ViewManager;
use Crazy\Helpers\Arr;
use Crazy\Html\Html;

class HtmlAreaList {
    protected $areas = [];
    
    public function __construct($areas = null)
    {
        if(is_countable($areas) && count($areas)){
            foreach ($areas as $area) {
                $this->areas[str_slug($area->slug, '_')] = new HtmlAreaItem($area);
            }
        }
    }

    public function get($slug = null)
    {
        if(is_null($slug)) return $this->areas;
        return array_key_exists($slug, $this->areas)?$this->areas[$slug]: (new Arr());
    }

    public function __get($name)
    {
        return $this->get($name);
    }

    public function __call($name, $arguments)
    {
        return Html::make($name, $arguments);
    }

    public function getRegisterForm($config = [])
    {
        return get_register_form($config);
    }

    public function getLoginForm($config = [])
    {
        return get_login_form($config);
    }

    public function getShareButtons($title = null, $data = [])
    {
        return ViewManager::libTemplate('social-share-buttons', compact('title', 'data'));
    }


}