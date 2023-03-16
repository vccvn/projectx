<?php

namespace App\Http\Controllers\Wordpress;


use Illuminate\Http\Request;
use Crazy\Helpers\Arr;

use App\Repositories\Users\UserRepository;
use App\Repositories\Web\SettingRepository;
use Crazy\Apis\Api;
use Crazy\Files\Filemanager;

class DomainController extends ManagerController
{
    protected $module = 'domain';

    protected $moduleName = 'Tên miền';

    // protected $flashMode = true;

    /**
     * repository chinh
     *
     * @var SettingRepository
     */
    public $repository;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(SettingRepository $repository)
    {
        $this->repository = $repository;
        $this->init();
        $this->submitUrl = route('domain.save');
    }


    public function index(Request $request)
    {
        $user = $request->user();
        $webSetting = $user->userWebSetting;
        return $this->viewModule('index', compact('user', 'webSetting'));
    }

    public function getDomainForm(Request $request)
    {
        $data = $this->repository->first();
        return $this->getForm($request, ['type' => 'free'], $data);
    }


    public function beforeGetForm($request, $config, $inputs, $data, $attrs)
    {
        $inputs->remove('web_type');
    }

    public function done(Request $request, Arr $data)
    {   
        $data->alias_comment = $data->alias_domain ? '' : '#';
        $data->alias_domain = $data->alias_domain ? $data->alias_domain : '';

        if (!($user = $request->user()) || !($setting = $this->repository->first(['owner_id' => $user->id])) || !($s = $this->repository->update($setting->id,$data->all())) || !($s1 = $user->secret_id)) {
            $this->addRedirectData('error', 'Lỗi không xác định');
            return;
        }
        if($data->ssl && !$setting->ssl){
            $domains = $s->subdomain.'.'.$s->base_domain;
            if($s->domain) $domains.=','.$s->domain;
            if($s->alias_domain) $domains.=' '.$s->alias_domain;
            $this->api->setOutput('html');
            $rs = $this->api->get(env('HOSTING_MANAGER_API') . '/certbot?domains='.$domains);
            
            if($rs != '1') $this->addRedirectData('error', 'Không thể kích hoạt SSL');
        }
        

    }
    
}
