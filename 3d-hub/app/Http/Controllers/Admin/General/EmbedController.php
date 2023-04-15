<?php

namespace App\Http\Controllers\Admin\General;

use App\Repositories\Html\AreaRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Admin\AdminController;
use Crazy\Helpers\Arr;

use App\Repositories\Html\EmbedRepository;

class EmbedController extends AdminController
{
    protected $module = 'embeds';

    protected $moduleName = 'Mã Nhúng';

    protected $flashMode = true;
    
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(EmbedRepository $EmbedRepository, AreaRepository $areaRepository)
    {
        $this->repository = $EmbedRepository;
        $this->areaRepository = $areaRepository;
        $this->init();
    }

    public function showEmbeds(Request $request)
    {
        $areas = $this->areaRepository->getEmbedAreas();
        $urls = [
            'sort' => $this->getModuleRoute('sort'),
            'save' => $this->getModuleRoute('ajax-save'),
            'delete' => $this->getModuleRoute('delete'),
            'detail' => $this->getModuleRoute('detail'),
            
        ];
        return $this->view('html.embeds.list', compact('areas', 'urls'));
    }

    
    /**
     * xu ly data truoc khi luu
     *
     * @param Request $request
     * @param Arr $data
     * @return void
     */
    public function beforeSave(Request $request, Arr $data)
    {
        $this->processData($request, $data);
    }
    public function beforeAjaxSave(Request $request, Arr $data)
    {
        $this->processData($request, $data);
    }

    
    /**
     * sắp xếp lại vị trí sau khi tạo mới
     *
     * @param Request $request
     * @param App\Models\Slider $result
     * @return void
     */
    public function afterCreate(Request $request, $result)
    {
        $this->repository->updatePriority($result->id, $result->priority);
    }
    public function afterAjaxCreate(Request $request, $result)
    {
        $this->repository->updatePriority($result->id, $result->priority);
    }
    
    /**
     * xư lý dữ liệu người dùng gửi lên
     *
     * @param Request $request
     * @param Arr $data
     * @return void
     */
    public function processData(Request $request, Arr $data)
    {
        $data->slug = str_slug($data->slug?$data->slug:$data->label, '_');
    }

    
    /**
     * sắp xếp slider
     *
     * @param Request $request
     * @return void
     */
    public function sort(Request $request)
    {
        extract($this->apiDefaultData);

        // validate
        $validator = $this->repository->validator($request, 'Html\SortEmbedValidator');
        if(!$validator->success()){
            $message = 'Đã có lỗi xảy ra. Vui lòng kiểm tra lại';
            $errors = $validator->errors();
        }
        elseif(is_array($request->data)){
            $status = true;
            foreach ($request->data as $area) {
                if(isset($area['area_id']) && $area['area_id'] && isset($area['embeds']) && is_array($area['embeds']) && count($area['embeds'])){
                    if(!$this->repository->sortEmbeds($area['area_id'], $area['embeds'])){
                        $status = false;
                        $message = 'Lỗi không xác định. Vui lòng thử lại sau giây láy';
                    }
                }
            }
        
        }
        return $this->json(compact(...$this->apiSystemVars));
    }
}
