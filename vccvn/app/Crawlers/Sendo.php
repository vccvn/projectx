<?php

namespace App\Crawlers;

use Crazy\Files\Image;
use Crazy\Helpers\Arr;

class Sendo extends Crawler
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

    

    public function saveProductBySlug(string $slug, $config, $frame)
    {
        $json = $this->api->json("https://www.sendo.vn/m/wap_v2/full/san-pham/{$slug}?platform=web");
        
        if($json->status && isset($json->status['code']) && $json->status['code'] == 200){
            $data = new Arr($json->result['data']);
            $p = new Arr();
            $p->name = $data->name;
            $p->slug = str_slug($p->name, '-');

            
            $this->repository->addDefaultValue('owner_id', $frame->owner_id);
            $this->repository->addDefaultParam('owner', 'owner_id', $frame->owner_id);
            
            if($this->repository->first(['slug'=> $p->slug])) return false;
            $p->description = $data->short_description;
            $p->detail = $data->description;
            $p->list_price = $data->price;
            if($data->final_price && $data->final_price < $data->price){
                $p->sale_price = $data->final_price;
                $p->on_sale = 1;
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
            
            $p->feature_image = @$this->saveFeatureImage($data->image, $qid, 'products');


            // $this->repository->resetDefaultParams();

            // $this->repository->addDefaultValue('owner_id', $frame->owner_id);            
            $product = $this->repository->save($p->all());
                // luu nwta
            if($product){
                // if($tags = $this->addTag($html, $frame->tag, $frame->tag_attr)){
                //     $this->tagRefs->updateTagRef('product', $product->id, $tags??[]);
                // }
                
                $this->resources = [];
                if($config->crawl_resources){
                    // cập nhật nội dung nếu có ãnh
                    $this->repository->save(['detail' => $this->saveResources($frame, $p->detail, $qid, 'products')], $product->id);
                }
                
                $meta['resources'] = $this->resources;

                $this->metadatas->addDefaultValue('owner_id', $frame->owner_id);
                $this->fileRepository->addDefaultValue('owner_id', $frame->owner_id);

                $this->metadatas->saveMany('product', $product->id, $meta);
                $this->resources = [];
                if($data->media && is_array($data->media) && count($data->media)){
                    foreach ($data->media as $media) {
                        if($media['type'] == 'image'){
                            $this->fileRepository->saveFileByUrl($media['image_500x500'], $frame->url, 'product', $product->id, $p->shop_id, $qid);
                        }
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
    public function runTask($task, $frame)
    {
        if (!($html = $this->getHtmlRaw($task->task_url))) {
            return false;
        }
        if(preg_match('/\"categoryId\"\:([^\,]*)/i', $html, $match)){
            $apiData = $this->api->json('https://www.sendo.vn/m/wap_v2/category/product?category_id='.$match[1].'&listing_algo=algo14&p=1&platform=web&s=60&sortType=listing_v2_location_desc');
            if($apiData && $apiData->status && isset($apiData->status['code']) && $apiData->status['code'] == 200 && $apiData->result){
                $data = $apiData->result['data'];
                
                $task->shop_id = $task->author_id;
                $t = count($data);
                $l = $task->quantity < $t ? $task->quantity : $t;
                $c = 0;
                for ($i=0; $i < $l; $i++) { 
                    $p = $data[$i];
                    $a = explode('.', $p['cat_path']);
                    array_pop($a);
                    if($this->saveProductBySlug(implode('.', $a), $task, $frame)){
                        $c++;
                    }
                }
                return $c;
            }
        }
        return false;

    }
}