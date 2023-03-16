<?php

namespace App\Repositories\Crawlers;

use App\Exceptions\NotReportException;
use App\Repositories\Base\BaseRepository;
use Carbon\Carbon;

class PostTaskRepository extends BaseRepository
{
    protected $type = 'post';
    /**
     * crawl
     *
     * @var CrawlPostRepository
     */
    protected $crawl;
    /**
     * class chứ các phương thức để validate dử liệu
     * @var string $validatorClass
     */
    protected $validatorClass = 'App\Validators\Crawlers\PostTaskValidator';



    /**
     * @var array $defaultSortBy Mảng key value là tên cộ và kiểu sắp xếp
     */
    protected $defaultSortBy = [
        'id' => 'DESC'
    ];




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
        $this->addDefaultParam('type', $this->type)->addDefaultValue('type', $this->type);
        $this->crawl = new CrawlPostRepository();

        $this->setJoinable([
            ['join', 'crawler_frames', 'crawler_frames.id', '=', 'crawler_tasks.frame_id'],
            ['join', 'dynamics', 'dynamics.id', '=', 'crawler_tasks.dynamic_id'],
            ['leftJoin', 'categories', 'categories.id', '=', 'crawler_tasks.category_id']
        ]);
        $ct = 'crawler_tasks.';
        $columns = [
            'id' => $ct . 'id',
            'task_url' => $ct . 'task_url',
            'crawl_datetime' => $ct . 'crawl_datetime',
            'created_at' => $ct . 'created_at',
            'status' => $ct . 'status',
            'frame_name' => 'crawler_frames.name',
            'dynamic_name' => 'dynamics.name',
            'category_name' => 'categories.name',
        ];
        $this->setSortable($columns)->setSearchable($columns)->setWhereable($columns)
            ->setSelectable([
                $ct . '*',
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
     * chạy bởi task trực tiếp không cần truy vấn nhiều lần
     *
     * @param \App\Models\CrawlerTask $task
     * @param \App\Models\CrawlerFrame $frame
     * @return int Số lượng dữ liru65 bản ghi crawl dc
     */
    public function runByTask($task, $frame = null)
    {
        // cập nhậ lần crawl mới nhất
        $task->crawl_last_time = date('h:i:s');
        $task->crawl_datetime = Carbon::now();
        $task->save();

        if (!$frame) {
            $frame = app(FrameRepository::class)->first(['id' => $task->frame_id, 'type' => $this->type]);
            // nếu ko thấy frame trả về false
            if (!$frame) return false;
            $frame->checkSelectors();
        }
        $count = 0;

        try {
            $this->crawl->setCrawlOwnerID($task->owner_id);
            // lấy html của trang để tim url post

            if (!($html = $this->crawl->getHtml($task->task_url, $frame->source_type))) {
                return false;
            }
            // die($html);
            // dử liệu để crawl
            $crawlParams = [
                'category_id' => $task->category_id,
                'frame_id' => $task->frame_id,
                'author_id' => $task->author_id,
                'dynamic_id' => $task->dynamic_id,
                'crawl_resources' => $task->crawl_resources,
            ];

            $selector = $task->post_url_selector ? $task->post_url_selector : $frame->item_url_selector;
            if (!$selector) return false;
            $post = $html->find($selector);
            $num = count($post) <= $task->quantity ? count($post) : $task->quantity;
            for ($i = 0; $i < $num; $i++) {
                if ($post[$i] && $post[$i]->attr['href']) {
                    $crawlParams['url'] = $this->crawl->parseUrl($post[$i]->attr['href'], $frame);
                    $res = $this->crawl->crawl($crawlParams, $frame);
                    if ($res) $count++;
                }
            }
        } catch (NotReportException $th) {
            //throw $th;
        }

        return $count;
    }

    /**
     * thực thi task
     * @param int $id
     */

    public function run($id)
    {
        // set_time_limit(0);
        if (!$task = $this->find($id)) return false;
        return $this->runByTask($task);
    }

    /**
     * chạy nhiều task
     * @param array $idList
     * @return array mang các id dc crawl thành công
     */
    public function runMany(array $idList = [])
    {
        $runData = [];

        if (count($idList) && count($tasks = $this->get(['id' => $idList]))) {
            foreach ($tasks as $task) {
                if ($count = $this->runByTask($task)) $runData[] = $count;
            }

            // foreach ($idList as $id) {
            //     if ($count = $this->run($id)) {
            //         $runData[] = $count;
            //     }
            // }
        }
        return $runData;
    }

    /**
     * chạy task tự dộng
     */

    public function task()
    {
        $this->where('status', 1)->chunkById(50, function ($tasks) {
            foreach ($tasks as $task) {
                // thời gian hiện tại
                $currentTimeSeconds = time();

                // cũng là thời gian tính bằng giay. Nhưng là thời gian trong ngày
                $currentTimeOfDay = $this->getTime(date("H:i:s"));

                // thời gian của lần crawl trước đó
                $lastCrawlTimeSeconds = strtotime($task->crawl_datetime . '');

                // thời gian lặp lại hành dộng tính bằng giây
                $repeatTimeSeconds = $this->getTime($task->repeat_time);

                // thời gian thực hiện cụ thể
                $timeToCrawl = $this->getTime($task->crawl_time);

                // bắt dầu xử lý logic
                // $et = $currentTimeSeconds - $lastCrawlTimeSeconds;
                // dump("$et >= $repeatTimeSeconds && $currentTimeOfDay >= $timeToCrawl");
                // nếu thời gian hiện tại trừ đi thời gian crawl trước đó mà lớn hơn hoặc bằng tần xuất
                if ($currentTimeSeconds - $lastCrawlTimeSeconds >= $repeatTimeSeconds && $currentTimeOfDay >= $timeToCrawl) {
                    $dd = $this->runByTask($task);
                }
            }
        });
    }


    public function getTime($time)
    {
        $time = get_time_seconds($time);
        return $time;
    }
}
