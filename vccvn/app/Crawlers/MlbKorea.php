<?php

namespace App\Crawlers;

use App\Repositories\Crawlers\CrawlProductRepository;
use Crazy\Files\Image;
use Crazy\Helpers\Arr;

class MlbKorea extends Crawler
{

    /**
     * repository
     *
     * @var CrawlProductRepository
     */
    public $repository;

    protected $options = [];
    protected $scrapingUrl = null;
    /**
     * ham khoi tao
     *
     * @param CrawlProductRepository $repository
     */
    public function __construct($repository)
    {
        $this->repository = $repository;
        parent::__construct();

        $this->scrapingUrl = env('SCRAPING_API_URL');
        $this->options = [
            "api_key" => env('SCRAPING_API_KEY'),
            "render_js" => env('SCRAPING_API_RENDER_JS')
        ];
        $this->api->setOutput('html', true);
    }

    public function init()
    {
        $this->setup('products');
    }

    public function getTextHtml($url = null)
    {
        $data = $this->options;
        $data['url'] = $url;
        return $this->api->get($this->scrapingUrl, $data);
    }


    public function getHtmlData($url = null)
    {
        return $this->toDom($this->getTextHtml($url));
    }


    /**
     * lưu thông tin sản phẩm từ url
     *
     * @param string $url
     * @param Arr|task $config
     * @param Arr|Frame $frame
     * @return \App\Models\Product|null
     */
    public function getProductByUrl(string $url, $frame)
    {
        // lấy html của trang sp
        $html = $this->getHtml($this->parseUrl($url, $frame), $frame->source_type);

        if (!$html) return null;
        $data = $this->repository->getDataFromHtml($html, $frame, $url);
        return $data;

    }

    public function saveProduct($data, $config, $frame)
    {
        $p = new Arr($data);
        $p->slug = str_slug($p->name, '-');
        if ($this->repository->first(['slug' => $p->slug])) return false;

        $this->repository->addDefaultValue('owner_id', $frame->owner_id);
        $this->repository->addDefaultParam('owner', 'owner_id', $frame->owner_id);
        $p->category_id = $config->category_id;
        $p->shop_id = $config->shop_id;


        $p->category_map = $this->repository->makeCategoryMap($config->category_id);
        $qid = uniqid();
        $meta = [
            'meta_title' => $p->name,
            'meta_description' => $p->description,
            'qid' => $qid
        ];

        if ($p->feature_image) $p->feature_image = @$this->repository->saveFeatureImage($p->feature_image, $qid, 'products');

        $product = $this->repository->save($p->all());
        // luu nwta
        if ($product) {
            // if($tags = $this->addTag($html, $frame->tag, $frame->tag_attr)){
            //     $this->tagRefs->updateTagRef('product', $product->id, $tags??[]);
            // }

            $this->resources = [];
            if ($config->crawl_resources) {
                // cập nhật nội dung nếu có ãnh
                $this->repository->save(['detail' => $this->repository->saveResources($frame, $p->detail, $qid, 'products')], $product->id);
            }

            $meta['resources'] = $this->repository->resources;


            $this->metadatas->addDefaultValue('owner_id', $frame->owner_id);
            $this->fileRepository->addDefaultValue('owner_id', $frame->owner_id);

            $this->metadatas->saveMany('product', $product->id, $meta);
            $this->resources = [];
            // if ($gallery = $data->firstOf('skuGalleries')) {
            //     if (is_array($gallery)) {
            //         foreach ($gallery as $media) {
            //             if ($media['type'] == 'img') {
            //                 $this->fileRepository->saveFileByUrl($media['src'], $frame->url, 'product', $product->id, $p->shop_id, $qid);
            //             }
            //         }
            //     }
            // }
            return $product;
        }
        return false;
    }



    /**
     * lưu thông tin sản phẩm từ url
     *
     * @param string $url
     * @param Arr|task $config
     * @param Arr|Frame $frame
     * @return \App\Models\Product|null
     */
    public function saveProductByUrl(string $url, $config, $frame)
    {
        // lấy html của trang sp
        $data = $this->getProductByUrl($url, $frame);
        return $this->saveProduct($data, $config, $frame);
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

        if (!($html = $this->repository->getHtml($task_url))) {
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
                $surl = $this->repository->parseSourceUrl($post[$i]->attr['href'], $task_url, $frame_url);
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
                        $u = $this->repository->parseSourceUrl($u, $task_url, $frame_url);
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
     * chạy task của sendo
     *
     * @param \App\Models\CrawlerTask $task
     * @param \App\Models\CrawlerFrame $frame
     * @return void
     */
    public function runTask($task, $frame)
    {

        $count = 0;
        $selector = $task->post_url_selector ? $task->post_url_selector : $frame->item_url_selector;
        $quantity = $task->quantity;
        $use_loadmore = $task->use_loadmore ? $task->use_loadmore : $frame->use_loadmore;
        $loadmore_turn = $task->loadmore_turn ? $task->loadmore_turn : $frame->loadmore_turn;
        if (!is_numeric($loadmore_turn) || $loadmore_turn < 0) $loadmore_turn = 0;
        $loadmore_method = $task->loadmore_method ? $task->loadmore_method : $frame->loadmore_method;
        $loadmore_link_selector = $task->loadmore_link_selector ? $task->loadmore_link_selector : $frame->loadmore_link_selector;

        // lấy html của trang để tim url post
        // dử liệu để crawl
        $crawlParams = new Arr([
            'category_id' => $task->category_id,
            'frame_id' => $task->frame_id,
            'shop_id' => $task->user_id ? $task->user_id : $task->author_id,
            // 'dynamic_id' => $task->dynamic_id,
            'crawl_resources' => $task->crawl_resources,
        ]);

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

        // die(json_encode($urls));
        $t = count($urls);
        $results = [];
        // $urls = [];
        foreach ($urls as $url) {
            $res = $this->saveProductByUrl($url, $crawlParams, $frame);
            if ($res) {
                $count++;
                $results[] = $res;
            }
        }
        // die(json_encode($results));
        return $count;
    }
}
