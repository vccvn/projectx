<?php

namespace App\Http\Controllers\Admin\General;

use Illuminate\Http\Request;
use App\Http\Controllers\Admin\AdminController;

use App\Repositories\Posts\CategoryRepository;
use App\Repositories\Posts\PostRepository;
use App\Repositories\Metadatas\MetadataRepository;
use App\Repositories\Dynamics\DynamicRepository;
use App\Repositories\Files\FileRefRepository;
use App\Repositories\Tags\TagRefRepository;
use App\Repositories\Files\FileRepository;
use Crazy\Files\Image;
use Crazy\Helpers\Arr;
use Exception;

class PostController extends AdminController
{
    /**
     * @var string $module
     */
    protected $module = 'posts';
    /**
     * @var string $moduleName Tên module để hiển thị trong một số tác vụ 
     */
    protected $moduleName = 'Tin bài';
    /**
     * @var string $redirectRoute route đề chuyển hướng khi luu data
     */
    protected $redirectRoute = 'posts.update';
    /**
     * @var \App\Models\Dynamic $dynamic cha của mấy thằng post =))
     */
    protected $dynamic = null;

    /**
     * @var \App\Repositories\Dynamics\DynamicRepository $dynamicRepository
     */
    protected $dynamicRepository;

    /**
     * @var \App\Repositories\Metadatas\MetadataRepository $MetadataRepository
     * Quản lý meta data
     */
    protected $metedatas;

    /**
     * @var \App\Repositories\Posts\CategoryRepository $categories
     * Quản lý danh mục
     */
    protected $categories;

    /**
     * @var \App\Repositories\Tags\TagRefRepository $tagRefs
     * @quản lý liên kết thẻ
     */
    protected $tagRefs;

    /**
     * @var \App\Repositories\Files\FileRepository $fileRepository
     * Quản lý file upload
     */
    protected $fileRepository;


    /**
     * lien ket file
     *
     * @var FileRefRepository
     */
    protected $fileRefRepository;
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


    protected $makeThumbnail = true;

    /**
     * main repository
     *
     * @var PostRepository $repository
     */
    public $repository = null;
    /**
     * Create a new controller instance.
     *
     * @param PostRepository $PostRepository
     * @param CategoryRepository $CategoryRepository
     * @param MetadataRepository $MetadataRepository
     * @param DynamicRepository $DynamicRepository
     * @param TagRefRepository $TagRefRepository
     * @param FileRepository $fileRepository
     * @param FileRefRepository $fileRefRepository
     * @return void
     */
    public function __construct(
        PostRepository $PostRepository,
        CategoryRepository $CategoryRepository,
        MetadataRepository $MetadataRepository,
        DynamicRepository $DynamicRepository,
        TagRefRepository $TagRefRepository,
        FileRepository $fileRepository,
        FileRefRepository $fileRefRepository
    ) {
        if (admin_check_dynamic()) {
            $dynamic = get_web_data('dynamic');
            $this->dynamic = $dynamic;
            $this->activeMenu($dynamic->slug);
            $this->moduleName = $dynamic->name;
            $PostRepository->dynamicInit();
        }

        $this->repository = $PostRepository;
        $this->categories = $CategoryRepository;
        $this->metadatas = $MetadataRepository;
        $this->dynamicRepository = $DynamicRepository;
        $this->tagRefs = $TagRefRepository;
        $this->fileRepository = $fileRepository;
        $this->fileRefRepository = $fileRefRepository;
        $this->init();
    }


    /**
     * chuan bi truoc cho hiển thị crud form
     * @param Request $request
     * @param Arr $config
     * @param Arr $attrs
     * @param Arr $vars
     *
     * @return void
     */
    public function prepareGetCrudForm(Request $request, Arr $config, Arr $attrs, Arr $vars)
    {
        $dynamic = $this->dynamic ?? get_web_data('dynamic');
        // set thuoc tinh action cho form bang url dynamic post
        $attrs->action = admin_dynamic_url('save');
        $attrs->novalidate = 'true';
        $this->cancelButtonUrl = admin_dynamic_url('list');

        $config->input_type = 'list';
        $inputs = $this->repository->getFormInputs($this->formDir);
        $config->form_config = $dynamic->form_config;
        if ($dynamic->post_type != 'custom') {
            if (isset($inputs['content_type'])) {
                $inputs['content_type']['type'] = 'hidden';
                if ($dynamic->post_type != 'article') {
                    $inputs['content_type']['value'] = $dynamic->post_type;
                }
            }
        }
        $config->inputs = $inputs;
        // dd($inputs);
        admin_action_menu([
            [
                'url' => admin_dynamic_url('config'),
                'text' => 'Cấu hình form',
                'icon' => 'fa fa-cog'
            ]
        ]);

        add_js_data('post_data', [
            'post_type' => $dynamic->post_type,
            'use_gallery' => $dynamic->use_gallery,
        ]);

        add_js_src('static/manager/js/posts.form.js');
    }


    public function beforeGetUpdateForm($request, $config, $inputs, $data, $attribues)
    {
        foreach ($inputs->all() as $name => $inp) {
            if ($inp['type'] == 'media') {
                if ($v = $data->get($inp['name'])) {
                    if (($id = str_replace('@mediaid:', '', $v)) != $v) {
                        $data->set($inp['name'], $id);
                        // if ($file = get_media_file(['id' => $id])) {
                        //     $val = $file->source;
                        // } else {
                        //     $val = null;
                        // }
                        // $data->set($inp['name'], $val);
                    }
                }
            }
        }
    }

    public function beforeGetCrudForm($request, $config, $inputs, $data, $attribues)
    {
        $baseTitle = (($this->dynamic->use_category && $data->category_id && $category = get_post_category(['id' => $data->category_id])) ? $category->name . ' | ' : ''
        ) . $this->dynamic->name . ' | ' . siteinfo('site_name');
        add_js_data('seo_data', [
            'baseURL' => url($this->dynamic->slug) . '/',
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
                'baseURL' => url($this->dynamic->slug) . '/',
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
     * can thiệp trước khi tạo mới
     * @param Illuminate\Http\Request $request
     * @param Arr $data dữ liệu đã được validate
     * @return void
     */
    protected function beforeCreate(Request $request, $data)
    {
        // $data->dynamic_id = get_web_data('dynamic')->id;
        $data->author_id = $request->user()->id;
    }

    public function beforeUpdate(Request $request, Arr $data, $post)
    {
        $post->applyMeta();
        if ($post->og_image_width) $this->featureImageWidth = $post->og_image_width;
        if ($post->og_image_height) $this->featureImageWidth = $post->og_image_height;
    }

    /**
     * can thiệp trước khi luu
     * @param Request $request
     * @param Arr $data dũ liệu đã được validate
     * @return void
     */
    protected function beforeSave(Request $request, $data)
    {
        $data->keywords = $data->focus_keyword;
        $slug = str_slug($request->custom_slug ? $request->slug : $request->title);
        $data->slug = $this->repository->getSlug(
            $slug ? $slug : uniqid(),
            $request->id
        );
        if ($data->category_id) {
            $data->category_map = $this->repository->makeCategoryMap($data->category_id);
        }

        // upload và cap nhật file ành
        $this->uploadImageAttachFile($request, $data, 'feature_image', get_content_path('posts'), $this->thumbWidth, $this->thumbHeight);

        // nếu không có ảnh chính
        if (!$data->feature_image && ($this->dynamic->post_type == 'video_embed' || $request->content_type == 'video_embed') && $video = get_video_from_url($data->video_url)) {
            if ($filename = $this->repository->saveFeatureImageFromUrl($video->thumbnail)) {
                $data->feature_image = $filename;
                $image = new Image(public_path(get_content_path('posts/' . $data->feature_image)));
                $image->resizeAndCrop($this->thumbWidth, $this->thumbHeight);
                $image->save(public_path(get_content_path('posts/thumbs/' . $data->feature_image)));
            }
        }

        $this->makeSocialImage($data, 'posts');
    }




    /**
     * can thiệp sau khi luu
     * @param Illuminate\Http\Request $request
     * @param App\Models\Model $model bản ghi sau khi được lưu trữ
     * @return void
     */
    public function afterSave(Request $request, $result, $data)
    {
        // thay đổi route chuyển hướng
        $this->redirectRouteParams = [
            'dynamic' => $request->route('dynamic'),
            'id' => $result->id
        ];

        $this->tagRefs->updateTagRef('post', $result->id, $data->tags ?? []);



        // meta data
        $meta = $data->copy([
            'custom_slug',
            'focus_keyword',
            'meta_title',
            'meta_description',
            'feature_image_keep_original'
        ]);
        // thuộc tính nâng co nếu có
        foreach ($this->repository->getPropInputs() as $inp) {
            if ($inp['type'] == "file") {
                if ($request->hasFile($inp['name'])) {
                }
            } elseif ($inp['type'] == 'media') {
                $meta[$inp['name']] = '@mediaid:' . $data->{$inp['name']};
            } else {
                $meta[$inp['name']] = $data->{$inp['name']};
            }
        }
        $type = $request->content_type;
        $addonMetaKey = ($type == 'news') ? 'source' : ($type == 'video_embed' ? 'video_url' : null);
        if ($addonMetaKey) {
            $meta[$addonMetaKey] = $data->{$addonMetaKey};
        }
        $meta['og_image_width'] = $this->featureImageWidth;
        $meta['og_image_height'] = $this->featureImageHeight;
        $this->metadatas->saveMany('post', $result->id, $meta);



        //nếu có gallery
        if (($this->dynamic->post_type == 'gallery' || $type == 'gallery' || $this->dynamic->use_gallery)) {
            $this->fileRefRepository->updateFileRef('post', $result->id, $data->gallery ?? []);
        }
    }


    /**
     * Thiết lập form
     */
    public function getPostConfigForm(Request $request)
    {
        $dynamic = $this->dynamic ?? get_web_data('dynamic');
        $submit_url = admin_dynamic_url('save-config');
        $delete_form_group_url = admin_dynamic_url('delete-form-group');
        // set thuoc tinh action cho form bang url dynamic post
        $form_inputs = $this->repository->getFormInputs($this->getFormDir());

        $form_config = $dynamic->form_config;
        if ($form_config) {
            if (!is_array($form_config)) $form_config = json_decode($form_config, true);
        }

        // dd($form_config);
        return $this->view('forms.config', compact('form_config', 'form_inputs', 'submit_url', 'delete_form_group_url'));
    }

    /**
     * lưu thiết lập form
     * @param Request $request
     * @return response::json
     */
    public function saveConfig(Request $request)
    {
        extract($this->apiDefaultData);
        $dynamic = $this->dynamic ?? get_web_data('dynamic');
        if ($this->dynamicRepository->updateMetadataJson($dynamic->id, 'form_config', 'form_groups', $request->form_groups)) {
            $status = true;
        }


        return $this->json(compact(...$this->apiSystemVars));
    }


    /**
     * lưu thiết lập form
     * @param Request $request
     * @return response::json
     */
    public function deleteFormGroup(Request $request)
    {
        extract($this->apiDefaultData);
        $dynamic = $this->dynamic ?? get_web_data('dynamic');
        $form_groups = [];
        if ($request->form_groups && is_array($request->form_groups)) {
            foreach ($request->form_groups as $index => $group) {
                if ($request->remove_index && $index == $request->remove_index) continue;
                $form_groups[] = $group;
            }
        }
        if ($this->dynamicRepository->updateMetadataJson($dynamic->id, 'form_config', 'form_groups', $request->form_groups)) {
            $status = true;
        }

        return $this->json(compact(...$this->apiSystemVars));
    }


    /**
     * lấy danh sách category
     * @param Request $request
     */
    public function getCategoryOptions(Request $request)
    {
        extract($this->apiDefaultData);

        if ($request->dynamic_id) {
            $status = true;
            if ($options = $this->categories->getCategoryOptions(['dynamic_id' => $dynamic->id])) {
                $data = $options;
            }
        }

        return $this->json(compact(...$this->apiSystemVars));
    }
}
