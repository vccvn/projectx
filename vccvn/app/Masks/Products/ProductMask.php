<?php
namespace App\Masks\Products;

use App\Engines\ViewManager;
use App\Masks\Affiliates\ProductUrlCollection;
use App\Masks\Categories\CategoryMask;
use App\Masks\Comments\CommentCollection;
use App\Masks\Files\FileCollection;
use App\Masks\Files\GalleryCollection;
use App\Masks\MaskCollection;
use App\Masks\Metadatas\MetadataCollection;
use App\Masks\Tags\TagCollection;
use App\Masks\Users\AuthorMask;
use App\Models\Product;
use App\Repositories\Products\ProductRepository;
use Crazy\Helpers\Arr;
use Crazy\Magic\Mask;

class ProductMask extends Mask{

    public $meta = [];
    public $attributes = [];


    /**
     * thiết lập các thông số
     *
     * @return void
     */
    protected function init(){
        $this->allow([
            'getFeatureImage', 'hasPromo', 'promoAvailable', 'priceFormat', 'getFinalPrice',
            'countTotal','getViewUrl', 'getFullTitle','getReviewPoints','countReview',
            'getVariantAttributes', 'getOrderAttributes', 'getProductAttributes', 'hasVariant',
            'hasOption', 'getImage',  'getThumbnail', 'canReview', 'getDownPercent'
        ]);
        $this->map([
            'metadatas'        => MetadataCollection::class,
            'category'         => CategoryMask::class,
            'shop'             => AuthorMask::class,
            'tags'             => TagCollection::class,
            'attrs'            => MaskCollection::class,
            'gallery'          => GalleryCollection::class,
            'files'            => FileCollection::class,
            'media'            => FileCollection::class,
            'comments'         => CommentCollection::class,
            'publishComments'  => CommentCollection::class,
            'reviews'          => ProductReviewCollection::class,
            'affiliates'       => ProductUrlCollection::class
        ]);
    }

    // xem thêm ExampleMask

    protected function onLoaded()
    {
        if ($metadatas = $this->relation('metadatas')) {
            $jsf = $this->model->getJsonFields();
            foreach ($metadatas as $m) {
                if(in_array($m->name, $jsf)){
                    $value = json_decode($m->value, true);
                }else{
                    $value = $m->value;
                }

                $this->meta[$m->name] = $value;
            }
        }

        if($this->content) $this->content = do_shortcode($this->content);
        $this->image_url = $this->getFeatureImage();
        $this->has_promo = $this->hasPromo();
        $this->final_price = $this->getFinalPrice();

    }

    /**
     * gán dự liệu meta cho product
     * @return void
     */
    public function applyMeta()
    {
        if(!$this->meta){
            if ($metadatas = $this->relation('metadatas', true)) {
                $jsf = $this->model->getJsonFields();
                foreach ($metadatas as $m) {
                    if(in_array($m->name, $jsf)){
                        $value = json_decode($m->value, true);
                    }else{
                        $value = $m->value;
                    }
                    $this->data[$m->name] = $value;
                    $this->meta[$m->name] = $value;
                }
            }
        }
        elseif($this->meta){
            foreach ($this->meta as $key => $value) {
                $this->data[$key] = $value;
            }
        }
    }



    /**
     * lấy ra các bài viết liên quan
     *
     * @param array|int|str $args
     * @return \App\Masks\MaskCollection
     */
    public function getRelated($args = null){
        $params = [];
        if(is_numeric($args)){
            $params['@limit'] = $args;
        }elseif(is_array($args)){
            $params = $args;
        }elseif (is_string($args) && $args) {
            $params['@order_by'] = $args;
        }

        if(!isset($params['@sort']) && !isset($params['@sorttype']) && !isset($params['@sortType']) && !isset($params['@sort_type']) && !isset($params['@order_by']) && !isset($params['@orderBy']) && !isset($params['@orderby'])){
            $params['@sorttype'] = 'rand()';
        }
        $params['category_id'] = $this->category_id;
        if(!isset($params['@limit'])) $params['limit'] = 12;
        /**
         * @var \App\Repositories\Products\ProductRepository
         */
        $repository = app(ProductRepository::class)->cache('related-product-'.$this->id, system_setting('cache_data_time', 0), $params)->mode('mask');
        return $repository->where('id', '!=', $this->id)->getProducts($params);
    }


    public function getSameProducts($same_field = 'category_id', $args = null)
    {
        $params = [];
        if(is_numeric($args)){
            $params['@limit'] = $args;
        }elseif(is_array($args)){
            $params = $args;
        }elseif (is_string($args) && $args) {
            $params['@order_by'] = $args;
        }
        if(!$same_field) $same_field = 'category_id';
        if(!isset($params['@sort']) && !isset($params['@sorttype']) && !isset($params['@sortType']) && !isset($params['@sort_type']) && !isset($params['@order_by']) && !isset($params['@orderBy']) && !isset($params['@orderby'])){
            $params['@sorttype'] = 'rand()';
        }
        $params['same_field'] = $this->{$same_field};
        if(!isset($params['@limit'])) $params['limit'] = 5;
        /**
         * @var \App\Repositories\Products\ProductRepository
         */
        $repository = app(ProductRepository::class)->cache('same-product-'.$this->id, system_setting('cache_data_time', 0), $params)->mode('mask');
        return $repository->where('id', '!=', $this->id)->getProducts($params);
    }


    /**
     * lấy thong tin danh gia san phẩm
     *
     * @return Arr
     */
    public function getReviewData()
    {
        $t = count($this->reviews);
        $data = [
            'total' => $t,
            'ratings' => [
                [
                    'count' => 0,
                    'percent' => 0
                ],
                [
                    'count' => 0,
                    'percent' => 0
                ],
                [
                    'count' => 0,
                    'percent' => 0
                ],
                [
                    'count' => 0,
                    'percent' => 0
                ],
                [
                    'count' => 0,
                    'percent' => 0
                ],
                [
                    'count' => 0,
                    'percent' => 0
                ]
            ],
            'rating_avg' => 0,
            'rating_int' => 0,
            'data' => $this->reviews,
        ];
        if($t > 0){
            $total = 0;
            $perfect = 5;
            foreach ($this->reviews as $review) {
                $data['ratings'][$review->rating]['count']++;
                $total += $review->rating;
            }
            $avg = $total / ($t * $perfect) * $perfect;
            $data['rating_avg'] = round($avg, 2);
            $data['rating_int'] = round($avg, 0);
            foreach($data['ratings'] as $i => $rating){
                $data['ratings'][$i]['percent'] = round($rating['count']/$t * 100, 2);
            }
        }
        return new Arr($data);
    }

    public function attributesToHtml($options = [])
    {
        return ViewManager::libTemplate('product-order-attributes', array_merge($options, ['product' => $this]));
    }


    // khai báo thêm các hàm khác bên dưới nếu cần
}
