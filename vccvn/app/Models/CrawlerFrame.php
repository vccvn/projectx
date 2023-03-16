<?php

namespace App\Models;

class CrawlerFrame extends Model
{
    public $table = 'crawler_frames';
    public $fillable = ['owner_id', 'name', 'type', 'url', 'logo', 'index', 'selectors', 'deleted'];



    /**
     * @var array $jsonFields các cột dùng kiểu json
     */
    protected $jsonFields = ['selectors'];

    /**
     * @var array $crawlerSelectors
     */
    public $crawlerSelectors = [
        'title', 'title_attr',
        'product_name', 'product_name_attr',
        'description', 'description_attr',
        'content',
        'regular_price', 'regular_price_attr',
        'old_price', 'old_price_attr',
        'decimal_poiter', 'thousands_sep',
        'detail',
        'tag', 'tag_attr',
        'image', 'image_attr',
        'gallery', 'gallery_attr',
        'slug',
        'source_type',
        'item_url_selector',
        'meta_title',
        'meta_description',
        'meta_keyword',
        'except',
        'style',
        'use_loadmore',
        'loadmore_method',
        'loadmore_link_selector',
        'loadmore_scroll_selector',
        'loadmore_turn'
    ];

    /**
     * task thuộc frame
     * @return QueryBuildder
     */
    public function tasks()
    {
        return $this->hasMany('App\Models\CrawlerTask', 'frame_id', 'id');
    }
    /**
     * check Selector
     * 
     */
    public function checkSelectors()
    {
        $data = [];
        if ($this->selectors) {
            $selectors = json_decode($this->selectors, true);
            if (is_array($selectors) && count($selectors)) {
                $data = $selectors;
                foreach ($selectors as $key => $value) {
                    $this->{$key} = $value;
                }
            }
        }
        return $data;
    }

    /**
     * lay du lieu form
     * @return array
     */
    public function toFormData()
    {
        $data = $this->toArray();
        if ($this->selectors) {
            $selectors = json_decode($this->selectors, true);
            if (is_array($selectors) && count($selectors)) {
                $data = array_merge($data, $selectors);
            }
        }
        return $data;
    }


    /**
     * get avatar url
     * @param boolean $urlencode mã hóa url
     * @return string 
     */
    public function getLogo($urlencode = false)
    {
        if ($this->logo) {
            $logo = $this->getSecretPath() . '/crawlers/' . $this->logo;
        } else {
            $logo = 'static/images/default.png';
        }
        $url = asset($logo);
        if ($urlencode) return urlencode($url);
        return $url;
    }

    /**
     * xoa avatar
     */
    public function deleteLogo()
    {
        if ($this->logo && file_exists($path = public_path($this->getSecretPath() . '/crawlers/' . $this->logo))) {
            unlink($path);
        }
    }

    /**
     * ham xóa file cũ
     * @param int $id
     * 
     * @return boolean
     */
    public function deleteAttachFile()
    {
        return $this->deleteLogo();
    }

    /**
     * lấy tên file đính kèm cũ
     */
    public function getAttachFilename()
    {
        return $this->logo;
    }


    /**
     * xóa dữ liệu
     */
    public function beforeDelete()
    {
        $this->tasks()->delete();
        // delete image
        $this->deleteLogo();
    }
}
