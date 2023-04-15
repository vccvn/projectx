<?php

namespace App\Web;

use Crazy\Helpers\Arr;

class HtmlAreaItem {
    protected $area = null;
    protected $renderedComponents = '';
    protected $renderedEmbeds = '';
    public function __construct($area)
    {
        $this->area = $area;
        $this->renderedEmbeds = new HtmlEmbedList($area->embeds);
        $this->renderedComponents = new HtmlComponentList($area->components);
    }

    public function __get($name)
    {
        $n = strtolower($name);
        if($n == 'embeds'){
            return $this->renderedEmbeds;
        }
        if($n == 'components'){
            return $this->renderedComponents;
        }
        return new Arr();
    }

    public function render()
    {
        return $this->renderedComponents.$this->renderedEmbeds;
    }
    public function __toString()
    {
        return $this->render();
    }
}