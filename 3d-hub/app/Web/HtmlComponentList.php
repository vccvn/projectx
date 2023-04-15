<?php

namespace App\Web;

use Crazy\Helpers\Arr;
use Illuminate\Support\Facades\View;

class HtmlComponentList {
    protected $components = [];
    protected $renderedComponents = '';
    protected $componentList = [];
    public function __construct($components = null)
    {
        if(is_countable($components) && count($components)){
            $this->components = $components;
            $this->parseComponents();
        }
    }

    public function getComponents()
    {
        return $this->componentList;
    }


    public function parseComponents()
    {
        if($this->componentList) return $this->componentList;
        $componentList = [];
        if(count($this->components)){
            $i = 0;
            foreach ($this->components as $component) {
                
                    $inputs = is_array($component->inputs)?$component->inputs:json_decode($component->inputs, true);
                    $data = new Arr($component->data);
                    $data->index = $i;
                    if($inputs){
                        foreach ($inputs as $key => $input) {
                            $name = isset($input['name'])?$input['name']:$key;
                            if(isset($input['type']) && strtolower($input['type']) == 'file' && $f = $data->get($name)){
                                $data->set($name, asset('static/webs/components/'.$f));
                            }
                        }
                    }
                    $shareData = new Arr([
                        'data' => $data,
                        'component' => new Arr($component->getAttrData())
                    ]);
                    
                $componentList[] = $shareData;
                $i++;
            }
        }
        $this->componentList = $componentList;
        return $componentList;
    }


    public function render()
    {
        if($this->renderedComponents) return $this->renderedComponents;
        $a = '';
        if(count($components = $this->parseComponents())){
            foreach ($components as $componentArr) {
                $component = $componentArr->component;

                if($component->type == 'blade'){
                    $data = $componentArr->data;
                    $shareData = [
                        'data' => $data,
                        'component' => $component
                    ];
                    if($component->ref == 'theme'){
                        if (View::exists($blade = 'clients.'.theme_component($component->path))) {
                            $a.= view($blade, $shareData)->render();
                        }
                    }else if(View::exists($blade = 'client-libs.components.'.$component->path)) {
                        $a.= view($blade, $shareData)->render();
                    }
                }else if($component->type == 'html'){
                    $a.= $componentArr->data->html;
                }
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