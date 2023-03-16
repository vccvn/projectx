<?php

namespace App\Models;

class AffiliateProductUrl extends Model
{
    public $table = 'affiliate_product_urls';
    public $fillable = ['owner_id', 'affiliate_id', 'product_id', 'url', 'price'];
    public $timestamps = false;
    
    public function affiliate()
    {
        return $this->belongsTo(Affiliate::class, 'affiliate_id', 'id');
    }
    public function product()
    {
        return $this->belongsTo(Product::class, 'affiliate_id', 'id');
    }

    /**
     * get avatar url
     * @param boolean $urlencode mã hóa url
     * @return string 
     */
    public function getLogo()
    {
        if($this->logo && file_exists(public_path($p = 'static/users/'.get_secret_id($this->owner_id) . '/affiliates/' . $this->logo))){
            return asset($p);
        }
        $url = url('static/images/default.png');
        return $url;
    }
    public function priceFormat()
    {
        return get_currency_format($this->price);
    }
}
