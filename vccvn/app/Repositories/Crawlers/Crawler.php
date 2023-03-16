<?php

namespace App\Repositories\Crawlers;
// use voku\helper\HtmlDomParser;
// use Sunra\PhpSimple\HtmlDomParser;
use App\Exceptions\NotReportException;
use Crazy\Html\Dom\HtmlDomParser;


use Carbon\Carbon;

use Crazy\Files\Image;
use Crazy\Helpers\Arr;
use Crazy\Apis\Api;
use Crazy\Files\Filemanager;
use Crazy\Http\Curl;

trait Crawler
{

    protected $folder = 'posts';


    protected $resources = [];


    protected $crawlOwnerID = 0;

    public function setCrawlOwnerID($id = 0)
    {
        $this->crawlOwnerID = $id;
    }

    /**
     * api class
     *
     * @var Api
     */
    public $api = null;


    public function setup($folder = 'posts')
    {
        $this->folder = $folder;
        $this->api = new Api();
    }
    /**
     * loại bỏ các thẻ không cần thiết
     * @param string $string $nội dung đầu vào
     * @param string $except Các selector cần loại bỏ. phân cách bằng dấu ^
     * 
     * @return string dử liệu trả về là chuỗi đã qua xử lý
     */
    public function except($string, $except)
    {
        $string = HtmlDomParser::str_get_html($string);
        if ($string == '')
            return '';
        foreach ($string->find('figure') as $v) {
            $v->attr = [];
        }
        $string->load($string->save());
        foreach ($string->find('a') as $v) {
            unset($v->attr['href']);
        }
        // $string->load($string->save());
        // foreach($string->find('table') as $value){
        //     $value->outertext.='<br>';
        // }
        $string->load($string->save());
        $except = explode('^', $except);
        foreach ($except as $v) {
            if ($v != '')
                foreach ($string->find(trim($v)) as $value) {
                    $value->outertext = '';
                };
        }
        $string->load($string->save());
        return $string->innertext;
    }

    /**
     * lưu trữ tài nguyên
     * @param App\Models\CrawlerFrame $frame
     * @param string $string
     * @param string $qid uniqid
     * @return string chuổi sau khi được thay thế các link
     */
    public function saveResources($frame, $string, $qid, $folder = null, $crawl_url = null)
    {
        if (!$folder) $folder = $this->folder;
        $string = HtmlDomParser::str_get_html($string);
        if(is_bool($string) || !$string) return $string;
        foreach ($string->find('video,source,img') as $value) {
            if (isset($value->attr['src']) && $value->attr['src']) {
                $a = substr($value->attr['src'], 0, 10);
                if($a == 'data:image' && isset($value->attr['data-src']) && $value->attr['data-src']){
                    $value->attr['src'] = $value->attr['data-src'];
                    $string->load($string->save());
                }
                if (isset($value->attr['src']) && $value->attr['src'] != '' && $a != 'data:image') {
                    $url = $this->parseSourceUrl($value->attr['src'], $crawl_url, $frame->url);
                    if ($src = @$this->uploadFromUrl($url, $qid, $folder)) {
                        $value->attr['src'] = $src;
                    }
                }
            }
        }
        $string->load($string->save());
        return $string->innertext;
    }




    /**
     * lấy từ khóa từ trang crawl
     * @param object $html
     * @param string $tag selector
     * @param string tag attr
     * @return array
     */
    public function addTag($html, $tag, $attr_tag)
    {
        $tag_list = [];

        foreach ($html->find($tag) as $value) {
            $tags = $this->getContent($value, $attr_tag);

            if ($tagList = $this->tags->createTags($tags)) {
                foreach ($tagList as $t) {
                    $tag_list[] = $t->id;
                }
            }
        }
        return $tag_list;
    }

    /**
     * lấy từ khóa từ trang crawl
     * @param object $html
     * @param string $tag selector
     * @param string tag attr
     * @return array
     */
    public function getTag($html, $tag, $attr_tag)
    {
        foreach ($html->find($tag) as $value) {
            return $this->getContent($value, $attr_tag);
        }
        return '';
    }

    /**
     * upload tài nguyên từ url
     * @param string $url
     * @param string $qid id duy nhất
     * @param string $folder thư mục lưu file
     * @return string url tài nguyên
     */
    public function uploadFromUrl($url, $qid, $folder = null)
    {
        // if(!$folder) $folder = 'users/' . get_secret_id($this->crawlOwnerID) .'/' . $this->folder;
        $p = get_content_path($folder ? $folder : $this->folder, $this->crawlOwnerID);
        if (preg_match('/^image\//si', $url)) {
            $filemanager = new Filemanager(public_path($p));
            $name = $qid . md5(microtime());
            if ($file = $filemanager->saveBase64($url, $name)) {
                $this->resources[] = $file->filename;
                $path = $p . '/' . $file->filename;
                return url_relative(asset($path));
            } else {
                return null;
            }
        }

        $name = $qid . '-' . substr($url, strrpos($url, '/') + 1);
        if (count($s = explode('?', $name)) == 2) {
            $name = $s[0];
        }
        $path = $p . '/' . $name;

        $contents = @file_get_contents($url);
        $fp = public_path($path);
        @file_put_contents($fp, $contents);
        if (!file_exists($fp)) return null;
        $this->resources[] = $name;
        return url_relative(asset($path));
    }

    /**
     * upload hình đạ diện cho bài viết
     * @param string $url
     * @param string $qid id duy nhất
     * @param string $folder thư mục lưu file
     * @param int $width do rong cua anh
     * @param int $height Chieu cao cua anh
     * @param string $sub thu muc con
     * @return string tên file
     */
    public function saveFeatureImage($url, $qid, $folder = null, $width = null, $height = null, $sub = null)
    {
        // if(!$folder) $folder = 'users/' . get_secret_id($this->crawlOwnerID) .'/' .$this->folder;
        $path = get_content_path($folder ? $folder : $this->folder, $this->crawlOwnerID);
        $name = $qid . '-' . substr($url, strrpos($url, '/') + 1);
        $nn = explode('?', $name);
        $name = $nn[0];
        $p = public_path($path . '/' . $name);

        if (Image::getsity($url)) {
            $image = new Image($url);

            if ($image->save($p) && file_exists($p)) {
                if ($width && $height) {
                    $img = new Image($p);
                    $a = $sub ? $sub : $width . 'x' . $height;
                    $img->resizeAndCrop($width, $height);
                    $img->save(public_path($path . '/' . $a . '/' . $name));
                }
                $image->resizeAndCrop(90, 90);
                $image->save(public_path($path . '/90x90/' . $name));

                return $name;
            } else {
                // $content = file_get_contents($url);
                $curl = new Curl($url);
                $content = $curl->get();

                file_put_contents($p, $content);
                if (file_exists($p)) {
                    $image = new Image($p);
                    if ($width && $height) {
                        $img = new Image($p);
                        $a = $sub ? $sub : $width . 'x' . $height;
                        $img->resizeAndCrop($width, $height);
                        $img->save(public_path($path . '/' . $a . '/' . $name));
                    }
                    $image->resizeAndCrop(90, 90);
                    $image->save(public_path($path . '/90x90/' . $name));
                    return $name;
                }
            }
        } else {

            // $content = file_get_contents($url);
            $curl = new Curl($url);
            $content = $curl->get();

            file_put_contents($p, $content);
            if (file_exists($p)) {
                $image = new Image($p);
                if ($width && $height) {
                    $img = new Image($p);
                    $a = $sub ? $sub : $width . 'x' . $height;
                    $img->resizeAndCrop($width, $height);
                    $img->save(public_path($path . '/' . $a . '/' . $name));
                }
                $image->resizeAndCrop(90, 90);
                $image->save(public_path($path . '/90x90/' . $name));
                return $name;
            }
        }

        return null;
    }

    /**
     * lấy nội dung từ thẻ html
     * @param mixed $html thẽ
     * @param string $attr thuộc tính của thẻ
     * @return string nội dung 
     */
    public function getContent($html, $attr)
    {
        $result = '';

        if ($attr) {
            if (isset($html->attr[$attr]))
                $result = $html->attr[$attr];
        } elseif (isset($html->innertext)) {
            $result = $html->innertext;
        }

        $result = preg_replace('/&#39;/', '', trim($result));
        return preg_replace('/&quot;/', '"', $result);
    }


    public function sendRequest($url, $source_type = 'ssr')
    {
        $params = [];
        if ($source_type == 'csr' || preg_match('/(lazada|shopee|sendo)\.vn\//i', $url)) {
            $url = env('CRAWLER_BOT_API') . '?url=' . urlencode($url);
        } elseif (preg_match('/soha\.vn\//i', $url)) {
            $params = [
                "api_key" => env('SCRAPING_API_KEY'),
                'device' => 'desktop',
                # 'proxy_type'=> 'datacenter',
                # 'country'=> 'au',
                "url" => $url,
                "render_js" => 1,
                'wait_for' => 2,
                'timeout' => '60000',
                # 'wait_until"=> 'networkidle2'
            ];
            $url = env("SCRAPING_API_URL");
        }
        try {
            // dd($url);
            $rs = $this->api->get($url, $params);
            
            if ($rs) {
                $content = $rs->getBody()->getContents();
            } elseif (function_exists('curl_init')) {
                $curl = new Curl($url);
                $content = $curl->get();
            } else {
                $content = file_get_contents($url);
            }
        } catch (NotReportException $e) {
            $content = null;
        }
        return $content;
    }


    public function getHtmlRaw($url, $method = 'GET')
    {
        try {
            $rs = $this->api->send($url, 'GET');
            if ($rs) {
                $content = $rs->getBody()->getContents();
            } else {
                $curl = new Curl($url);
                $content = $curl->get();
            }
        } catch (NotReportException $e) {
            $content = null;
        }
        return $content;
    }


    public function toDom($html)
    {
        return HtmlDomParser::str_get_html($html);
    }

    /**
     * lấy nội dung từ trang
     * @param string $url
     * @return htmlDom
     */
    public function getHtml($url, $source_type = 'ssr')
    {
        return $this->toDom($this->sendRequest($url, $source_type));
    }


    public function parseUrl($url, $frame = null)
    {
        $u = $url;
        if (strpos($url, 'http') === 0) return $u;
        if (substr($url, 0, 2) == '//') {
            if ($frame) {
                $prot = explode('://', $frame->url);
                if (count($prot) == 2) {
                    $u = $prot[0] . ':' . $u;
                } else {
                    $u = 'http:' . $u;
                }
            } else {
                $u = 'http:' . $u;
            }
        } elseif (substr($url, 0, 1) == '/') {
            if ($frame) {
                $u = rtrim($frame->url, '/') . $u;
            }
        }
        return $u;
    }

    public function parseSourceUrl($source_url, $task_url, $frame_url)
    {
        $url = '';
        if (substr($source_url, 0, 2) == '//') {
            $a = explode('//', $frame_url);

            $url = $a[0] . $source_url;
        } elseif (substr($source_url, 0, 1) == '/') $url = rtrim($frame_url, '/') . '/' . ltrim($source_url, '/');
        elseif (substr($source_url, 0, 1) == '?') {
            // $url = rtrim($frame_url, '/') . '/' . ltrim($source_url, '/');
            $a = explode('?', $task_url);
            $url = $a[0] . $source_url;
        } elseif (substr($source_url, 0, 4) == 'http') $url = $source_url;
        else {
            $tp = explode('/', $task_url);
            array_pop($tp);
            $sp = explode('/', $source_url);
            $stop = false;
            $t = count($sp);
            $pat = '';
            for ($i = 0; $i < $t; $i++) {
                $p = $sp[$i];
                if ($stop) {
                    $pat .= '/' . $p;
                } elseif (!$p == '..') {
                    array_pop($tp);
                } else {
                    if ($p != '.') {
                        $pat .= '/' . $p;
                        $stop = true;
                    }
                }
            }
            $url = implode('/', $tp) . $pat;
        }
        return $url;
    }
}
