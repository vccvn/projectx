<?php

namespace App\Http\Controllers\Admin\General;

use Illuminate\Http\Request;
use App\Http\Controllers\Admin\AdminController;

use App\Repositories\Pages\PageRepository;
use App\Repositories\Tags\TagRefRepository;
use App\Repositories\Metadatas\MetadataRepository;
use App\Repositories\Files\FileRepository;
use Crazy\Helpers\Arr;

class PageController extends AdminController
{
    protected $module = 'pages';

    protected $moduleName = 'Trang';
    

    /**
     * @var App\Repositories\Pages\PageRepository $repository
     */
    public $repository;
    
    /**
     * @var App\Repositories\Tags\TagRefRepository $tagRefs
     * @quản lý liên kết thẻ
     */
    protected $tagRefs;

    /**
     * @var App\Repositories\Files\FileRepository $fileRepository
     * Quản lý file upload
     */
    protected $fileRepository;

    /**
     * @var string $formLayout
    */
    // protected $formLayout = 'forms.grid';
    
    
    protected $makeThumbnail = true;

    
    
    /**
     * @var string $formLayout
    */
    // protected $formLayout = 'forms.grid';
    
    public $featureImageWidth = 400;
    public $featureImageHeight = 300;
    
    public $socialImageWidth = 600;
    public $socialImageHeight = 315;
    
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(PageRepository $pageRepository, MetadataRepository $MetadataRepository, TagRefRepository $tagRefRepository, FileRepository $fileRepository)
    {
        $this->repository = $pageRepository;

        $this->metadatas = $MetadataRepository;

        $this->tagRefs = $tagRefRepository;

        $this->fileRepository = $fileRepository;

        $this->init();
        
    }

    
    public function beforeGetCrudForm($request, $config, $inputs, $data, $attribues)
    {
        $parent = $data->parent_id?get_page(['id' => $data->parent_id]):null;
        $baseTitle = ($parent ? $parent->title . ' | ' : ''
        ) .  siteinfo('site_name');
        add_js_data('seo_data', [
            'baseURL' => url($parent?$parent->slug:'') . '/',
            'data' => [
                'urlParh' => $data->slug,
                'title' => $data->meta_title,
                'metaDesc' => $data->meta_description,
                'content' => $data->content,
                'focusKeyword' => $data->focus_keyword,
                'fullTitle' => ($data->title ? $data->title . ' | ' : '') . $baseTitle,
                'baseTitle' => $baseTitle
            ],
            '__default__' => [
                'baseURL' => url($parent?$parent->slug:'') . '/',
                'baseTitle' => $baseTitle
            ],
            '__placeholder__' => [
                'title' => $data->meta_title?$data->meta_title:(($data->title ? $data->title . ' | ' : 'Tiêu đề | ') . $baseTitle),
                'urlPath' => $data->slug??'slug'
            ]

        ]);

        // dd($data->all());
    }

    
    /**
     * can thiệp trước khi luu
     * @param Request $request
     * @param Arr $data dũ liệu đã được validate
     * @return void
     */
    protected function beforeSave(Request $request, Arr $data)
    {
        if(!$request->id){
            $data->author_id = $request->user()->id;
        }
        $data->slug = $this->repository->getSlug(
            $request->custom_slug? $request->slug : $request->title,
            $request->id
        );
        $this->uploadImageAttachFile($request, $data, 'feature_image', get_content_path('pages'), 400, 300);

        $this->makeSocialImage($data, $this->module);
    }

    
    /**
     * can thiệp sau khi luu
     * @param Request $request
     * @param Model $result dũ liệu đã được luu
     * @param Arr $data 
     * @return void
     */
    public function afterSave(Request $request, $result, $data)
    {
        $this->tagRefs->updateTagRef('page', $result->id, $data->tags??[]);
        $meta = $data->copy(
            [
                'custom_slug',
                'focus_keyword',
                'meta_title',
                'meta_description',
                'feature_image_keep_original'
            ]
        );
        
        $meta['og_image_width'] = $this->featureImageWidth;
        $meta['og_image_height'] = $this->featureImageHeight;
        $metas = $this->metadatas->saveMany('page', $result->id, $meta);

    }





    /**
     * tim kiếm thông tin người dùng 
     * @param Request $request
     * @return json
     */
    public function getPageSelectOptions(Request $request)
    {
        extract($this->apiDefaultData);

        if($options = $this->repository->getPageSelectOptions($request)){
            $data = $options;
            $status = true;
        }else{
            $message = 'Không có kết quả phù hợp';
        }

        return $this->json(compact(...$this->apiSystemVars));
    }

}
