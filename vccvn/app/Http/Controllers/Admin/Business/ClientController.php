<?php

namespace App\Http\Controllers\Admin\Business;

use Illuminate\Http\Request;
use App\Http\Controllers\Admin\AdminController;
use Crazy\Helpers\Arr;

use App\Repositories\Clients\ClientRepository;

class ClientController extends AdminController
{
    protected $module = 'clients';

    protected $moduleName = 'Khách hàng';

    protected $flashMode = true;
    
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(ClientRepository $ClientRepository)
    {
        $this->repository = $ClientRepository;
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
        $this->uploadImageAttachFile($request, $data, 'avatar', 'static'. DIRECTORY_SEPARATOR . 'users' . DIRECTORY_SEPARATOR . get_owner()->secret_id . DIRECTORY_SEPARATOR . 'clients');
    }

    
    /**
     * tim kiếm thông tin sản phẩm
     * @param Request $request
     * @return json
     */
    public function getSelectOptions(Request $request)
    {
        extract($this->apiDefaultData);

        if($options = $this->repository->getRequestDataOptions($request, ['@limit'=>10])){
            $data = $options;
            $status = true;
        }else{
            $message = 'Không có kết quả phù hợp';
        }

        return $this->json(compact(...$this->apiSystemVars));
    }
}
