<?php

namespace App\Repositories\Crawlers;

use App\Repositories\Posts\PostRepository;
use App\Repositories\Tags\TagRepository;
use App\Repositories\Tags\TagRefRepository;
use App\Repositories\Dynamics\DynamicRepository;
use App\Repositories\Files\FileRepository;
use App\Repositories\Metadatas\MetadataRepository;

use App\Exceptions\NotReportException;

use Carbon\Carbon;
use Crazy\Files\Image;
use Crazy\Helpers\Arr;

class CrawlPostRepository extends PostRepository
{
    use Crawler;
    /**
     * class chứ các phương thức để validate dử liệu
     * @var string $validatorClass
     */
    protected $validatorClass = 'App\Validators\Crawlers\CrawlPostValidator';

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
     * chiều rộng ảnh xem trước
     *
     * @var integer
     */
    public $thumbWidth = 414;

    /**
     * chiều cao ảnh
     *
     * @var integer
     */
    public $thumbHeight = 276;

    /**
     * @var string $formLayout
     */
    // protected $formLayout = 'forms.grid';

    public $featureImageWidth = 414;
    public $featureImageHeight = 276;

    public $socialImageWidth = 600;
    public $socialImageHeight = 315;

    /**
     * chay lai thiet lap
     */
    public function init()
    {
        parent::init();
        $this->setup('posts');
        $this->frames = new PostFrameRepository();
        $this->tags = new TagRepository();
        $this->tagRefs = new TagRefRepository();
        $this->dynamics = new DynamicRepository();
        $this->metadatas = new MetadataRepository();
        $this->fileRepository = new FileRepository();
    }




    /**
     * crawl post
     * @param array $args
     *
     * @param Frame $frame
     *
     * @return App\Models\Post|false
     */
    public function crawl(array $args = [], $frame = null)
    {
        $req = new Arr($args);


        // nếu ko tìm dc frame thì trả vè false
        if (!$frame && (!$req->frame_id || !$frame = $this->frames->first(['id'=>$req->frame_id]))) return false;
        try {
            $this->metadatas->addDefaultValue('owner_id', $frame->owner_id);
            $this->fileRepository->addDefaultValue('owner_id', $frame->owner_id);
            $this->tagRefs->addDefaultValue('owner_id', $frame->owner_id);
            $this->frames->addDefaultValue('owner_id', $frame->owner_id);
            $this->dynamics->addDefaultValue('owner_id', $frame->owner_id);
            $this->addDefaultValue('owner_id', $frame->owner_id);

            $frame->checkSelectors();

            $url = $this->parseUrl($req->url);
            $html = $this->getHtml($url, $frame->source_type);
            // nếu ko lấy dc nội dung trang web
            if (!$html) return false;

            $list_content = explode('|', $frame->content);
            $content = '';

            foreach ($list_content as $value) {
                if ($content == '' && $value && $value != '') {
                    $content .= $this->getContent($html->find($value, 0), null);
                }
            }

            if ($content == '') return false;
            $data = [
                'title' => html_entity_decode(strip_tags($this->getContent($html->find($frame->title, 0), $frame->title_attr)), ENT_QUOTES, "UTF-8"),
                'description' => $this->getContent($html->find($frame->description, 0), $frame->description_attr),
                'content' => $this->except($content, $frame->except, $frame),
                'category_id' => $req->category_id,
                'author_id' => $req->author_id,

            ];

            $qid = uniqid();
            if ($data['title'] == '' ||  $data['content'] == '') return false;

            $data['content'] .= $frame->style;
            $data['slug'] = str_slug($data['title'], '-');

            $meta = [
                'source_url' => $url,
                'meta_title' => $data['title'],
                'meta_description' => $data['description'],
                'qid' => $qid
            ];

            if ($req->dynamic_id && $dynamic = $this->dynamics->findBy('id', $req->dynamic_id)) {
                $this->resetDefaultParams();

                if ($this->first(['slug' => $data['slug'], 'dynamic_id' => $req->dynamic_id])) return false;
                $data['category_map'] = $this->makeCategoryMap($req->category_id);
                $data['dynamic_id'] = $req->dynamic_id;
                $image =  $this->getContent($html->find($frame->image, 0),  $frame->image_attr);
                $url = strpos($image, 'http') === 0 ? $image : $frame->url . $image;
                // lưu file ảnh
                $featureImage = @$this->saveFeatureImage(
                    $url,
                    $qid,
                    'posts',
                    414,
                    276,
                    'thumbs'
                );
                $data['feature_image'] = $featureImage;
                if ($featureImage && file_exists($fp = public_path('static/users/' . get_secret_id($this->crawlOwnerID) .'/posts/' . $featureImage))) {
                    $image = new Image($fp);
                    $sw = $this->socialImageWidth;
                    $sh = $this->socialImageHeight;
                    $imgW = $image->getWidth();
                    $imgH = $image->getHeight();

                    if ($imgW > $sw && $imgH > $sh) {
                        $image->resizeAndCrop($sw, $sh);
                        $this->featureImageWidth = $sw;
                        $this->featureImageHeight = $sh;
                    } elseif ($imgW >= 400 && $imgW < 500) {
                        $sw = 480;
                        $sh = 250;
                        $image->resizeAndCrop($sw, $sh);
                        $this->featureImageWidth = $sw;
                        $this->featureImageHeight = $sh;
                    } elseif ($imgW >= 500) {
                        $sw = 526;
                        $sh = 275;
                        $image->resizeAndCrop($sw, $sh);
                        $this->featureImageWidth = $sw;
                        $this->featureImageHeight = $sh;
                    } else {
                        $this->featureImageWidth = $image->getWidth();
                        $this->featureImageHeight = $image->getHeight();
                    }
                    $image->save(public_path('static/users/' . get_secret_id($this->crawlOwnerID) .'/posts/social/' . $featureImage));

                    $meta['og_image_width'] = $this->featureImageWidth;
                    $meta['og_image_height'] = $this->featureImageHeight;
                }
                // lưu bài viết
                // dd($data);
                $post = $this->save($data);
                // luu nwta
                if ($post) {
                    if ($tags = $this->addTag($html, $frame->tag, $frame->tag_attr)) {
                        $this->tagRefs->updateTagRef('post', $post->id, $tags ?? []);
                    }

                    $this->resources = [];
                    if ($req->crawl_resources) {
                        // cập nhật nội dung nếu có ãnh
                        $this->save(['content' => $this->saveResources($frame, $data['content'], $qid, 'users/' . get_secret_id($this->crawlOwnerID) .'/posts')], $post->id);
                    }

                    $meta['resources'] = $this->resources;
                    $this->metadatas->saveMany('post', $post->id, $meta);
                    $this->resources = [];
                    return $post;
                }
                return false;
            }
            return false;
        } catch (NotReportException $th) {
            return false;
        }
        return false;
    }
}
