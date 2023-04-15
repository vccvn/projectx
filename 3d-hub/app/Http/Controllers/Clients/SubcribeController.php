<?php

namespace App\Http\Controllers\Clients;

use App\Http\Controllers\Clients\ClientController;

use Illuminate\Http\Request;
use Crazy\Helpers\Arr;

use App\Repositories\Subcribes\SubcribeRepository;

class SubcribeController extends ClientController
{
    protected $module = 'subcribes';

    protected $moduleName = 'Subcribe';

    protected $flashMode = true;

    /**
     * repository chinh
     *
     * @var SubcribeRepository
     */
    public $repository;
    
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(SubcribeRepository $repository)
    {
        $this->repository = $repository;
        $this->init();
    }

    public function afterSave(Request $request, $result)
    {
        $this->redirectRoute = 'client.alert';
        $this->addRedirectData([
            'type' => 'success',
            'message' => 'Đăng ký theo dõi thành công!'
        ]);
    }

    public function onError(Request $request, $errors = null)
    {
        $error = (is_array($errors) && count($errors))? array_shift($errors) : "Lỗi không xác định";
        return redirect()->back()->with('popup_error', $error);
    }

}
