<?php

namespace App\Repositories\Crawlers;

use App\Crawlers\Lazada;
use App\Crawlers\MlbKorea;
use App\Crawlers\Sendo;
use App\Crawlers\Shopee;
use App\Crawlers\StockX;
use App\Engines\CacheEngine;
use App\Repositories\Products\ProductRepository;
use App\Repositories\Tags\TagRepository;
use App\Repositories\Tags\TagRefRepository;
use App\Repositories\Dynamics\DynamicRepository;
use App\Repositories\Files\FileRepository;
use App\Repositories\Metadatas\MetadataRepository;

use App\Exceptions\NotReportException;

use Carbon\Carbon;
use Crazy\Files\Image;
use Crazy\Helpers\Arr;

class CrawlProductRepository extends ProductRepository
{
    use Crawler;
    /**
     * class chứ các phương thức để validate dử liệu
     * @var string $validatorClass 
     */
    protected $validatorClass = 'App\Validators\Crawlers\CrawlProductValidator';

    /**
     * @var FrameRepository
     */
    protected $frames = null;

    protected $tags = null;

    protected $tagRefs = null;

    protected $dynamics = null;

    protected $metadatas = null;

    protected $fileRepository = null;

    /**
     * semdo
     *
     * @var \App\Crawlers\Sendo
     */
    public $sendo = null;
    /**
     * lazada
     *
     * @var \App\Crawlers\Lazada
     */
    public $lazada = null;
    /**
     * lazada
     *
     * @var \App\Crawlers\Shopee
     */
    public $shopee = null;
    /**
     * lazada
     *
     * @var \App\Crawlers\StockX
     */
    public $stockx = null;
    /**
     * lazada
     *
     * @var \App\Crawlers\MlbKorea
     */
    public $mlb = null;
    /**
     * chay lai thiet lap
     */
    public function init()
    {
        parent::init();
        $this->setup('products');
        $this->frames = new ProductFrameRepository();
        $this->tags = new TagRepository();
        $this->tagRefs = new TagRefRepository();
        $this->dynamics = new DynamicRepository();
        $this->metadatas = new MetadataRepository();
        $this->fileRepository = new FileRepository();
        $this->sendo = new Sendo($this);
        $this->lazada = new Lazada($this);
        $this->shopee = new Shopee($this);
        $this->stockx = new StockX($this);
        $this->mlb = new MlbKorea($this);
    }


    /**
     * lay noi dung tu html
     *
     * @param string|HtmlDomParse $html
     * @param Frame $frame
     * @param string $url
     * @return boolean|array
     */
    public function getDataFromHtml($html, $frame, $url)
    {
        if (!is_object($html)) $html = $this->toDom($html);
        $list_detail = explode('|', $frame->detail);
        $detail = '';
        foreach ($list_detail as $value) {
            if ($detail == '' && $value && $value != '') {
                $detail .= $this->getContent($html->find($value, 0), null);
            }
        }
        $name = trim(strip_tags($this->getContent($html->find($frame->product_name, 0), $frame->product_name_attr)));

        if ($name == '') {
            return false;
        }
        $name = html_entity_decode(preg_replace('/\<\!\-\-.*\-\-\>/ss', '', strip_tags($name)));
        $slug = str_slug($name, '-');






        // if ($this->first(['slug' => $slug])) return false;
        $data = [
            'name' => $name,
            'description' => strip_tags($this->getContent($html->find($frame->description, 0), $frame->description_attr)),
            'detail' => $this->except($detail, $frame->except, $frame),

        ];

        if ($price = $this->getPrice($html, $frame, 'regular')) {
            $data['list_price'] = $price;
            if ($old_price = $this->getPrice($html, $frame, 'old')) {
                $data['sale_price'] = $price;
                $data['list_price'] = $old_price;
                $data['on_sale'] = 1;
            }
        } else {
            $data['list_price'] = 0;
        }
        $data['detail'] .= $frame->style;
        $data['slug'] = $slug;
        if ($image_src = $this->parseSourceUrl($this->getContent($html->find($frame->image, 0),  $frame->image_attr), $url, $frame->url)) {
            // lưu file ảnh 
            // dd($image_src);
            $data['feature_image'] = $image_src;
            // $data['feature_image'] = @$this->saveFeatureImage($image_src, $qid, 'products');
            // lưu bài viết
        }
        $data['keywords'] = $this->getTag($html, $frame->tag, $frame->tag_attr);
        $gallery_images = [];
        if($frame->gallery){
            $gallery = $html->find($frame->gallery);
            if($gallery){
                foreach ($gallery as $tag) {
                    if($frame->gallery_attr && isset($tag->attr[$frame->gallery_attr]) && $tag->attr[$frame->gallery_attr]){
                        $gallery_images[] = $this->parseSourceUrl($tag->attr[$frame->gallery_attr], $url, $frame->url);
                    }elseif(!$frame->gallery_attr && $img = $tag->innertext()){
                        $gallery_images[] = $this->parseSourceUrl($img, $url, $frame->url);
                    }
                }
            }
        }
        if(count($gallery_images)){
            $data['gallery_images'] = $gallery_images;
        }
        return $data;
    }


    /**
     * crawl post
     * @param array $args 
     * 
     * @param Frame $frame
     * 
     * @return App\Models\Product|false
     * 
     */
    public function crawl(array $args = [], $frame = null)
    {
        $req = new Arr($args);

        // nếu ko tìm dc frame thì trả vè false
        if (!$frame && (!$req->frame_id || !$frame = $this->frames->find($req->frame_id))) return false;

        /**
         * thiết lập chủ web
         */
        $this->addDefaultParam('owner', 'owner_id', $frame->owner_id);
        $this->addDefaultValue('owner_id', $frame->owner_id);

        /**
         * rgiet61 lập chủ web để lưu file
         */
        $this->setCrawlOwnerID($frame->owner_id);

        $frame->checkSelectors();

        $url = $this->parseSourceUrl($req->url, $frame->url, $frame->url);

        try {
            if (preg_match('/sendo\.vn\/([A-z0-9_\-]*)\.html/i', $url, $match)) {
                return $this->sendo->saveProductBySlug($match[1], $req, $frame);
            } elseif (preg_match('/lazada\.vn\/products\/([A-z0-9_\-]*)\.html/i', $url)) {
                return $this->lazada->saveProductByUrl($url, $req, $frame);
            } elseif (preg_match('/stockx\.com\/([A-z0-9_\-]*)+$/i', $url)) {
                return $this->stockx->saveProductByUrl($url, $req, $frame);
            } elseif (preg_match('/mlb-korea\.com\//i', $url)) {
                return $this->mlb->saveProductByUrl($url, $req, $frame);
            } elseif (preg_match('/shopee.vn\/[^\.]*\-i\.([0-9]*)\.([0-9]*)($|\?|\/)/i', $url, $shopee)) {
                return $this->shopee->crawlByIDs($shopee[1], $shopee[2], $req, $frame);
            }
            
            // shopee.vn/[^\.]*\-i\.([0-9]*)\.([0-9]*)($|\?|\/)
            $html = $this->getHtml($url, $frame->source_type);
            // nếu ko lấy dc nội dung trang web

            if (!$html) return false;
            // die($html);

            $data = $this->getDataFromHtml($html, $frame, $url);

            $this->addDefaultValue('owner_id', $frame->owner_id);
            $data = array_merge($data, [
                'category_id' => $req->category_id,
                'shop_id' => $req->shop_id,

            ]);

            $qid = uniqid();

            $meta = [
                'source_url' => $url,
                'meta_title' => $data['name'],
                'meta_description' => $data['description'],
                'qid' => $qid
            ];

            $this->resetDefaultParams();

            $data['category_map'] = $this->makeCategoryMap($req->category_id);
            // die(json_encode($data));
            // return $data;


            if(array_key_exists('feature_image', $data)){
                $data['feature_image'] = @$this->saveFeatureImage($data['feature_image'], $qid, 'products');
            }
            $product = $this->save($data);
            // dd($product);
            // luu nwta
            if ($product) {

                $this->metadatas->addDefaultValue('owner_id', $frame->owner_id);
                $this->fileRepository->addDefaultValue('owner_id', $frame->owner_id);
                $this->tagRefs->addDefaultValue('owner_id', $frame->owner_id);

                if ($tags = $this->addTag($html, $frame->tag, $frame->tag_attr)) {
                    $this->tagRefs->updateTagRef('product', $product->id, $tags ?? []);
                }

                $this->resources = [];
                if ($req->crawl_resources) {
                    // cập nhật nội dung nếu có ãnh
                    $this->save(['detail' => $this->saveResources($frame, $data['detail'], $qid, 'products', $url)], $product->id);
                }

                $meta['resources'] = $this->resources;
                $this->metadatas->saveMany('product', $product->id, $meta);
                $this->resources = [];
                return $product;
            }
            return null;
        } catch (NotReportException $th) {

            return false;
        }

        return false;
    }

    public function getPrice($html, $frame, $type = 'regular')
    {
        $price = 0;
        $key = $frame->{$type . '_price'};
        if ($p = $this->getContent($html->find($key, 0), null)) {
            if ($frame->thousands_sep) {
                $p = str_replace($frame->thousands_sep, '', $p);
            }
            if ($frame->decimal_poiter) {
                $p = str_replace($frame->decimal_poiter, '.', $p);
            }

            $p = preg_replace('/[^0-9\.]/i', '', $p);
            $price = to_number($p);
        }
        return $price;
    }
}
