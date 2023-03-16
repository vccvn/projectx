<?php

namespace App\Models;

class CrawlerTask extends Model
{
    public $table = 'crawler_tasks';
    public $fillable = [
        'owner_id', 'frame_id', 'dynamic_id', 'category_id', 'author_id', 'type', 
        'task_url', 'post_url_selector',  'quantity', 'crawl_resources', 
        'custom_run_time', 'repeat_time', 'crawl_time', 'crawl_datetime', 'crawl_last_time', 
        'config',
        'status'
    ];
    protected $casts = [
        'config' => 'array',
    ];
    
    /**
     * @var array $taskConfig
     */
    public $taskConfig = [
        'use_loadmore',
        'loadmore_method',
        'loadmore_link_selector',
        'loadmore_scroll_selector',
        'loadmore_turn'
    ];

    /**
     * check Selector
     * 
     */
    public function checkConfig()
    {
        $data = [];
        $a = $this->config;
        if(!is_array($a)){
            try {
                $a = json_decode($a, true);
            } catch (\Throwable $th) {
                //throw $th;
            }
        }
        if(is_array($a)){
            $data = $a;
            foreach ($a as $key => $value) {
                $this->{$key} = $value;
            }
        }
        return $data;
    }

    /**
     * lay du lieu form
     * @return array
     */
    public function toFormData()
    {
        $data = $this->toArray();
        $a = $this->config;
        if(!is_array($a)){
            try {
                $a = json_decode($a, true);
            } catch (\Throwable $th) {
                //throw $th;
            }
        }
        if(is_array($a)){
            foreach ($a as $key => $value) {
                $data[$key] = $value;
            }
        }
        return $data;
    }
}
