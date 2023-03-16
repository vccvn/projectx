<?php

namespace App\Http\Controllers\Admin\Ecommerce;

use App\Http\Controllers\Admin\AdminController;

use Illuminate\Http\Request;
use Crazy\Helpers\Arr;

use App\Repositories\Affiliates\AffiliateRepository;

class AffiliateController extends AdminController
{
    protected $module = 'affiliates';

    protected $moduleName = 'Affiliate';

    protected $flashMode = true;

    /**
     * repository chinh
     *
     * @var AffiliateRepository
     */
    public $repository;
    
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(AffiliateRepository $repository)
    {
        $this->repository = $repository;
        $this->init();
    }

    /**
     * can thiệp trước khi luu
     * @param Illuminate\Http\Request $request
     * @param Arr $data dũ liệu đã được validate
     * @return void
     */
    protected function beforeSave(Request $request, $data)
    {
        $data->slug = $this->repository->getSlug(
            $request->slug ?? $request->name,
            $request->id
        );
        $this->uploadImageAttachFile($request, $data, 'logo', 'static'. DIRECTORY_SEPARATOR . 'users' . DIRECTORY_SEPARATOR . get_owner()->secret_id . DIRECTORY_SEPARATOR . 'affiliates');
    }
}
