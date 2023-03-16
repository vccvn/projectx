<?php

namespace App\Http\Controllers\Clients;

use App\Http\Controllers\Clients\ClientController;

use Illuminate\Http\Request;
use Crazy\Helpers\Arr;

use App\Repositories\Users\UserRepository;

class VisitorController extends ClientController
{
    protected $module = 'visitors';

    protected $moduleName = 'Visitor';

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

    public function checkVisitor(Request $request)
    {
        $visitData = $request->session()->get('visit_data');
        if(!$visitData) $visitData = [
            'first_visit' => time(),
            'today' => 0,
            'total' => 0
        ];
        $cookie = $request->cookie('visit_data');
        if($cookie && $a = json_decode($cookie, true)) $cookie = $a;
        if(!$cookie) $cookie = [
            'first_visit' => time(),
            'today' => 0,
            'total' => 0
        ];

        $visitData['today']++;
        $visitData['total']++;
        $cookie['today']++;
        $cookie['total']++;
        session(['visit_data' => $visitData]);
        return $this->json([
            'status' => true,
            'data' => [
                'visitor' => [
                    'cookie' => $cookie,
                    'session' => $visitData
                ] 
            ]
        ])->withCookie(cookie('visit_data', json_encode($cookie), 365*24*60));
    }

}
