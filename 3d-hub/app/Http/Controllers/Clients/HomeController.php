<?php

namespace App\Http\Controllers\Clients;

use App\Engines\CacheEngine;
use Illuminate\Http\Request;

use App\Repositories\Users\UserRepository;
use Mobile_Detect;

class HomeController extends ClientController
{
    protected $module = 'home';

    protected $moduleName = 'Trang chủ';
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    public function __construct(UserRepository $UserRepository)
    {
        $this->userRepository = $UserRepository;
        $this->init();
    }

    public function home(Request $request)
    {
        return $this->userRepository->join('profiles', 'profiles.profile_id', '=', 'users.id')->first(['id' => get_owner_id()]);
    }

    public function index(Request $request)
    {
        return $this->cacheViewModule($request, 'index');
    }

    public function getCSRFToken(Request $request)
    {
        extract($this->apiDefaultData);
        if ($token = csrf_token()) {
            $status = true;
            $data = compact('token');
        }
        return $this->json(compact($this->apiSystemVars));
    }
}
