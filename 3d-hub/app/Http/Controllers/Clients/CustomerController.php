<?php

namespace App\Http\Controllers\Clients;

use App\Http\Controllers\Clients\ClientController;

use Illuminate\Http\Request;
use Crazy\Helpers\Arr;

use App\Repositories\Customers\CustomerRepository;
use App\Repositories\Emails\EmailTokenRepository;
use Crazy\Mailer\Email;

use Illuminate\Support\Facades\Auth;

class CustomerController extends ClientController
{
    protected $module = 'customers';

    protected $moduleName = 'Khách hàng';

    protected $flashMode = true;
    
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(CustomerRepository $repository, EmailTokenRepository $emailTokenRepository)
    {
        $this->repository = $repository;
        $this->emailTokenRepository = $emailTokenRepository;
        $this->init();
        $this->setting = setting();
        $this->siteinfo = siteinfo();
    }

    /**
     * hiển thị trang login
     *
     * @return View
     */
    public function login()
    {
        $this->breadcrumb->add('Đăng nhập với tư cách là khách hàng');
        return $this->viewModule('login');
    }

    
    
    /**
     * kiểm tra thông tin khách hàng nếu đúng thì gửi mail kèm quyền truy cập
     *
     * @param Request $request
     * @return void
     */
    public function createToken(Request $request)
    {
        // kiểm tra thôi giống validate nhưng có 1 câu lệnh nên ko cần thiết tạo valuidate
        if(!$request->contact || !($customer = $this->repository->getCustomerByContactInfo($request->contact))){
            return redirect()->back()->withErrors(['contact' => 'Thông tin khách hàng không đúng']);
        }
        
        // thông tin gửi mail
        $mailFrom = $this->siteinfo->email('no-reply@' . get_non_www_domain());
        $company = $this->siteinfo->company($this->siteinfo->site_name('Crazy Support'));
        // tạo token
        $emailToken = $this->emailTokenRepository->createToken($customer->email, 'verify', 'customer', $customer->id);
        $data = [
            'url' => route('client.customers.verify', [
                'token' => $emailToken->token
            ]),
            'code' => $emailToken->code,
            'customer' => $customer
        ];
        Email::from($mailFrom, $company)
            ->to($customer->email, $customer->name)
            ->subject($company.": Xác minh đăng nhập với tư cách là khách hàng")
            ->body('mails.customer-login-verify')
            ->data($data)
            ->sendAfter(1);

        return redirect()->route('client.alert')->with([
            'type' => 'success',
            'message' => 'Chúng tôi sẽ gửi cho bạn một email xác minh truy cập trong giây lát. Bạn vui lòng kiểm tra hộp thư đến để nhận link truy cập!'
        ]);
    }


    /**
     * xác minh email
     *
     * @param Request $request
     * @param string $token
     * @return void
     */
    public function verify(Request $request, $token = null)
    {
        if(!$token) $token = $request->token;
        
        if (!($emailToken = $this->emailTokenRepository->checkRoken($token, 'verify')) || $emailToken->ref !='customer' || !$emailToken->ref_id || !($customer = $this->repository->findBy('id', $emailToken->ref_id))) {
            return redirect()->route('client.alert')->with([
                'type' => 'warning',
                'message' => 'Token không hợp lệ',
                'link' => route('client.customers.login'),
                'text' => 'Đăng nhập lại'
            ]);
        }
        session(['customer_id' => $customer->id]);
        return redirect()->route('client.orders.manager');
    }

    public function logout(Request $request)
    {
        if($request->user()){
            Auth::logout();
        }
        
        $request->session()->forget('order_id');
        
        $request->session()->forget('customer_id');
        
        return redirect('/');
    }
}
