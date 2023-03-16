<?php

namespace App\Repositories\Crawlers;

use App\Exceptions\NotReportException;
use App\Repositories\Base\BaseRepository;
use App\Validators\Crawlers\ProductTaskValidator;
use Carbon\Carbon;
use Crazy\Helpers\Arr;

class ProductTaskRepository extends BaseRepository
{
    protected $type = 'product';
    /**
     * crawl product
     *
     * @var CrawlProductRepository
     */
    protected $crawl;
    /**
     * semdo
     *
     * @var \App\Crawlers\Sendo
     */
    protected $sendo = null;
    /**
     * semdo
     *
     * @var \App\Crawlers\Lazada
     */
    protected $lazada = null;
    /**
     * class chứ các phương thức để validate dử liệu
     * @var string $validatorClass 
     */
    protected $validatorClass = ProductTaskValidator::class;


    public $taskCount = 0;

    /**
     * get model
     * @return string
     */
    public function getModel()
    {
        return \App\Models\CrawlerTask::class;
    }

    public function getConfigFields()
    {
        return $this->_model->taskConfig;
    }

    /**
     * chạy các thiết lập
     */
    public function init()
    {
        $this->addDefaultParam('type', $this->type)->addDefaultValue('type', $this->type);
        $this->crawl = new CrawlProductRepository();
        $this->setJoinable([
            ['join', 'crawler_frames', 'crawler_frames.id', '=', 'crawler_tasks.frame_id'],
            // ['join', 'dynamics', 'dynamics.id', '=', 'crawler_tasks.dynamic_id'],
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
            // 'dynamic_name' => 'dynamics.name',
            'category_name' => 'categories.name',
        ];
        $this->setSortable($columns)->setSearchable($columns)->setWhereable($columns)
            ->setSelectable([
                $ct . '*',
                'frame_name' => 'crawler_frames.name',
                // 'dynamic_name' => 'dynamics.name',
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
     * lấy danh sách url cần crawl
     *
     * @param string $frame_url
     * @param string $task_url
     * @param string $selector
     * @param int $quantity
     * @param string $source_type
     * @param bool $use_loadmore
     * @param string $loadmore_method
     * @param int $loadmore_turn
     * @param string loadmore_link_selector
     * @param array $crawl_urls
     * @param array $task_urls
     * @return array
     */
    public function getCrawlUrls($frame_url, $task_url, $selector, $quantity, $source_type = 'ssr', $use_loadmore = false, $loadmore_method = '', $loadmore_turn = 0, $loadmore_link_selector = '', $crawl_urls = [], $task_urls = [], $task_checked = 0)
    {

        if (!($html = $this->crawl->getHtml($task_url))) {
            return $crawl_urls;
        }
        // die($html);
        if (!$selector) return $crawl_urls;
        $task_urls[] = $task_url;
        $post = $html->find($selector);
        $num = count($post) <= $quantity ? count($post) : $quantity;
        $hasCheck = false;
        for ($i = 0; $i < $num; $i++) {
            if ($post[$i] && $post[$i]->attr['href']) {
                $surl = $this->crawl->parseSourceUrl($post[$i]->attr['href'], $task_url, $frame_url);
                if (!in_array($surl, $crawl_urls)) {
                    $crawl_urls[] = $surl;
                    $hasCheck = true;
                }
                // $res = $this->crawl->crawl($crawlParams);
                // if ($res) {
                //     $count++;
                //     $results[] = $res;
                // }
            }
        }
        if ($hasCheck) $task_checked++;
        // dd($use_loadmore && $loadmore_method == 'link' && $source_type != 'csr' && count($task_urls) < $loadmore_turn);
        if ($use_loadmore && $loadmore_method == 'link' && count($task_urls) < $loadmore_turn) {
            $links = $html->find($loadmore_link_selector);
            // dd($links);
            if ($links && $t = count($links)) {

                for ($i = 0; $i < $t; $i++) {
                    $u = $links[$i]->attr['href'];

                    if($u && substr($u, 0, 1) != '#' && substr($u, 0, 11) != 'javascript:'){
                        $u = $this->crawl->parseSourceUrl($u, $task_url, $frame_url);
                        if (!in_array($u, $task_urls)) {
                            return $this->getCrawlUrls(
                                $frame_url, 
                                $u, 
                                $selector, 
                                $quantity, 
                                $source_type, 
                                $use_loadmore, 
                                $loadmore_method, 
                                $loadmore_turn, 
                                $loadmore_link_selector, 
                                $crawl_urls, 
                                $task_urls, 
                                $task_checked
                            );
                        }
                    }
                    
                }
            }
        }
        $this->taskCount = $task_checked;
        return $crawl_urls;
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
        $task->checkConfig();
        try {
            $this->crawl->setCrawlOwnerID($task->owner_id);
            if (preg_match('/sendo\.vn\/([^\/]*)($|\/|\?)/i', $task->task_url, $match)) {

                return $this->crawl->sendo->runTask($task, $frame);
            }
            if (preg_match('/lazada\.vn\//i', $task->task_url) || count(explode('lazada.vn', strtolower($task->task_url))) > 1) {
                return $this->crawl->lazada->runTask($task, $frame);
            }
            if (preg_match('/shopee.vn\/[^\.]*\-cat\.([0-9]*)\.([0-9]*)($|\?|\/)/i', $task->task_url, $shopee)) {
                return $this->crawl->shopee->runTask($task, $frame, $shopee[2]);
            }
            if (preg_match('/shopee.vn\/[^\.]*\-cat\.([0-9]*)($|\?|\/)/i', $task->task_url, $shopee)) {
                return $this->crawl->shopee->runTask($task, $frame, $shopee[1]);
            }
            if (preg_match('/stockx\.com\/([A-z0-9_\-]*)+$/i', $task->task_url)) {
                return $this->crawl->stockx->runTask($task, $frame);
            }
            if (preg_match('/mlb-korea\.com\/(.*)+$/i', $task->task_url)) {
                return $this->crawl->mlb->runTask($task, $frame);
            }

            // https://shopee.vn/%C4%90%E1%BB%93ng-h%E1%BB%93-tr%E1%BA%BB-em-cat.9607.9615



            $selector = $task->post_url_selector ? $task->post_url_selector : $frame->item_url_selector;
            $quantity = $task->quantity;
            $use_loadmore = $task->use_loadmore ? $task->use_loadmore : $frame->use_loadmore;
            $loadmore_turn = $task->loadmore_turn ? $task->loadmore_turn : $frame->loadmore_turn;
            if (!is_numeric($loadmore_turn) || $loadmore_turn < 0) $loadmore_turn = 0;
            $loadmore_method = $task->loadmore_method ? $task->loadmore_method : $frame->loadmore_method;
            $loadmore_link_selector = $task->loadmore_link_selector ? $task->loadmore_link_selector : $frame->loadmore_link_selector;

            // lấy html của trang để tim url post
            // dử liệu để crawl
            $crawlParams = [
                'category_id' => $task->category_id,
                'frame_id' => $task->frame_id,
                'shop_id' => $task->user_id ? $task->user_id : $task->author_id,
                // 'dynamic_id' => $task->dynamic_id,
                'crawl_resources' => $task->crawl_resources,
            ];

            $urls = $this->getCrawlUrls(
                $frame->url,
                $task->task_url,
                $selector,
                $quantity,
                $frame->source_type,
                $use_loadmore,
                $loadmore_method,
                $loadmore_turn,
                $loadmore_link_selector
            );

            $t = count($urls);
            $results = [];
            // $urls = [];
            for ($i=0; $i < $t; $i++) { 
                $u = $urls[$i];
                // $urls[] = $u;
                $crawlParams['url'] = $u;

                $res = $this->crawl->crawl($crawlParams);
                if ($res) {
                    $count++;
                    $results[] = $res;
                }
            }

            // die(json_encode($results));
        } catch (NotReportException $th) {
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
        if (!$task = $this->findBy('id', $id)) return false;
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
