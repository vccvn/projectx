<?php

namespace App\Http\Controllers\Admin\Ecommerce;

use Illuminate\Http\Request;
use App\Http\Controllers\Admin\AdminController;

use App\Repositories\Customers\CustomerRepository;
use App\Repositories\Users\UserRepository;
use Crazy\Helpers\Arr;

class CustomerController extends AdminController
{
    protected $module = 'customers';

    protected $moduleName = 'Tài khoản khách hàng';

    protected $flashMode = true;

    /**
     * user repository
     *
     * @var UserRepository
     */
    protected $userRepository;

    /**
     * Create a new controller instance.
     *
     * @param CustomerRepository $customerRepository
     * @param UserRepository $userRepository
     * 
     * @return void
     */
    public function __construct(CustomerRepository $customerRepository, UserRepository $userRepository)
    {
        $this->repository = $customerRepository;
        $this->userRepository = $userRepository->staffQuery();
        $this->init();
    }

    /**
     * liên kết với user
     *
     * @param Request $request
     * @param Arr $data
     * @return void
     */
    public function beforeCreate(Request $request, Arr $data)
    {
        // nếu tìm thấy 1 user với email hiện có
        if($user = $this->userRepository->findBy('email', $data->email)){
            if(!$this->repository->findBy('user_id', $user->id)){
                $data->user_id = $user->id;
            }
        }
    }
    

    /**
     * tim kiếm thông tin sản phẩm
     * @param Request $request
     * @return json
     */
    public function getSelectOptions(Request $request)
    {
        extract($this->apiDefaultData);

        if($options = $this->repository->getSelectOptions($request, ['@limit'=>10])){
            $data = $options;
            $status = true;
        }else{
            $message = 'Không có kết quả phù hợp';
        }

        return $this->json(compact(...$this->apiSystemVars));
    }
}
