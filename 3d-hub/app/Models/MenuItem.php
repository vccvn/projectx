<?php

namespace App\Models;

use Crazy\Laravel\Router;

class MenuItem extends Model
{
    public $table = 'menu_items';
    public $fillable = ['menu_id', 'parent_id', 'priority', 'type', 'ref', 'ref_id', 'sub_type', 'props'];

    public $timestamps = false;

    public $casts = [
        'props' => 'json'
    ];


    public $itemTypes = ['url', 'route', 'page', 'dynamic', 'post', 'post_category', 'product_category', 'project_category'];

    public function menu()
    {
        return $this->belongsTo('App\Models\Menu', 'menu_id', 'id');
    }

    public function children()
    {
        return $this->hasMany('App\Models\MenuItem', 'parent_id', 'id')->orderBy('priority', 'ASC');
    }


    /**
     * lấy url menu item
     *
     * @return string
     */
    public function getUrl()
    {
        $url = "#";
        if (in_array($this->type, $this->itemTypes)) {
            $p = $this->props;
            $t = $this->type;
            if ($t == 'url') {
                $url = $p['url'] ?? null;
            } elseif ($t == 'route') {
                $url = (isset($p['route']) && $p['route'] && Router::getByName($p['route'])) ? route($p['route']) : "#";
            } elseif ($this->ref_id) {
                $url = ($model = get_model_data($t, $this->ref_id)) ? $model->getViewUrl() : '#';
            }
        }
        return $url;
    }

    /**
     * lay du lieu form
     * @return array
     */
    public function toFormData()
    {
        $data = $this->toArray();
        return $data;
    }

    public function beforeDelete()
    {
        if (count($this->children)) {
            foreach ($this->children as $child) {
                $child->delete();
            }
        }
    }
}
