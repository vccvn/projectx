<?php

namespace App\Models;

class ProductReview extends Model
{
    public $table = 'product_reviews';
    public $fillable = [
        'owner_id', 'product_id', 'customer_id', 'approved_id', 
        'rating', 'name', 'email', 'comment', 
        'approved', 'approved_id'
    ];

    /**
     * lay du lieu form
     * @return array
     */
    public function toFormData()
    {
        $data = $this->toArray();
        return $data;
    }

    
    public function timeFormat($format = 'd/m/Y')
    {
        return date($format, strtotime($this->created_at));
    }

    public function getReviewerName()
    {
        return $this->name?$this->name:$this->customer_name;
    }
    public function getReviewerEmail()
    {
        return $this->email?$this->email:$this->customer_email;
    }

    
    /**
     * get image url
     * @param boolean $urlencode mã hóa url
     * @return string 
     */
    public function getFeatureImage($size=false)
    {
        if($this->feature_image){
            $feature_image = $this->feature_image;
        }else{
            $feature_image = 'default.png';
        }
        $fd = $this->getSecretPath() . '/products';
        if($size && file_exists(public_path($fd.'/'.$size.'/'.$feature_image))){
            return asset($fd.'/'.$size.'/'.$feature_image);
        }elseif(file_exists(public_path($fd.'/'.$feature_image))){
            return asset($fd.'/'.$feature_image);
        }
        return asset('static/images/product.png');
    }

    
    
    /**
     * get avatar url
     * @param boolean $urlencode mã hóa url
     * @return string 
     */
    public function getAvatar($urlencode=false)
    {
        if($this->avatar){
            $avatar = $this->getSecretPath() .'/avatar/' . $this->avatar;

        }else{
            $avatar = 'static/images/avatar.png';
        }
        $url = url($avatar);
        if($urlencode) return urlencode($url);
        return $url;
    }
}
