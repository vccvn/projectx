<?php

namespace App\Http\Controllers\Clients;

use App\Http\Controllers\Clients\ClientController;

use Illuminate\Http\Request;
use Crazy\Helpers\Arr;

use App\Repositories\Users\UserRepository;

class PWAController extends ClientController
{
    protected $module = 'pwa';

    protected $moduleName = 'PWA';

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

    public function showManifest(Request $request)
    {
        if($pwa = get_option('settings')->pwa){
            if($pwa->active){
                $data = $pwa->copy([
                    "short_name",
                    "name",
                    "description",
                    "start_url",
                    "scope",
                    "display",
                    "background_color",
                    "theme_color"
                ]);
                $site = str_replace('/__123__', '/', url('/__123__'));

                $data['icons'] = [
                    [
                        "src" => str_replace($site, '/', $pwa->icon_512_svg),
                        "type" => "image/svg+xml",
                        "sizes" => "512x512"
                    ],
                      [
                        "src" => str_replace($site, '/', $pwa->icon_192_png),
                        "type" => "image/png",
                        "sizes" => "192x192"
                      ],
                      [
                        "src" => str_replace($site, '/', $pwa->icon_512_png),
                        "type" => "image/png",
                        "sizes" => "512x512"
                      ]
                ];
                return $this->json($data);
            }
        }
        abort(404);
    }

    public function showSWjs(Request $request)
    {
        return response(file_get_contents(public_path('static/app/js/service-worker.js')))->withHeaders([
            'Content-Type' => 'text/javascript'
        ]);
    }

}
