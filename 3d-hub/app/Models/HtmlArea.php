<?php

namespace App\Models;

class HtmlArea extends Model
{
    public $table = 'html_areas';
    public $fillable = ['name', 'slug', 'ref', 'ref_id'];
    public $timestamps = false;

    public function embeds()
    {
        return $this->hasMany('App\Models\HtmlEmbed', 'area_id', 'id');
    }

    public function areaComponents()
    {
        return $this->hasMany('App\Models\HtmlComponent', 'area_id', 'id');
    }

    
    public function components()
    {
        return $this->areaComponents()
                    ->join('components', 'components.id', '=', 'html_components.component_id')
                    ->select(
                        'html_components.*', 
                        'components.name', 
                        'components.type', 
                        'components.ref', 
                        'components.ref_id', 
                        'components.path', 
                        'components.inputs'
                    );
    }

    

    

    public function beforeDelete()
    {
        $this->embeds()->delete();
        if (count($this->areaComponents)) {
            foreach ($this->areaComponents as $key => $component) {
                $component->delete();
            }
        }
    }
}
