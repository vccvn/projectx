<?php

namespace App\Http\Controllers\Admin\General;

use Illuminate\Http\Request;
use App\Http\Controllers\Admin\AdminController;

use App\Repositories\Tags\TagRepository;

use Crazy\Helpers\Arr;

class TagController extends AdminController
{
    protected $module = 'tags';

    protected $moduleName = 'Thẻ';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(TagRepository $TagRepository)
    {
        $this->repository = $TagRepository;

        $this->init();
        
    }

    
    public function createTags(Request $request)
    {
        extract($this->apiDefaultData);
        if(strlen($request->tags)){
            if($list = $this->repository->createTags($request->tags)){
                $status = true;
                $data = $list;
            }
        }
        return $this->json(compact(...$this->apiSystemVars));
    }

    public function updateTag(Request $request)
    {
        extract($this->apiDefaultData);
        if(strlen($request->tag) && $tag = $this->repository->updateTag($request->id, $request->tag)){
            $status = true;
            $data = $tag;
        }else{
            $message = "Lỗi không xác định";
        }
        return $this->json(compact(...$this->apiSystemVars));
    }
    public function getTag(Request $request)
    {
        extract($this->apiDefaultData);
        if($request->id && $t = $this->find($request->id)){
            $status = true;
            $tag = $t;
        }
        return $this->json(compact(...$this->apiSystemVars));
        
    }

    public function getData(Request $request)
    {
        return $this->getAjaxData($request);
    }

}
