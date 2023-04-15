<?php

namespace App\Http\Controllers\Clients;

use App\Http\Controllers\Clients\ClientController;

use Illuminate\Http\Request;
use Crazy\Helpers\Arr;

use App\Repositories\Users\UserRepository;

class CheckAuthController extends ClientController
{
    protected $module = 'auth';

    protected $moduleName = 'check auth';

    protected $flashMode = true;

    /**
     * repository chinh
     *
     * @var UserRepository
     */
    public $repository;
    
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(UserRepository $repository)
    {
        $this->repository = $repository;
        $this->init();
    }

    public function check(Request $request)
    {
        extract($this->apiDefaultData);
        if($user = get_login_user()){
            $status = true;
            $links = [
                'account' =>  [
                    'link' => route('client.account'),
                    'text' => 'Tài khoản'
                ]
            ];
            if($user->inGroup('mod') || $user->inGroup('admin') || $user->id == get_owner_id()){
                $links['admin'] = [
                    'link' => route('admin.dashboard'),
                    'text' => 'Trang quản trị'
                ];
            }
            if(get_web_type() == 'ecommerce'){
                $links['orders'] = [
                    'link' => route('client.orders.manager'),
                    'text' => 'Quản lý đơn hàng'
                ];
            }
            $links['logout'] = [
                'link' => route('client.account.logout'),
                'text' => 'Đăng xuất'
            ];
            $name = $user->name;
            if(strlen($name) > 12){
                $ns = explode(' ', trim($name));
                $name = array_pop($ns);
            }
            if(strlen($name) > 12){
                $name = "Tài khoản";
            }
            
            $data = [
                'name' => $name,
                'avatar' => $user->getAvatar(),
                'links' => $links
            ];
        }else{
            $links = [];
            if(get_web_type() == 'ecommerce'){
                $links['orders'] = [
                    'link' => route('client.orders.manager'),
                    'text' => 'Quản lý đơn hàng'
                ];
            }
            $links['login'] = [
                'link' => route('client.account.login'),
                'text' => 'Đăng nhập'
            ];
            $links['register'] = [
                'link' => route('client.account.register'),
                'text' => 'Đăng ký'
            ];
            $data = [
                'links' => $links
            ];
        }

        return $this->json(compact($this->apiSystemVars));
    }
}
