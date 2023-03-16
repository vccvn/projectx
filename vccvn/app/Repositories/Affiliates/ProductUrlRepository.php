<?php

namespace App\Repositories\Affiliates;

use App\Repositories\Base\BaseRepository;
use Crazy\Helpers\Arr;

class ProductUrlRepository extends BaseRepository
{
    /**
     * class chứ các phương thức để validate dử liệu
     * @var string $validatorClass 
     */
    protected $validatorClass = 'Affiliates\ProductUrlValidator';
    
    /**
     * tên class mặt nạ. Thường có tiền tố [tên thư mục] + \ vá hậu tố Mask
     *
     * @var string
     */
    protected $maskClass = 'Affiliates\AffiliateProductUrlMask';

    /**
     * tên collection mặt nạ
     *
     * @var string
     */
    protected $maskCollectionClass = 'Affiliates\AffiliateProductUrlCollection';

    /**
     * get model
     * @return string
     */
    public function getModel()
    {
        return \App\Models\AffiliateProductUrl::class;
    }

    
    /**
     * cập nhật liên kết sản phẩm
     *
     * @param int $product_id
     * @param array $productUrls
     * @return array
     */
    public function updateProductUrls($product_id, $productUrls = [])
    {
        $ignore = [];
        if(is_array($productUrls) && count($productUrls) && Arr::isNumericKeys($productUrls)){
            
            foreach ($productUrls as $index => $productUrlData) {
                $pack = new Arr($productUrlData);
                $pack->product_id = $product_id;
                if($productUrl = $this->save($pack->all(), $pack->id)){
                    $ignore[] = $productUrl->id;
                }
            }
        }

        if($ignore){
            $this->whereNotIn('affiliate_product_urls.id', $ignore);
        }
        $this->query(compact('product_id'))->delete();
    }

}