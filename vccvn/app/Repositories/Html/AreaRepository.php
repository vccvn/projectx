<?php

namespace App\Repositories\Html;

use App\Engines\JsonData;
use App\Repositories\Base\BaseRepository;

class AreaRepository extends BaseRepository
{
    /**
     * class chứ các phương thức để validate dử liệu
     * @var string $validatorClass 
     */
    protected $validatorClass = 'App\Validators\Themes\HtmlAreaValidator';

    protected $maskClass = 'Html\AreaMask';
    protected $maskCollectionClass = 'Html\AreaCollection';
    /**
     * get model
     * @return string
     */
    public function getModel()
    {
        return \App\Models\HtmlArea::class;
    }

    public function init()
    {
        $this->registerCacheMethods('getAreaData');
    }

    public function createDataIfNotExists($data = [], $columns = [])
    {
        $return = null;
        $param = array_copy($data, 'slug', 'ref');
        if(isset($data['owner_id'])){
            $param['owner_id'] = $data['owner_id'];
        }
        if(isset($data['ref_id'])){
            $param['ref_id'] = $data['ref_id'];
        }
        if(!$this->count($param)){
            $return = $this->create($data);
        }
        return $return;
    }

    public function createAreaList($list, $ref = null, $ref_id = 0)
    {
        if(is_array($list)){
            foreach ($list as $i => $area) {
                $a = is_array($area) ? $area : ['slug' => $i, 'name' => $area];
                $a['ref'] = $ref;
                $a['ref_id'] = $ref_id;
                if(!isset($a['slug'])) $a['slug'] = $i;
                $this->createDataIfNotExists($a);
            }
        }
    }

    /**
     * create default area
     *
     * @param int $owner_id
     * @return void
     */
    public function createDefaultArea($owner_id)
    {
        $return = [];
        $engine = new JsonData();
        $htmlArea = $engine->getData('data/web/html.areas');
        $data = $htmlArea?$htmlArea['data']:[];
        if($data){
            foreach ($data as $area) {
                $area['owner_id'] = $owner_id;
                $return[] = $this->createDataIfNotExists($area);
            }
        }
        return $return;
    }

    public function getEmbedAreas($args = [])
    {
        $data = ['default' => [], 'theme' => []];
        
        $areas = $this->where('ref', 'default')
                        ->with([
                            'embeds' => function($query){
                                $query->orderBy('priority', 'asc');
                        }])->get($args);

        if(count($areas)){
            foreach ($areas as $area) {
                $data['default'][$area->slug] = $area;
            }
        }

        if($theme = get_active_theme()){
            $args = array_merge($args, [
                'ref' => 'theme',
                'ref_id' => $theme->id
            ]);
            if(count($areas = $this->with(['embeds' => function($query){$query->orderBy('priority', 'asc');}])->get($args))){
                foreach ($areas as $area) {
                    $data['theme'][$area->slug] = $area;
                }
            }
    
        }
        return $data;
    }

    public function getClientEmbeds($args = [])
    {
        $data = [];
        
        $areas = $this->where('ref', 'default')->with([
            'embeds' => function($query){
                $query->where('status', 1)->orderBy('priority', 'asc');
            }
        ])->get($args);
        if(count($areas)){
            foreach ($areas as $area) {
                $embeds = [];
                if(count($area->embeds)){
                    foreach ($area->embeds as $embed) {
                        $embeds[$embed->slug] = $embed->code;
                    }
                }
                $data[str_slug($area->slug, '_')] = $embeds;
            }
        }

        if($theme = get_active_theme()){
            $args = array_merge($args, [
                'ref' => 'theme',
                'ref_id' => $theme->id
            ]);
            $areas = $this->with([
                'embeds' => function($query){
                    $query->where('status', 1)->orderBy('priority', 'asc');
                }
            ])->get($args);
            if(count($areas)){
                foreach ($areas as $area) {
                    $embeds = [];
                    if(count($area->embeds)){
                        foreach ($area->embeds as $embed) {
                            $embeds[$embed->slug] = $embed->code;
                        }
                    }
                    $data[str_slug($area->slug, '_')] = $embeds;
                }
            }
    
        }
        return $data;
    }

    
    public function getComponentAreas($args = [])
    {
        $data = ['default' => [], 'theme' => []];
        $areas = $this->where('ref', 'default')->with(['components' => function ($query) {
            $query->where('parent_id', 0)->with([
                'children' => function($query){
                    $query->with([
                        'children' => function($query){
                            $query->with([
                                'children' => function($query){
                                    $query->orderBy('priority', 'ASC');
                                }
                            ])->orderBy('priority', 'ASC');
                        }
                    ])->orderBy('priority', 'ASC');
                }
            ])->orderBy('priority', 'ASC');
        }])->get($args);

        if(count($areas)){
            foreach ($areas as $area) {
                $data['default'][$area->slug] = $area;
            }
        }

        if($theme = get_active_theme()){
            $args = array_merge($args, [
                'ref' => 'theme',
                'ref_id' => $theme->id
            ]);
            $areas = $this->with(['components' => function ($query) {
                $query->where('parent_id', 0)->with([
                    'children' => function($query){
                        $query->with([
                            'children' => function($query){
                                $query->with([
                                    'children' => function($query){
                                        $query->orderBy('priority', 'ASC');
                                    }
                                ])->orderBy('priority', 'ASC');
                            }
                        ])->orderBy('priority', 'ASC');
                    }
                ])->orderBy('priority', 'ASC');
            }])->get($args);
            if(count($areas)){
                foreach ($areas as $area) {
                    $data['theme'][$area->slug] = $area;
                }
            }
    
        }
        return $data;
    }
    


    /**
     * lấy một area chứa component
     *
     * @param array $args
     * @return \App\Models\HtmlArea
     */
    public function getComponentArea($args = null)
    {
        if(!$args) return null;
        return $this->with(['components' => function ($query) {
            $query->where('parent_id', 0)->with([
                'children' => function($query){
                    $query->with([
                        'children' => function($query){
                            $query->with([
                                'children' => function($query){
                                    $query->orderBy('priority', 'ASC');
                                }
                            ])->orderBy('priority', 'ASC');
                        }
                    ])->orderBy('priority', 'ASC');
                }
            ])->orderBy('priority', 'ASC');
        }])
        ->orderBy('ref', 'desc')->first($args);
    }
    


    public function getClientComponents($args = [])
    {
        $data = [];
        
        $areas = $this->where('ref', 'default')->with([
            'components' => function($query){
                $query->where('parent_id', 0)->with([
                    'children' => function($query){
                        $query->with([
                            'children' => function($query){
                                $query->with([
                                    'children' => function($query){
                                        $query->orderBy('priority', 'ASC');
                                    }
                                ])->orderBy('priority', 'ASC');
                            }
                        ])->orderBy('priority', 'ASC');
                    }
                ])->orderBy('priority', 'ASC');
            }
        ])->get($args);
        if(count($areas)){
            foreach ($areas as $area) {
                $components = [];
                if(count($area->components)){
                    foreach ($area->components as $component) {
                        $components[$component->slug] = $component->code;
                    }
                }
                $data[str_slug($area->slug, '_')] = $components;
            }
        }

        if($theme = get_active_theme()){
            $args = array_merge($args, [
                'ref' => 'theme',
                'ref_id' => $theme->id
            ]);
            $areas = $this->with([
                'components' => function($query){
                    $query->where('parent_id', 0)->with([
                        'children' => function($query){
                            $query->with([
                                'children' => function($query){
                                    $query->with([
                                        'children' => function($query){
                                            $query->orderBy('priority', 'ASC');
                                        }
                                    ])->orderBy('priority', 'ASC');
                                }
                            ])->orderBy('priority', 'ASC');
                        }
                    ])->orderBy('priority', 'ASC');
                }
            ])->get($args);
            if(count($areas)){
                foreach ($areas as $area) {
                    $components = [];
                    if(count($area->components)){
                        foreach ($area->components as $component) {
                            $components[$component->slug] = $component->code;
                        }
                    }
                    $data[str_slug($area->slug, '_')] = $components;
                }
            }
    
        }
        return $data;
    }


    public function getAreaData()
    {
        $areas = $this->where(function ($query)
        {
            $query->where('ref', 'default');
            if($theme = get_active_theme()){
                $query->orWhere(function ($query) use($theme){
                    $query->where('ref', 'theme')->where('ref_id', $theme->id);
                });
            }
        })
        ->orderBy('ref', 'ASC')
        ->with([
            'components' => function($query){
                $query->where('parent_id', 0)->with([
                    'children' => function($query){
                        $query->with([
                            'children' => function($query){
                                $query->with([
                                    'children' => function($query){
                                        $query->orderBy('priority', 'ASC');
                                    }
                                ])->orderBy('priority', 'ASC');
                            }
                        ])->orderBy('priority', 'ASC');
                    }
                ])->orderBy('priority', 'ASC');
            },
            'embeds' => function($query){
                $query->where('status', 1)->orderBy('priority', 'asc');
            }
        ])->get();
        return $areas;
    }

    /**
     * lấy area theo slug và ref hoặc tự do. tóm lại hơi khó hiểu
     *
     * @param string $slug
     * @param string $ref
     * @param integer $ref_id
     * @return \App\Models\HtmlArea
     */
    public function getAreaBySlug($slug, $ref = null, $ref_id = 0)
    {
        
    }
}