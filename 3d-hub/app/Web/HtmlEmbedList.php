<?php

namespace App\Web;

use Crazy\Helpers\Arr;

class HtmlEmbedList {
    protected $embeds = [];
    
    public function __construct($embeds = null)
    {
        if(is_countable($embeds) && count($embeds)){
            foreach ($embeds as $embed) {
                $this->embeds[str_slug($embed->slug, '_')] = $embed->code;
            }
        }
    }

    public function get($slug = null)
    {
        if(is_null($slug)) return null;
        return array_key_exists($slug, $this->embeds)?$this->embeds[$slug]: null;
    }

    public function render()
    {
        $a = '';
        if(count($this->embeds)){
            foreach ($this->embeds as $embed) {
                $a .= $embed;
            }
        }
        return $a;
    }

    public function __get($name)
    {
        return $this->get($name);
    }

    public function __toString()
    {
        return $this->render();
    }


}