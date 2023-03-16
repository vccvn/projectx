<?php

namespace App\Models;

class Post extends BasePost
{
    /**
     * dây là model đã diện cho post
     */
    protected $ref = 'post';

    public $fillable = [
        'owner_id', 'author_id', 'dynamic_id', 'category_id', 'category_map', 
        'type', 'content_type', 'title', 'slug', 'keywords', 'description', 'content', 'feature_image', 'views',
        'privacy', 'deleted'
    ];


    public function getViewUrl()
    {
        return get_post_url($this);
    }


    
    public function getFullTitle()
    {
        $title = '';
        if($this->category_id){
            if($category = get_model_data('post_category', $this->category_id)){
                $tree = $category->getTree();

                foreach ($tree as $cate) {
                    $title = $cate->name.' | '.$title;
                }
            }
        }
        $title = $this->title . ' | '.$title;
        if($dynamic = get_model_data('dynamic', $this->dynamic_id)){
            $title.=' | '.$dynamic->name;
        }
        return $title;
    }

}
