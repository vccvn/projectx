<?php

namespace App\Web;

use Crazy\Helpers\Arr;
use Illuminate\Support\Facades\View;

class HtmlComponentList
{
    protected $components = [];
    protected $renderedComponents = '';
    /**
     * danh sach component
     *
     * @var HtmlComponentItem[]
     */
    protected $componentList = [];
    protected $shareData = [];

    public function __construct($components = null)
    {
        if (is_countable($components) && count($components)) {
            $this->components = $components;
            $this->parseComponents();
        }
    }



    public function parseComponents()
    {
        if ($this->componentList) return $this->componentList;
        $componentList = [];
        if ($t = count($this->components)) {
            $ownerID = get_owner_id();
            $secret_id = get_secret_id($ownerID);
            $i = 0;
            $last = $t -1;
            foreach ($this->components as $component) {

                $inputs = is_array($component->inputs) ? $component->inputs : json_decode($component->inputs, true);
                $data = new Arr($component->data);
                $data->index = $i;
                $data->isFirst = $i == 0;
                $data->isLast = $i == $last;
                
                if ($inputs) {
                    foreach ($inputs as $key => $input) {
                        $name = isset($input['name']) ? $input['name'] : $key;
                        $t =isset($input['type'])? strtolower($input['type']) : '';
                        if ($t == 'file' && $f = $data->get($name)) {
                            $data->set($name, asset('static/users/' . $secret_id . '/components/' . $f));
                        }
                        elseif ($t == 'media' && $f = $data->get($name)) {

                            if($file = get_media_file(['id' => $f])){
                                $data->set($name, $file->source);
                            }
                        }
                    }
                }
                $componentItem = new HtmlComponentItem([
                    'data' => $data,
                    'component' => new Arr($component->getAttrData())
                ]);
                if ($component->children && count($component->children)) {
                    $componentItem->children = new static($component->children);
                }
                if ($this->shareData) {
                    $componentItem->share($this->shareData);
                }
                $componentList[] = $componentItem;
                $i++;
            }
        }
        $this->componentList = $componentList;
        return $componentList;
    }


    public function share($key, $value = null)
    {
        $share = is_array($key) ? $key : [$key => $value];
        foreach ($share as $k => $v) {
            $this->shareData[$k] = $v;
        }
        foreach ($this->componentList as $index => $comp) {
            $this->componentList[$index]->shared = array_merge($this->componentList[$index]->shared, $share);
            if ($comp->children) {
                $this->componentList[$index]->children->share($share);
            }
        }
    }


    public function getComponents()
    {
        return $this->componentList;
    }


    /**
     * lấy về 1 conponent theo diều kiện đầu vào
     * @param string|array $key key hoặc mảng điều kiện
     * @param mixed $value Giá trị
     *
     * @return Arr
     */
    public function getComponent($key = null, $value = null)
    {
        $component = null;
        if (!$this->componentList) return $component;
        if (is_array($key)) {
            foreach ($this->componentList as $k => $d) {
                $s = true;
                foreach ($key as $ck => $cv) {
                    if ($d->data->{$ck} != $cv) $s = false;
                }
                if ($s) {
                    return $d;
                }
            }
        } elseif ($key) {
            foreach ($this->componentList as $k => $d) {
                if ($d->data->{$key} == $value) return $d;
            }
        }
        return null;
    }



    public function render()
    {
        if ($this->renderedComponents) return $this->renderedComponents;
        $a = '';
        if (count($components = $this->parseComponents())) {
            $ownerID = get_owner_id();
            foreach ($components as $componentItem) {
                $a .= $componentItem->view();
            }
        }
        $this->renderedComponents = $a;
        return $a;
    }

    public function __get($name)
    {
        return null;
    }

    public function __toString()
    {
        return $this->render();
    }
}
