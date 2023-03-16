<?php

namespace App\Crawlers;

use Crazy\Files\Image;
use Crazy\Helpers\Arr;

class Shopee extends Crawler
{

    /**
     * repository
     *
     * @var \App\Repositories\Products\ProductRepository
     */
    public $repository;
    /**
     * ham khoi tao
     *
     * @param \App\Repositories\Products\ProductRepository $repository
     */
    public function __construct($repository)
    {
        $this->repository = $repository;
        parent::__construct();
    }

    public function init()
    {
        $this->setup('products');
    }

    public function crawlByIDs($shopid, $itemid, $config, $frame)
    {
        // ?itemid=2291056472&shopid=147191228
        $json = $this->api->json("https://shopee.vn/api/v2/item/get?itemid=$itemid&shopid=$shopid");
        if ($json->item) {
            $data = new Arr($json->item);
            $p = new Arr();
            $p->name = $data->name;
            $p->slug = str_slug($p->name, '-');


            $this->repository->addDefaultValue('owner_id', $frame->owner_id);
            $this->repository->addDefaultParam('owner', 'owner_id', $frame->owner_id);

            if ($this->repository->first(['slug' => $p->slug])) return false;

            $p->detail = '<div>' . implode('</div><div>', nl2array($data->description)) . '</div>';

            $p->list_price = $data->price / 100000;
            if ($data->price_before_discount) {
                $old = $data->price_before_discount / 100000;
                if ($old > $p->list_price) {
                    $p->sale_price = $p->list_price;
                    $p->list_price = $old;
                    $p->on_sale = 1;
                }
            }

            $p->category_id = $config->category_id;
            $p->shop_id = $config->shop_id;

            $p->category_map = $this->repository->makeCategoryMap($config->category_id);
            $qid = uniqid();
            $meta = [
                'meta_title' => $p->name,
                'meta_description' => $p->description,
                'qid' => $qid
            ];
            $base = 'https://cf.shopee.vn/file/';
            $image = $base . $data->image;
            $p->feature_image = @$this->saveFeatureImage($image, $qid, 'products');

            // images
            $product = $this->repository->save($p->all());
            // luu nwta
            if ($product) {
                // if($tags = $this->addTag($html, $frame->tag, $frame->tag_attr)){
                //     $this->tagRefs->updateTagRef('product', $product->id, $tags??[]);
                // }

                $this->resources = [];
                if ($config->crawl_resources) {
                    // cập nhật nội dung nếu có ãnh
                    $this->repository->save(['detail' => $this->saveResources($frame, $p->detail, $qid, 'products')], $product->id);
                }

                $meta['resources'] = $this->resources;

                $this->metadatas->addDefaultValue('owner_id', $frame->owner_id);
                $this->fileRepository->addDefaultValue('owner_id', $frame->owner_id);

                $this->metadatas->saveMany('product', $product->id, $meta);
                $this->resources = [];
                if ($data->images && is_array($data->images) && count($data->images)) {
                    foreach ($data->images as $img) {
                        $this->fileRepository->saveFileByUrl($base . $img, $frame->url, 'product', $product->id, $p->shop_id, $qid);
                        
                    }
                }
                return $product;
            }
            return false;
        }
    }



    /**
     * chạy task của sendo
     *
     * @param \App\Models\CrawlerTask $task
     * @param \App\Models\CrawlerFrame $frame
     * @return void
     */
    public function runTask($task, $frame, $cat_id = null)
    {
        if (!$cat_id) {
            if(preg_match('/shopee.vn\/[^\.]*\-cat\.([0-9]*)\.([0-9]*)($|\?|\/)/i', $task->task_url, $shopee)){
                $cat_id = $shopee[2];
            }else{
                return null;
            }
        }
        if ($cat_id) {
            $url = 'https://shopee.vn/api/v2/search_items/?by=pop&limit='.$task->quantity.'&match_id='.$cat_id.'&newest=0&order=desc&page_type=search&version=2';
            $apiData = $this->api->json($url);
            if ($apiData && $apiData->items) {
                $data = $apiData->items;

                $task->shop_id = $task->author_id;
                $t = count($data);
                $l = $task->quantity < $t ? $task->quantity : $t;
                $c = 0;
                for ($i = 0; $i < $l; $i++) {
                    $p = $data[$i];
                    if ($this->crawlByIDs($p['shopid'], $p['itemid'], $task, $frame)) {
                        $c++;
                    }
                }
                return $c;
            }
        }
        return false;
    }
}
