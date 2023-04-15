<?php

namespace App\Http\Controllers\Clients;

use App\Http\Controllers\Clients\ClientController;

use Illuminate\Http\Request;
use Crazy\Helpers\Arr;

use App\Repositories\Themes\ThemeRepository;

class ThemeController extends ClientController
{
    protected $module = 'themes';

    protected $moduleName = 'Theme';

    protected $flashMode = true;

    /**
     * repository chinh
     *
     * @var ThemeRepository
     */
    public $repository;
    
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(ThemeRepository $repository)
    {
        $this->repository = $repository;
        $this->init();

        $this->repository->activeSearchMode();
    }

    /**
     * xem trước giao diện
     *
     * @param Request $request
     * @return void
     */
    public function preview(Request $request)
    {
        if($request->id && $this->repository->checkThemeActiveList($request->id) && $theme = $this->repository->findBy('id', $request->id)){
            session([
                'theme_id' => $theme->id
            ]);
            return redirect()->route('home');
        }
        return redirect()->route('client.alert')->with([
            'type' => 'warning',
            'message' => 'Thêm không tồn tại!'
        ]);
    }

    public function reset(Request $request)
    {
        $request->session()->forget('theme_id');
        return redirect()->route('home');
    }

}
