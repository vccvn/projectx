<?php

namespace App\Http\Controllers\Admin\General;

use App\Http\Controllers\Admin\AdminController;

use Illuminate\Http\Request;
use Crazy\Helpers\Arr;

use App\Repositories\Comments\CommentRepository;

class CommentController extends AdminController
{
    protected $module = 'comments';

    protected $moduleName = 'Comment';

    protected $flashMode = true;

    /**
     * repository chinh
     *
     * @var CommentRepository
     */
    public $repository;
    
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(CommentRepository $repository)
    {
        $this->repository = $repository;
        $this->init();
    }

    
    public function start()
    {
        // $this->activeMenu($this->module.'.list');
        add_js_data('comment_urls', [
            
            'change_approve_url' => $this->getModuleRoute('change-approve')
        
        ]);
    }

    public function changeApprove(Request $request)
    {
        extract($this->apiDefaultData);
        $approved = $request->approved?1:0;
        $d = ['approved' => $approved];
        if($approved) $d['approved_id'] = $request->user()->id;
        // return $d;
        if($request->id && $detail = $this->repository->update($request->id, $d)){
            $data = $detail;
            $status = true;
        }
        else{
            $message = 'Không tìm thấy comment';
        }
        return $this->json(compact(...$this->apiSystemVars));
    }
}
