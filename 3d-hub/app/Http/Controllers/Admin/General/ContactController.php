<?php

namespace App\Http\Controllers\Admin\General;

use Illuminate\Http\Request;
use App\Http\Controllers\Admin\AdminController;
use Crazy\Helpers\Arr;

use App\Repositories\Contacts\ContactRepository;

class ContactController extends AdminController
{
    protected $module = 'contacts';

    protected $moduleName = 'Liên hệ';

    protected $flashMode = true;
    
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(ContactRepository $ContactRepository)
    {
        $this->repository = $ContactRepository;
        $this->init();
    }

    public function beforeGetListView(Request $request)
    {
        add_js_data('contact_data', [
            'urls' => [
                'detail' => $this->getModuleRoute('detail'),
                'add_reply' => $this->getModuleRoute('replies.save'),
            ],
        ]);
    }

}
