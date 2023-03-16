<?php

namespace App\Http\Controllers\CPanel;


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
     * api
     *
     * @var Api
     */
    protected $api;

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
    public function __construct(SettingRepository $repository, Api $api)
    {
        $this->repository = $repository;
        $this->init();
        $this->submitUrl = route('domain.save');
        $this->api = $api->setOutput('html', true);
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
        $data->alias_comment = $data->alias_domain || $data->domain ? '' : '#';
        $data->domain = $data->domain ? $data->domain : '';
        $data->alias_domain = $data->alias_domain ? $data->alias_domain : '';


        if (!($user = $request->user()) || !($setting = $this->repository->first(['owner_id' => $user->id])) || !($updateData = $this->repository->update($setting->id,$data->all())) || !($s = $user->secret_key) || !($filemanager = new Filemanager())) {
            $this->addRedirectData('error', 'Lỗi không xác định');
        } elseif (!($data->secret = $s)
        || !($conf = str_eval($filemanager->getContent(base_path('webdata/vcc.conf')), $data->all())) || !($oldConf = $filemanager->getContent(base_path('webdata/hosting/' . $s . '.conf')))
        || !($nginx = str_eval($filemanager->getContent(base_path('webdata/nginx.conf')), $data->all())) || !($oldnginx = $filemanager->getContent(base_path('webdata/hosting/' . $s . '.nginx.conf')))) {
            $this->addRedirectData('error', 'Lỗi không xác định');
        } elseif ($conf == $oldConf) {
            // 
        } elseif (!$filemanager->save(base_path('webdata/hosting/' . $s . '.conf'), $conf, 'conf') || !$filemanager->save(base_path('webdata/hosting/' . $s . '.nginx.conf'), $nginx, 'conf')) {
            $this->addRedirectData('error', 'Lỗi không xác định');
        } elseif ($this->api->get(env('HOSTING_MANAGER_API') . '/hosting/update?secret_id=' . $s) != '1') {
            $this->addRedirectData('error', 'Lỗi không xác định');
        }
        if($data->ssl && !$setting->ssl){
            $domains = $updateData->subdomain.'.'.$updateData->base_domain;
            if($updateData->domain) $domains.=','.$updateData->domain;
            if($updateData->alias_domain) $domains.=' '.$updateData->alias_domain;
            $this->api->setOutput('html');
            $rs = $this->api->get(env('HOSTING_MANAGER_API') . '/certbot?domains='.$domains);
            
            if($rs != '1') $this->addRedirectData('error', 'Không thể kích hoạt SSL');
        }
        
    }
}
