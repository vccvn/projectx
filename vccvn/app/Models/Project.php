<?php

namespace App\Models;

class Project extends BasePost
{
    public $table = 'posts';
    public $fillable = [
        'owner_id', 'author_id', 'dynamic_id', 'category_id', 'category_map', 
        'type', 'title', 'slug', 'keywords', 'description', 'content', 'feature_image', 'views', 
        'privacy', 'deleted'
    ];

    
    /**
     * dây là model đã diện cho post
     */
    protected $ref = 'project';

    public function getViewUrl()
    {
        return get_project_url($this);
    }


    
    public function getFullTitle()
    {
        $title = '';
        if($this->category_id){
            if($category = get_model_data('project_category', $this->category_id)){
                $tree = $category->getTree();

                foreach ($tree as $cate) {
                    $title = $cate->name.' | '.$title;
                }
            }
        }
        $title = $this->title . ' | '.$title;
        
        $title.=' | Dự án';
        
        return $title;
    }
}
