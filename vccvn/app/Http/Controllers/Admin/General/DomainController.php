<?php

namespace App\Http\Controllers\Admin\General;

use App\Http\Controllers\Admin\AdminController;

use Illuminate\Http\Request;
use Crazy\Helpers\Arr;

use App\Repositories\Users\UserRepository;
use App\Repositories\Web\SettingRepository;
use Crazy\Apis\Api;

class DomainController extends AdminController
{
    protected $module = 'domains';

    protected $moduleName = 'Tên miền';

    // protected $flashMode = true;

    /**
     * repository chinh
     *
     * @var SettingRepository
     */
    public $repository;
    
    /**
     * api
     *
     * @var Api
     */
    protected $api;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(SettingRepository $repository, Api $api)
    {
        $this->repository = $repository;
        $this->init();
        $this->submitUrl = route($this->routeNamePrefix.'settings.domains.save');
        $this->api = $api;
    }

    public function getDomainForm(Request $request)
    {
        $data = $this->repository->first();
        // if($errors = $request->session()->get('errors')) dd($errors);
        return $this->getForm($request, ['type'=>'free'], $data);
    }


    public function beforeGetForm($request, $config, $inputs, $data, $attrs)
    {
        $inputs->remove('web_type');
    }

    public function done(Request $request, Arr $data)
    {
        if($setting = $this->repository->first(['owner_id' => get_owner_id()])){
            $s = $this->repository->update($setting->id, $data->all());
            if($data->ssl && !$setting->ssl){
                $domains = $s->subdomain.'.'.$s->base_domain;
                if($s->domain) $domains.=' '.$s->domain;
                if($s->alias_domain) $domains.=' '.$s->alias_domain;
                $this->api->setOutput('html');
                $rs = $this->api->get(env('HOSTING_MANAGER_API') . '/certbot?password='.env('NODE_SERVER_PASSWORD').'&domains='. $domains);
                
                if($rs != '1') return redirect()->back()->withErrors(['ssl.enable' => 'Không thể kích hoạt SSL'])->withInput($data->all());
            }
            
            if(is_subdomain()){
                if($setting->subdomain != $s->subdomain || $setting->base_domain != $s->base_domain){
                    return $this->view('pending.redirect', [
                        'url' => 'http://'.$s->subdomain.'.'.$s->base_domain,
                        'time' => 3
                    ]);
                }
            }elseif ($setting->domain != $s->domain && get_non_www_domain() == $setting->domain) {
                return $this->view('pending.redirect', [
                    'url' => 'http'.($s->ssl?'s':'').'://'.$s->domain,
                    'time' => 3
                ]);
            }
            elseif ($setting->alias_domain != $s->alias_domain && get_non_www_domain() == $setting->alias_domain) {
                return $this->view('pending.redirect', [
                    'url' => 'http'.($s->ssl?'s':'').'://'.$s->alias_domain,
                    'time' => 3
                ]);
            }
        }
    }

}
