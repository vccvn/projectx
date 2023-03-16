<?php

namespace App\Http\Controllers\Admin\General;

use Illuminate\Http\Request;
use App\Http\Controllers\Admin\AdminController;
use Crazy\Helpers\Arr;

use App\Repositories\Contacts\ReplyRepository;
use App\Repositories\Contacts\ContactRepository;

class ContactReplyController extends AdminController
{
    protected $module = 'contacts.replaies';

    protected $moduleName = 'Trả lời liên hệ';

    protected $flashMode = true;
    
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(ReplyRepository $ReplyRepository, ContactRepository $contactRepository)
    {
        $this->repository = $ReplyRepository;
        $this->contactRepository = $contactRepository;
        $this->init();
    }

    /**
     * Thêm ID người trả lời
     * 
     * @param Request $request
     * @param Arr $data
     * 
     * @return void
     */
    public function beforeAjaxCreate($request, $data)
    {
        $data->user_id = $request->user()->id;
    }

    /**
     * Gửi email thông báo đã trả lời liên hệ
     * 
     * @param Request $request
     * @param \App\Models\ContactReply $reply
     * 
     * @return void
     */
    public function afterAjaxCreate($request, $reply)
    {
        $this->contactRepository->sendReplyMail($reply->contact_id, $reply->message, $request->user());
    }

    
}
