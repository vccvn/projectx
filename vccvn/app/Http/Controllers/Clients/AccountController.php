<?php

namespace App\Http\Controllers\Clients;

use App\Http\Controllers\Clients\ClientController;
use App\Repositories\Customers\CustomerRepository;
use App\Repositories\Users\UserRepository;
use App\Repositories\Emails\EmailTokenRepository;

use Illuminate\Http\Request;
use Crazy\Helpers\Arr;
use Crazy\Html\Form;
use Crazy\Mailer\Email;


use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AccountController extends ClientController
{
    protected $module = 'account';

    protected $moduleName = 'Tài khoản';

    protected $flashMode = true;

    protected $setting;
    protected $siteinfo;

    /**
     * repository chinh
     *
     * @var UserRepository
     */
    public $repository;
    
    /**
     * customer
     *
     * @var \App\Repositories\Customers\CustomerRepository $customerRepository
     */
    protected $customerRepository = null;
    
    /**
     * Undocumented variable
     *
     * @var EmailTokenRepository
     */
    protected $emailTokens = null;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(UserRepository $repository, CustomerRepository $customerRepository,  EmailTokenRepository $EmailTokenRepository)
    {
        $this->repository = $repository;
        $this->repository->staffQuery();
        $this->customerRepository = $customerRepository;
        $this->emailTokens = $EmailTokenRepository;
        $this->init();
        $this->setting = system_setting();
        $this->siteinfo = siteinfo();
    }

    /**
     * hiển thĩ form cập nhât
     *
     * @param Request $request
     * @return View
     */
    public function index(Request $request)
    {
        $settings = get_account_setting_configs();
        $user = $request->user();
        $webType = get_web_type();
        $false = (
            // nếu t ab không hợp lệ
            !($tab = $this->getTabKey($request->tab)) || 
            // nếu web không phải là thương mại điện tử thì xóa tab customer và so sánh tap có bàng ecommerce hay không
            // $settings->remove('customer') không ảnh hưởng dến diều kiện biểu thức vì nó luôn trả về giá trị
            ($webType != 'ecommerce' && $settings->remove('customer') && $tab == 'customer') || 
            // tệ nhất là không lấy dược form từ setting
            !($formConfig = $settings->get($tab))
        );
        if($false){
            return $this->view('errors.404');
        }
        // lấy data phù hợp với tab

        $data = ($tab == 'customer') ? (
            ($customer = $this->customerRepository->findBy('user_id', $user->id)) ? $customer->toFormData() : []
        ): $user->toFormData();

        $form = new Form([
            'inputs' => $formConfig->inputs,
            'data' => $data,
            'errors' => $request->session()->get('errors')
        ]);
        $form->map('setTemplatePath', 'client-libs.form');

        
        $account = new Arr(compact('settings', 'formConfig', 'form', 'data', 'tab'));
        
        $this->breadcrumb->add("Tài khoản", route('client.account'))
                         ->add($formConfig->title, route('client.account.settings',['tab' => $tab]));
        
        return $this->viewModule('index', compact('account'));
    }

    /**
     * cập nhật thông tin tài khoản
     *
     * @param Request $request
     * @param string $tab
     * @return void
     */
    public function updateAccount(Request $request, $tab = null)
    {
        $redirect = redirect()->back();
        if(!($tab = $this->getTabKey($tab?$tab:$request->tab))) {
            $redirect->with('error', 'Lỗi không xác định');
        }
        elseif(!($validator = ($tab == 'customer'?$this->customerRepository:$this->repository)->validator($request, "Account\\".ucfirst($tab)."Validator")) || !$validator->success()){
            $redirect->withInput($request->all())->withErrors($validator->errors());
        }else{
            $data = $validator->inputs();
            $user = $request->user();
            if($tab == 'customer'){
                $customer_id = 0;
                if($customer = $this->customerRepository->getCustomerByUser($user)){
                    $customer_id = $customer->id;
                }
                $data['user_id'] = $user->id;
                $this->customerRepository->save($data, $customer_id);
            }else{
                $this->repository->update($user->id, $data);
            }
            $this->repository->update($request->user()->id, $validator->inputs());
            $redirect->with('message', 'Cập nhật thông tin thành công!');
        }
        return $redirect;

    }

    public function getTabKey($key)
    {
        $tabs = get_account_setting_tabs();
        $key = strtolower($key);

        if(!$key){
            $key = $tabs->first();
        }
        elseif($k = $tabs->get($key)){
            $key = $k;
        }
        elseif(!$tabs->in($key)){
            $key = null;
        }
        return $key;
    }

}
