<?php

namespace App\Http\Controllers\Clients;

use Illuminate\Http\Request;
use Crazy\Helpers\Arr;
use App\Repositories\Comments\CommentRepository;

class CommentController extends ClientController
{
    protected $module = 'comments';

    protected $moduleName = 'Bình luận';

    protected $flashMode = true;
    
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(CommentRepository $CommentRepository)
    {
        $this->repository = $CommentRepository;
        $this->init();
    }
    

    /**
     * xử lý ajax request trước khi lưu
     *
     * @param Request $request
     * @param Arr $data
     * @return void
     */
    public function beforeAjaxSave(Request $request, Arr $data)
    {
        $this->parseData($request, $data);
    }

    /**
     * them adta tuoc khi luu
     *
     * @param Request $request
     * @param Arr $data
     * @return void
     */
    public function beforeSave(Request $request, Arr $data)
    {
        $this->parseData($request, $data);
    }

    public function parseData(Request $request, Arr $data)
    {
        # code...
        if($user = $request->user()){
            $data->author_id = $user->id;
        }
        $approve = 1;
        if(in_array($data->ref, ['post', 'page'])){
            $approve = post_setting()->comment_approve_request;
        }elseif ($data->ref = 'project') {
            $approve = project_setting()->comment_approve_request;
        }
        if(!$approve){
            $data->approved = 1;
            $data->approved_id = get_owner_id();
        }
        // $data->message = htmlentities($data->message);
    }
}
