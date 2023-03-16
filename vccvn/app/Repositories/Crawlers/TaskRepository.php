<?php

namespace App\Repositories\Crawlers;

use App\Repositories\Base\BaseRepository;
use Carbon\Carbon;

class TaskRepository extends BaseRepository
{
    protected $crawl;
    /**
     * class chứ các phương thức để validate dử liệu
     * @var string $validatorClass 
     */
    protected $validatorClass = 'App\Validators\Crawlers\TaskValidator';

    /**
     * get model
     * @return string
     */
    public function getModel()
    {
        return \App\Models\CrawlerTask::class;
    }

    /**
     * chạy các thiết lập
     */
    public function init()
    {
        $this->crawl = new CrawlPostRepository();
        $this->setJoinable([
            ['join', 'crawler_frames','crawler_frames.id', '=', 'crawler_tasks.frame_id'],
            ['join', 'dynamics', 'dynamics.id', '=', 'crawler_tasks.dynamic_id'],
            ['leftJoin', 'categories', 'categories.id', '=', 'crawler_tasks.category_id']
        ]);
        $ct = 'crawler_tasks.';
        $columns = [
            'id' => $ct.'id',
            'task_url' => $ct.'task_url',
            'crawl_datetime' => $ct . 'crawl_datetime',
            'created_at' => $ct . 'created_at',
            'status' => $ct . 'status',
            'frame_name' => 'crawler_frames.name',
            'dynamic_name' => 'dynamics.name',
            'category_name' => 'categories.name',
        ];
        $this->setSortable($columns)->setSearchable($columns)->setWhereable($columns)
             ->setSelectable([
                 $ct.'*',
                 'frame_name' => 'crawler_frames.name',
                'dynamic_name' => 'dynamics.name',
                'category_name' => 'categories.name'
             ]);
    }

    /**
     * thay đổi trạng thái
     * @param int $id id của task cần thay đổi trạng thái
     * @param int|bool $status là trạng thái bao gồm 0 hoặc 1, true hoặc false
     * @return App\Models\CrawlerTask|null|false
     */
    public function changeStatus($id, $status)
    {
        $status = ($status && !in_array($status, ['false', 'off'])) ? 1 : 0;
        return $this->update($id, ['status' => $status]);

    }


    /**
     * thực thi task
     * @param int $id
     */
    
    public function run($id){
        // set_time_limit(0);
        if(!$data = $this->find($id)) return false;
        // cập nhậ lần crawl mới nhất
        $data->crawl_last_time = date('G:i:s', time());
        $data->crawl_datetime = Carbon::now();
        $data->save();

        // lấy html của trang để tim url post
        $html = $this->crawl->getHtml($data->task_url);
        if(!$html){
            return false;
        }
        // nếu ko thấy frame trả về false
        if(!$frame = (new FrameRepository())->findBy('id', $data->frame_id)){
            return false;
        }

        // dử liệu để crawl
        $task = [
            'category_id' => $data->category_id,
            'frame_id' => $data->frame_id,
            'author_id' => $data->author_id,
            'dynamic_id' => $data->dynamic_id,
            'crawl_resources' => $data->crawl_resources,
        ];

        $post = $html->find($data->post_url_selector);
        $num = count($post) <= $data->quantity ? count($post) : $data->quantity;
        $count = 0;
        for($i = 0; $i < $num; $i++){
            if($post[$i] && $post[$i]->attr['href']){
                $task['url'] = strpos($post[$i]->attr['href'], 'http') === 0 ? $post[$i]->attr['href'] : $frame->url.$post[$i]->attr['href'];
                $res = $this->crawl->crawl($task);
                if($res) $count++;
            }
        }
        
        
        return $count;
    }

    /**
     * chạy nhiều task
     * @param array $idList
     * @return array mang các id dc crawl thành công
     */
    public function runMany(array $idList = [])
    {
        $runData = [];
        if(count($idList)){
            foreach ($idList as $id) {
                if($count = $this->run($id)){
                    $runData[] = $count;
                }
            }
        }
        return $runData;
    }

    /**
     * chạy task tự dộng
     */

    public function task(){
        if(count($data = $this->where('status', 1)->get()))
        {
            foreach($data as $task){
                if($task->custom_run_time == 0 && abs( $this->getTime(date('G:i:s', time())) - $this->getTime($task->crawl_last_time)) > $this->getTime($task->repeat_time))
                    $this->run($task->id);
                if($task->custom_run_time == 1 && abs( $this->getTime(date('G:i:s', time())) - $this->getTime($task->crawl_time)) < $this->getTime('00:04:00'))
                    $this->run($task->id);
            };
        }
    }


    public function getTime($time){
        $time = explode(':', $time);
        return $time[0]*60*60+$time[1]*60+$time[2];
    }

}