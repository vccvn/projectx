<?php

namespace App\Crawlers;

use Crazy\Files\Image;
use Crazy\Helpers\Arr;

class Lazada extends Crawler
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
        $html = $this->getHtmlRaw($this->parseUrl($url, $frame));

        if(!$html) return null;
        // dung regex để lấy ra doan json thông tin sp
        if(!preg_match('/app\.run\(([^\r\n\t]*)\}\);(\s|\r\n|\r|\n|t)/si', $html, $match)) return null;
        $s = json_decode($match[1].'}', true);
        
        if($s && isset($s['data']['root']['fields'])){
            // data.root.fields
            $data = new Arr($s['data']['root']['fields']);
            $p = new Arr();
            $p->name = $data->get('product.title');
            $p->slug = str_slug($p->name, '-');

            // them thong tin chu web
            $this->repository->addDefaultValue('owner_id', $frame->owner_id);
            $this->repository->addDefaultParam('owner', 'owner_id', $frame->owner_id);
            

            if($this->repository->first(['slug'=> $p->slug])) return false;
            $p->description = $data->get('htmlRender.msiteShare.description');
            $p->detail = $data->get('product.highlights');
            $price = null;
            if(($priceData = $data->firstOf('skuInfos')) && isset($priceData['price'])){
                $price = new Arr($priceData['price']);
                
            }elseif(($priceData = $data->get('skuInfos.0')) && isset($priceData['price'])){
                $price = new Arr($priceData['price']);
            }

            if($price){
                $list_price = $price->get('originalPrice.value', 0);

                
                if($sale_price = $price->get('salePrice.value')){
                    if(!$list_price) $list_price = $sale_price;
                    elseif ($sale_price < $list_price) {
                        $p->sale_price = $sale_price;
                        $p->on_sale = 1;
                    }
                    
                }
                $p->list_price = $list_price;;
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
            
            $p->feature_image = @$this->saveFeatureImage($data->get('htmlRender.msiteShare.image'), $qid, 'products');

            // chi tiết sản phẩm
            if($desc = $data->get('product.desc')){
                $p->detail .= $desc;
            }
            if ($pageUrl = $data->get('product.pageUrl')) {
                if(count($urs = explode('//store.lazada.vn/pc?', $url)) == 2){
                    $pageUrl = '//store.lazada.vn/pc?'.$urs[1];
                }
                if(substr($url, 0, 4) != 'http'){
                    $http = explode('://', $url);
                    $pageUrl = $http[0].':'.$pageUrl;
                }
                
                $pageData = $this->api->json($pageUrl);
                if($pageData->result){
                    $component = new Arr($pageData->firstOf('result.components'));
    
                    if($content = $component->get('moduleData.html')){
                        $p->detail .= $content;
                    }
                }
    
            }
            
            // $this->repository->resetDefaultParams();
            
            // $this->repository->addDefaultValue('owner_id', $frame->owner_id);

            $product = $this->repository->save($p->all());
                // luu nwta
            if($product){
                // if($tags = $this->addTag($html, $frame->tag, $frame->tag_attr)){
                //     $this->tagRefs->updateTagRef('produc', $product->id, $tags??[]);
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
                if($gallery = $data->firstOf('skuGalleries')){
                    if(is_array($gallery)){
                        foreach($gallery as $media){
                            if($media['type'] == 'img'){
                                $this->fileRepository->saveFileByUrl($media['src'], $frame->url, 'product', $product->id, $p->shop_id, $qid);
                            }
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
        if (!($html = $this->getHtmlRaw($this->parseUrl($task->task_url, $frame)))) {
            return false;
        }
        
        if(preg_match('/\<script\>window\.pageData\=\{([^\r\n]*)\}\<\/script\>(\s|\r|\n|\t|\<)/i', $html, $match)){
            $taskData = new Arr(json_decode('{'.$match[1] . '}', true));

            if($items = $taskData->get('mods.listItems')){
                $this->repository->addDefaultParam('owner', 'owner_id', $frame->owner_id);
                
                $task->shop_id = $task->author_id;
                $t = count($items);
                $l = $task->quantity < $t ? $task->quantity : $t;
                $c = 0;
                for ($i=0; $i < $l; $i++) { 
                    $p = $items[$i];
                    $slug = str_slug($p['name']);
                    if($this->repository->first(['slug' => $slug])) continue;
                    if($this->saveProductByUrl($p['productUrl'], $task, $frame)){
                        $c++;
                    }
                }
                return $c;
            }
        }
        return false;

    }
}