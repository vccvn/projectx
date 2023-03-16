<?php

namespace App\Models;

class Comment extends Model
{
    public $table = 'comments';
    public $fillable = ['owner_id', 'parent_id', 'ref', 'ref_id', 'author_name', 'author_email', 'author_phone', 'author_website', 'author_id', 'message', 'approved', 'approved_id', 'privacy'];

    public function children()
    {
        return $this->hasMany('App\Models\Comment', 'parent_id', 'id');
    }

    public function publishChildren()
    {
        return $this->children()->whereIn('privacy', ['public', 'publish', 'published'])->where('approved', 1);
    }

    public function page()
    {
        return $this->belongsTo('App\Models\Page', 'ref_id', 'id');
    }
    public function post()
    {
        return $this->belongsTo('App\Models\Post', 'ref_id', 'id');
    }
    public function project()
    {
        return $this->belongsTo('App\Models\Project', 'ref_id', 'id');
    }
    public function product()
    {
        return $this->belongsTo('App\Models\Product', 'ref_id', 'id');
    }


    public function refer()
    {
        return call_user_func_array([$this, $this->ref], []);
    }

    public function beforeDelete()
    {
        // delete children
        if(count($this->children)){
            foreach ($this->children as $child) {
                $child->delete();
            }
        }
    }

    public function getRefTitle()
    {
        $refer = $this->refer;
        if($refer){
            return $refer->title?$refer->title:$refer->name;
        }
        return null;
    }

    public function getRefViewUrl()
    {
        $refer = $this->refer;
        if($refer){
            return $refer->getViewUrl();
        }
        return null;
    }

    public function getShortMsg($length = null)
    {
        if(!is_numeric($length) || $length < 1 || strlen($this->message) <= $length) return $this->message;
        
        $m = substr($this->message, 0, $length);
        $ms = explode(' ', $m);
        array_pop($ms);
        return implode(' ', $ms);
        
    }
}
