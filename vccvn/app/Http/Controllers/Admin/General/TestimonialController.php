<?php

namespace App\Http\Controllers\Admin\General;

use App\Http\Controllers\Admin\AdminController;

use Illuminate\Http\Request;
use Crazy\Helpers\Arr;

use App\Repositories\Testimonials\TestimonialRepository;

class TestimonialController extends AdminController
{
    protected $module = 'testimonials';

    protected $moduleName = 'Testimonial';

    protected $flashMode = true;

    /**
     * repository chinh
     *
     * @var TestimonialRepository
     */
    public $repository;
    
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(TestimonialRepository $repository)
    {
        $this->repository = $repository;
        $this->init();
        admin_breadcrumbs([
            [
                'url' => $this->getModuleRoute('create'),
                'text' => 'Thêm mới'
            ]
        ]);
    }

    /**
     * can thiệp trước khi luu
     * @param Illuminate\Http\Request $request
     * @param Arr $data dũ liệu đã được validate
     * @return void
     */
    protected function beforeSave(Request $request, $data)
    {
        $this->uploadImageAttachFile($request, $data, 'avatar', get_content_path('testimonials'));
    }

}
