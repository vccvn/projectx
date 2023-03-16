<?php

namespace App\Http\Controllers\Admin\General;

use Illuminate\Http\Request;
use App\Http\Controllers\Admin\AdminController;
use Crazy\Helpers\Arr;

use App\Repositories\Projects\ProjectRepository;
use App\Repositories\Tags\TagRefRepository;
use App\Repositories\Metadatas\MetadataRepository;
use App\Repositories\Files\FileRepository;

class ProjectController extends AdminController
{
    protected $module = 'projects';

    protected $moduleName = 'Dự án';

    protected $flashMode = true;

    
    /**
     * @var string $formLayout
    */
    // protected $formLayout = 'forms.grid';
    
    public $featureImageWidth = 400;
    public $featureImageHeight = 400;
    
    public $socialImageWidth = 600;
    public $socialImageHeight = 315;
    
    
    // protected $makeThumbnail = true;
    
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(ProjectRepository $projectRepository, TagRefRepository $tagRefRepository, MetadataRepository $metadataRepository, FileRepository $fileRepository)
    {
        $this->repository = $projectRepository;
        $this->tagRefRepository = $tagRefRepository;
        $this->metadataRepository = $metadataRepository;
        $this->fileRepository = $fileRepository;
        $this->init();
    }

    /**
     * can thiệp trước khi luu
     * @param Illuminate\Http\Request $request
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
        $this->uploadImageAttachFile($request, $data, 'feature_image', get_content_path('projects'));

        
        $this->makeSocialImage($data, $this->module);

    }

    public function beforeUpdate($request, $data, $result)
    {
        // dd($data);
    }
    
    /**
     * can thiệp sau khi luu
     * @param Illuminate\Http\Request $request
     * @param Model $project dũ liệu đã được luu
     * @param Arr $data 
     * @return void
     */
    public function afterSave(Request $request, $project, $data)
    {
        $tags =  $this->tagRefRepository->updateTagRef('project', $project->id, $data->tags??[]);
        $meta = $data->copy(
            [
                'custom_slug',
                'client_id',
                'website',
                'link',
                'feature_image_keep_original'
            ]
        );
        
        $meta['og_image_width'] = $this->featureImageWidth;
        $meta['og_image_height'] = $this->featureImageHeight;
        $metas = $this->metadataRepository->saveMany('project', $project->id, $meta);
        //nếu có gallery
        $this->fileRefRepository->updateFileRef('project', $project->id, $data->gallery??[]);
    }

}
