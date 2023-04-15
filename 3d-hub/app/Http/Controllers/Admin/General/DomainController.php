<?php

namespace App\Http\Controllers\Admin\General;

use App\Http\Controllers\Admin\AdminController;

use Illuminate\Http\Request;
use Crazy\Helpers\Arr;

use App\Repositories\Users\UserRepository;
use App\Repositories\Web\SettingRepository;

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
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(SettingRepository $repository)
    {
        $this->repository = $repository;
        $this->init();
        $this->submitUrl = route($this->routeNamePrefix.'settings.domains.save');
    }

    public function getDomainForm(Request $request)
    {
        $data = $this->repository->first();
        return $this->getForm($request, ['type'=>'free'], $data);
    }

    public function done(Request $request, Arr $data)
    {
        if($setting = $this->repository->first(['owner_id' => get_owner_id()])){
            $s = $this->repository->update($setting->id, $data->all());
            if(is_subdomain()){
                if($setting->subdomain != $s->subdomain || $setting->domain != $s->domain){
                    return $this->view('pending.redirect', [
                        'url' => 'http://'.$s->subdomain.'.'.$s->domain,
                        'time' => 3
                    ]);
                }
            }elseif ($setting->alias_domain != $s->alias_domain) {
                return $this->view('pending.redirect', [
                    'url' => 'http://'.$s->alias_domain,
                    'time' => 3
                ]);
            }
        }
    }

}
