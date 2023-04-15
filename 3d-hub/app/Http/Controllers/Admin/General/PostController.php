<?php

namespace App\Http\Controllers\Admin\General;

use Illuminate\Http\Request;
use App\Http\Controllers\Admin\AdminController;

use App\Repositories\Posts\CategoryRepository;
use App\Repositories\Posts\PostRepository;
use App\Repositories\Metadatas\MetadataRepository;
use App\Repositories\Dynamics\DynamicRepository;
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
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(
        PostRepository $PostRepository, 
        CategoryRepository $CategoryRepository, 
        MetadataRepository $MetadataRepository, 
        DynamicRepository $DynamicRepository, 
        TagRefRepository $TagRefRepository, 
        FileRepository $fileRepository
    )
    {
        if(admin_check_dynamic()){
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
        $dynamic = $this->dynamic??get_web_data('dynamic');
        // set thuoc tinh action cho form bang url dynamic post
        $attrs->action = admin_dynamic_url('save');
        $this->cancelButtonUrl = admin_dynamic_url('list');
        
        $config->input_type = 'list';
        $inputs = $this->repository->getFormInputs($this->formDir);
        $config->form_config = $dynamic->form_config;
        if($dynamic->post_type != 'custom'){
            if(isset($inputs['content_type'])){
                $inputs['content_type']['type'] = 'hidden';
                if($dynamic->post_type != 'article'){
                    $inputs['content_type']['value'] = $dynamic->post_type;
                }
            }
        }
        $config->inputs = $inputs;
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

        // if(count($posts = $this->repository->get())){
        //     foreach ($posts as $key => $post) {
        //         if($post->feature_image && file_exists($p = public_path('static/posts/'.$post->feature_image))){
        //             $image = new Image($p);
        //             $image->resizeAndCrop($this->thumbWidth, $this->thumbHeight);
        //             $image->save(public_path('static/posts/thumbs/'.$post->feature_image));
        //         }
        //     }
        // }
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
        if($post->og_image_width) $this->featureImageWidth = $post->og_image_width;
        if($post->og_image_height) $this->featureImageWidth = $post->og_image_height;
        
    }

    /**
     * can thiệp trước khi luu
     * @param Illuminate\Http\Request $request
     * @param Arr $data dũ liệu đã được validate
     * @return void
     */
    protected function beforeSave(Request $request, $data)
    {
        $slug = str_slug($request->custom_slug? $request->slug : $request->title);
        $data->slug = $this->repository->getSlug(
            $slug?$slug : uniqid(),
            $request->id
        );
        if($data->category_id){
            $data->category_map = $this->repository->makeCategoryMap($data->category_id);
        }
        
        // upload và cap nhật file ành
        $this->uploadImageAttachFile($request, $data, 'feature_image', 'static/posts', $this->thumbWidth, $this->thumbHeight);

        // nếu không có ảnh chính
        if(!$data->feature_image && ($this->dynamic->post_type=='video_embed' || $request->content_type=='video_embed') && $video = get_video_from_url($data->video_url)){
            if($filename = $this->repository->saveFeatureImageFromUrl($video->thumbnail)){
                $data->feature_image = $filename;
                $image = new Image(public_path('static/posts/'.$data->feature_image));
                $image->resizeAndCrop($this->thumbWidth, $this->thumbHeight);
                $image->save(public_path('static/posts/thumbs/'.$data->feature_image));
                
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

        $this->tagRefs->updateTagRef('post', $result->id, $data->tags??[]);


        // meta data
        $meta = $data->copy([
                'custom_slug',
                'meta_title',
                'meta_description',
                'feature_image_keep_original'
        ]);
        // thuộc tính nâng co nếu có
        foreach ($this->repository->getPropInputs() as $inp) {
            $meta[$inp['name']] = $data->{$inp['name']};
        }
        $type = $request->content_type;
        $addonMetaKey = ($type == 'news')?'source' : ($type == 'video_embed' ? 'video_url' : null);
        if($addonMetaKey){
            $meta[$addonMetaKey] = $data->{$addonMetaKey};
        }
        $meta['og_image_width'] = $this->featureImageWidth;
        $meta['og_image_height'] = $this->featureImageHeight;
        $this->metadatas->saveMany('post', $result->id, $meta);
 

        //nếu có gallery
        if(($this->dynamic->post_type == 'gallery' || $type == 'gallery' || $this->dynamic->use_gallery)){
            if($request->id == $result->id){
                $this->fileRepository->deleteRefFileIgnoreList('post', $result->id, is_array($request->gallery_ids)?$request->gallery_ids:[]);
            }
            if($request->gallery_data){
                $this->fileRepository->saveBase64List($request->gallery_data, 'post', $result->id, $request->user()->id);
            }
        }
    }
    

    /**
     * Thiết lập form
     */
    public function getPostConfigForm(Request $request)
    {
        $dynamic = $this->dynamic??get_web_data('dynamic');
        $submit_url = admin_dynamic_url('save-config');
        $delete_form_group_url = admin_dynamic_url('delete-form-group');
        // set thuoc tinh action cho form bang url dynamic post
        $form_inputs = $this->repository->getFormInputs($this->getFormDir());
        
        $form_config = $dynamic->form_config;
        if($form_config){
            if(!is_array($form_config)) $form_config = json_decode($form_config, true);
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
        $dynamic = $this->dynamic??get_web_data('dynamic');
        if($this->dynamicRepository->updateMetadataJson($dynamic->id, 'form_config', 'form_groups', $request->form_groups)){
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
        $dynamic = $this->dynamic??get_web_data('dynamic');
        $form_groups = [];
        if($request->form_groups && is_array($request->form_groups)){
            foreach ($request->form_groups as $index => $group) {
                if($request->remove_index && $index == $request->remove_index) continue;
                $form_groups[] = $group;
            }
        }
        if($this->dynamicRepository->updateMetadataJson($dynamic->id, 'form_config', 'form_groups', $request->form_groups)){
            $status = true;
        }
        
        return $this->json(compact(...$this->apiSystemVars));
    }

}
