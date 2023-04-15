<?php

namespace App\Repositories\Posts;

use App\Repositories\Base\BaseRepository;

class PostViewRepository extends BaseRepository
{
    /**
     * get model
     * @return string
     */
    public function getModel()
    {
        return \App\Models\PostView::class;
    }

    public function addViewByCurrentDate($post_id)
    {
        $view_date = date("Y-m-d");
        $params = compact('post_id', 'view_data');
        if($view = $this->first($params)){
            $this->update($view->id, ['view_total' => $view->view_total + 1]);
        }else{
            $params['view_total'] = 1;
            $view = $this->create($params);
        }
        return $view;
    }

}