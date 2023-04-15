<?php

namespace App\Http\Controllers\Clients;

use App\Http\Controllers\Clients\ClientController;

use Illuminate\Http\Request;
use Crazy\Helpers\Arr;

use App\Repositories\Files\FileRepository;
use Crazy\Files\Image;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Response;

class AssetController extends ClientController
{
    protected $module = 'assets';

    protected $moduleName = 'Tài nguyên';

    protected $flashMode = true;

    /**
     * repository chinh
     *
     * @var FileRepository
     */
    public $repository;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(FileRepository $repository)
    {
        $this->repository = $repository;
        $this->init();
    }

    public function getImage(Request $request, $ref = 'files', $width = null, $height = null, $filename = null)
    {
        $path = public_path('static/' . $ref . '/' . $filename);
        if (!file_exists($path)) {
            abort(404);
        }

        $image = new Image($path);
        if (!$image->check()) {
            abort(404);
        }
        $type = $image->getMime();
        $image->resizeAndCrop($width ? $width : 300, $height ? $height : 300);
        
        header("Content-Type: ". $type);
        $image->show();
        die;
    }
}
