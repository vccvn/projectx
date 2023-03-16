<?php

namespace App\Web;

use App\Engines\ViewManager;
use Crazy\Helpers\Arr;
use Crazy\Html\Html;
use Illuminate\Support\Str;

class HtmlAreaList
{
    protected $areas = [];
    protected $styles = [];
    protected $codes = [];

    protected $tagAttributes = [];

    public function __construct($areas = null)
    {
        if (is_countable($areas) && count($areas)) {
            foreach ($areas as $area) {
                $this->areas[str_slug($area->slug, '_')] = new HtmlAreaItem($area);
            }
        }
    }

    /**
     * lấy khu vực dược thiết lập
     *
     * @param string $slug
     * @return HtmlAreaItem|Arr
     */
    public function get($slug = null)
    {
        if (is_null($slug)) return $this->areas;
        return array_key_exists($slug, $this->areas) ? $this->areas[$slug] : (new Arr());
    }

    /**
     * thêm css vào html
     *
     * @param string|array $selectors
     * @param array $attrs
     * @return bool
     */
    public function addStyle($selectors = null, $attrs = [])
    {
        if ($selectors) {
            if (is_array($selectors)) {
                foreach ($selectors as $key => $value) {
                    if (!is_numeric($key) && is_array($value)) {
                        $this->addStyle($key, $value);
                    }
                }
            } elseif (is_string($selectors) && is_array($attrs) && $attrs) {
                if (!isset($this->styles[$selectors]))
                    $this->styles[$selectors] = $attrs;
                else
                    $this->styles[$selectors] = array_merge($this->styles[$selectors], $attrs);
            }
            return true;
        }
        return false;
    }

    /**
     * thêm css vào html
     *
     * @param string|array $selectors
     * @param array $attrs
     * @return bool
     */
    public function addCss($selectors = null, $attrs = [])
    {
        return $this->addStyle($selectors, $attrs);
    }

    /**
     * get Style
     *
     * @param string $selector
     * @return string
     */
    public function getStyle($selector = null)
    {
        $attrs = [];
        if (!$selector) $attrs = $this->styles;
        elseif (array_key_exists($selector, $this->styles)) {
            $attrs = $this->styles[$selector];
        }
        return $this->toCss($attrs);
    }


    /**
     * gwet css
     *
     * @param string $selector
     * @return string
     */
    public function getCss($selector = null)
    {
        return $this->getStyle($selector);
    }


    public function getAndCleanCss()
    {
        if ($this->styles) {
            $style = "<style type=\"text/css\">\n" . $this->toCss($this->styles) . '</style>';
            $this->styles = [];
            return $style;
        }
        return null;
    }


    /**
     * convert to css
     *
     * @param array $attrs
     * @return string
     */
    public function toCss($attrs = [])
    {
        if ($attrs) {
            $style = '';
            foreach ($attrs as $selectors => $props) {
                if (is_array($props)) {
                    $style .= $selectors . " {\n";
                    foreach ($props as $key => $value) {
                        $style .= "\t" . Str::snake($key, '-') . ': ' . ((string) $value) . ";\n";
                    }
                    $style .= "}\n";
                }
            }
            return $style;
        }
        return '';
    }

    /**
     * thêm mã html
     *
     * @param string $code
     * @return bool
     */
    public function addUserCode($code = null)
    {
        if (!in_array($code, $this->codes)) {
            $this->codes[] = $code;
        }
        return $this;
    }

    /**
     * lấy chuỗi mã html đã thêm vào
     *
     * @return string
     */
    public function getUserCodes()
    {
        $str = '';
        while (count($this->codes) > 0) {
            $str .= (string) array_shift($this->codes);
        }
        return $str;
    }


    /**
     * thêm thuộc tính cho thẻ
     *
     * @param string $tag
     * @param array|string $attr
     * @param mixed $value
     * @return bool
     */
    public function addTagAttribute($tag = null, $attr = null, $value = null)
    {
        if (is_string($tag) && $t = trim($tag)) {
            // nếu có giá trị thuộc tính hoặc key thuộc tính
            if ($attr) {
                // kiểm tra nếu chưa set thì set một mảng
                if (!isset($this->tagAttributes[$tag])) {
                    $this->tagAttributes[$tag] = [];
                }
                // nếu là array thì merge
                if (is_array($attr)) {
                    $this->tagAttributes[$tag] = array_merge($this->tagAttributes[$tag], $attr);
                }
                // giá trị khác xet biunh2 thường
                else {
                    $this->tagAttributes[$tag][$attr] = $value;
                }
                return true;
            }
        }
        return false;
    }


    /**
     * lấy về chuổi thuộc tính của thẻ
     *
     * @param string $tag
     * @return mixed[]
     */
    public function getTagAttributes($tag = null)
    {
        return is_string($tag) && $tag && array_key_exists($tag, $this->tagAttributes) ? $this->tagAttributes[$tag] : [];
    }

    /**
     * lấy về chuổi thuộc tính của thẻ
     *
     * @param string $tag
     * @param array $defaultAttributes
     * @return string
     */
    public function getTagAttributeToString($tag = null, $defaultAttributes = [])
    {
        $attrString = '';
        $attrs = array_merge($defaultAttributes, $this->getTagAttributes($tag));
        if ($attrs) {
            foreach ($attrs as $key => $value) {

                if (is_bool($value)) {
                    if ($value) $attrString .= " " . $key;
                } else {
                    $attrString .= " " . $key . '="' . htmlentities($value) . '"';
                }
            }
        }
        return $attrString;
    }



    /**
     * lấy một area
     *
     * @param string $name
     * @return HtmlAreaItem|Arr
     */
    public function __get($name)
    {
        return $this->get($name);
    }

    /**
     * tạo một dom html bằng php
     *
     * @param string $name
     * @param array $arguments
     * @return Html
     */
    public function __call($name, $arguments)
    {
        return Html::make($name, $arguments);
    }

    public function __toString()
    {
        $returnString = '';
        # code...

        return $returnString;
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
