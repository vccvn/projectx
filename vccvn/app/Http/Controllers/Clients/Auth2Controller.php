<?php

namespace App\Http\Controllers\Clients;

use App\Http\Controllers\Clients\ClientController;
use App\Repositories\Emails\EmailTokenRepository;
use App\Repositories\Users\UserRepository;
use Crazy\Helpers\Arr;
use Crazy\Mailer\Email;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class Auth2Controller extends ClientController
{
    protected $module = 'auth';

    protected $moduleName = 'auth';

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
    public function __construct(UserRepository $UserRepository, EmailTokenRepository $EmailTokenRepository)
    {
        $this->middleware('guest')->except('logout');
        $this->repository = $UserRepository;
        $this->repository->staffQuery();
        $this->emailTokens = $EmailTokenRepository;
        $this->init();
        $this->setting = system_setting();
        $this->siteinfo = siteinfo();
    }


    /**
     * hiển thị form đăng ký tài khoản
     *
     * @param Request $request
     * @return View
     */
    public function getRegisterForm(Request $request)
    {
        $page_title = "Đăng ký tài khoản";
        $this->breadcrumb->add($page_title);
        $data = [
            'page_title' => $page_title
        ];
        return $this->viewModule('register', $data);
    }


    /**
     * Xử lý form đăng ký
     * @param Request
     * @return \Illuminate\Support\Facades\Redirect
     */
    public function postRegister(Request $request)
    {
        $validator = $this->repository->validator($request, 'Auth\Register');
        $errors = [];
        if (!$validator->success()) {
            $message = "Hình như có gì đó chưa đúng lắm! Hãy kiểm tra lại thông tin!";
            $errors = $validator->errors();
        } else {
            $data = $validator->inputs();
            $data['owner_id'] = $this->repository->getOwnerID();
            $data['status'] = 0;
            if (!($user = $this->repository->create($data))) {
                $message = "Lỗi không xác định";
            } else {
                return $this->sendVerifyEmailByUser($user, 'Xin chúc mừng bạn đã đăng ký thành công!');
            }
        }
        return redirect()->route('client.auth.register')->withInput($request->all())->withErrors($errors)->with('error', $message);
    }

    /**
     * xử lý gửi email xác minh
     *
     * @param Request $request
     * @return \Illuminate\Support\Facades\Redirect
     */
    public function SendVerifyEmail(Request $request)
    {
        $validator = $this->repository->validator($request, 'Auth\Verify');
        if ($validator->success()) {
            return $this->sendVerifyEmailByUser(
                $this->repository->findBy('email', $request->email),
                'Đã gửi Email Xác minh thành công'
            );
        }
        return redirect()->route('client.auth.forgot')->withInput($request->all())->with('error', "Email không hợp lệ");
    }

    /**
     * gửi email xác thực từ thông tin người dùng
     *
     * @param \App\Models\User|\App\Masks\Users\UserMask $user
     * @param string $message
     * @return \Illuminate\Support\Facades\Redirect
     */
    protected function sendVerifyEmailByUser($user, $message = null)
    {
        if ($emailToken = $this->emailTokens->createToken($user->email, 'verify', 'account')) {
            $data = [
                'url' => route('client.auth.verify-email', [
                    'token' => $emailToken->token
                ]),
                'code' => $emailToken->code,
                'email' => $user->email,
                'user' => $user
            ];

            Email::from($this->siteinfo->email('no-reply@' . get_non_www_domain()), $this->siteinfo->site_name('Crazy Support'))
                ->to($user->email, $user->name)
                ->subject("Xác minh email")
                ->body('mails.verify-email')
                ->data($data)
                ->sendAfter(1);
        }
        return redirect()->route('client.alert')->with([
            'type' => 'success',
            'message' => ($message ? $message . ' ' : '') . 'Vui lòng truy cập hộp thư đến để xác minh email'
        ]);
    }

    /**
     * hiển thị form gửi mail xác minh
     *
     * @return void
     */
    public function getVerifiForm()
    {
        $page_title = "Xác minh tài khoản";
        $this->breadcrumb->add($page_title);
        $data = [
            'page_title' => $page_title
        ];
        return $this->viewModule('verify', $data);
    }

    /**
     * xác thực email bằng token
     *
     * @param Request $request
     * @param string $token
     * @return \Illuminate\Support\Facades\Redirect
     */
    public function verifyEmail(Request $request, $token = null)
    {
        if (!$token) $token = $request->token;
        if (!($emailToken = $this->emailTokens->checkRoken($token, 'verify')) || !($user = $this->repository->findBy('email', $emailToken->email))) {
            return redirect()->route('client.alert')->with([
                'type' => 'warning',
                'message' => 'Token không hợp lệ'
            ]);
        }
        $this->repository->update($user->id, [
            'status' => 1
        ]);
        return redirect()->route('client.alert')->with([
            'type' => 'success',
            'message' => 'Chúc mừng bạn đã xác minh tài khoản thành công! Vui lòng đăng nhập để tiếp tục!',
            'link' => route('client.auth.login'),
            'text' => 'Đăng nhập'
        ]);
    }


    /**
     * hiển thị form đăng nhập
     *
     * @return View
     */
    public function getLoginForm()
    {
        $page_title = "Đăng nhập";
        $this->breadcrumb->add($page_title);
        $data = [
            'page_title' => $page_title
        ];
        return $this->viewModule('login', $data);
    }


    /**
     * đăng nhập
     * @param Request
     * @return \Illuminate\Support\Facades\Redirect
     */
    public function postLogin(Request $request)
    {
        $validator = $this->repository->validator($request, 'Auth\Login');
        $owner_id = $this->repository->getOwnerID();
        // nhap sai hoặc thiếu thông tin
        if (!$validator->success()) {
            $message = "Đăng nhập không thành công!!";
        }
        // không tìm thấy user
        elseif (!($user = $this->repository->resetDefaultParams()->findLogin($request->username))){
            $message = "Đăng nhập không thành công!";
        } 
        // user không thuộc quyền quản lý của web
        elseif (!in_array($owner_id, [$user->id, $user->owner_id])) {
            $message = "Tài khoản không hợp lệ";
        } 
        // sai mật khẩu
        elseif (!Hash::check($request->password, $user->password)) {
            $message = "Sai tài khoản hoặc mật khẩu";
        } 
        // chưa kích hoạt
        elseif ($user->status == 0) {
            return redirect()->route('client.alert')->with([
                'type' => 'warning',
                'message' => 'Tài khoản này chưa được kích hoạt! Vui lòng khích hoạt tài khoản để tiếp tục!',
                'link' => route('client.auth.verify.form'),
                'text' => 'Gửi yêu cầu kích hoạt tài khoản'
            ]);
        } 
        // bị xóa hoạc vô hiệu hóa
        elseif ($user->deleted || $user->status < 0) {
            return redirect()->route('client.alert')->with([
                'type' => 'danger',
                'message' => 'Tài khoản này dax49 bị vô hiệu hóa!'
            ]);
        }
        // nếu đăng nhập sai. trường hợp này còn lâu mới xảy ra =))))
        elseif (!Auth::attempt(['id' => $user->id, 'email' => $user->email, 'password' => $request->password], $request->remember)) {
            $message = "Đăng nhập không thành công!";
        } 
        // nếu có yêu cầu chuyển hướng
        elseif ($request->next) return redirect($request->next);
        else return redirect()->intended(route('home'));
        
        return redirect()->route('client.auth.login')->withInput($request->all())->with('error', $message);
    }

    /**
     * Dăng xuất
     * @return \Illuminate\Support\Facades\Redirect
     */

    public function logout()
    {
        Auth::logout();
        return redirect('/');
    }


    /**
     * hiển thị form khi người dùng quen mật khẩu
     *
     * @return View
     */
    public function getForgotForm()
    {
        $page_title = "Quên mật khẩu";
        $this->breadcrumb->add($page_title);
        $data = [
            'page_title' => $page_title
        ];
        return $this->viewModule('forgot');
    }

    /**
     * Gửi mail reset
     * @param Request
     * @return \Illuminate\Support\Facades\Redirect
     */
    public function sendEmailResetPassword(Request $request)
    {
        $validator = $this->repository->validator($request, 'Auth\Email');
        if ($validator->success()) {
            $user = $this->repository->findBy('email', $request->email);
            if ($user &&  $emailToken = $this->emailTokens->createToken($request->email, 'reset-password', 'user', $user->id)) {
                $data = [
                    'url' => route('client.auth.password.confirm-token', [
                        'token' => $emailToken->token
                    ]),
                    'code' => $emailToken->code,
                    'email' => $user->email,
                    'user' => $user
                ];

                Email::from($this->siteinfo->email('no-reply@' . get_non_www_domain()), $this->siteinfo->company('Crazy Support'))
                    ->to($request->email, $user->name)
                    ->subject("Đặt lại mật khẩu trên hệ thống CrazyWeb")
                    ->body('mails.reset-password')
                    ->data($data)
                    ->sendAfter(1);
                //
            }

            return redirect()->route('client.alert')->with([
                'type' => 'success',
                'message' => 'Đã gửi email lấy lại mật khẩu đến hòm thư của bạn. Vui lòng kiểm tra hộp thư đến để đặt lại mật khẩu'
            ]);
        } else {
            $message = "Email không hợp lệ";
        }
        return redirect()->route('client.auth.forgot')->withInput($request->all())->with('error', $message);
    }

    /**
     * get reset password frm
     * @param Request $request
     * @param string $token
     * @return \Illuminate\Support\Facades\Redirect
     */
    public function confirmPasswordToken(Request $request, $token = null)
    {
        if (!$token) $token = $request->token;
        if ($emailToken = $this->emailTokens->checkRoken($token, 'reset-password')) {
            session(['password_token' => $token]);
            return redirect()->route('client.auth.password.reset');
        } else {
            return redirect()->route('client.alert')->with([
                'type' => 'warning',
                'message' => 'Link không hợp lệ',
                'link' => route('client.auth.forgot'),
                'text' => 'Đặt lại mật khẩu'
            ]);
        }
    }

    /**
     * hiển thị form reset password
     *
     * @param Request $request
     * @return View
     */
    public function getResetPasswordForm(Request $request)
    {
        $token = $request->password_token ? $request->password_token : session('password_token');
        if ($emailToken = $this->emailTokens->checkRoken($token)) {
            $page_title = "Đặt lại mật khẩu";
            $this->breadcrumb->add($page_title);
            $data = [
                'page_title' => $page_title,
                'token' => $token
            ];
            return $this->viewModule('reset', $data);
        } else {
            return $this->view('alert.message', [
                'type' => 'warning',
                'message' => 'Link không hợp lệ',
                'link' => route('client.auth.forgot'),
                'text' => 'Đặt lại mật khẩu'
            ]);
        }
    }

    /**
     * đặt lại mật khẩu
     *
     * @param Request $request
     * @return \Illuminate\Support\Facades\Redirect
     */
    public function postResetPassword(Request $request)
    {
        $status = false;
        $errors = [];
        $validator = $this->emailTokens->validator($request, 'Auth\PasswordReset');
        if (!$validator->success() || !($email = $this->emailTokens->findBy('token', $request->token))) {
            $message = "Đã có lỗi xảy ta. Vui lòng thử lại!";
            $errors = $validator->errors();
        } elseif (!($user = $this->repository->resetDefaultParams()->findBy('email', $email->email))) {
            $message = "Hình như có gì đó sai sai! Bạn hãy thử lại trong giây lát";
        } elseif (!($this->repository->update($user->id, ['password' => $request->password]))) {
            $message = "Lỗi không xác định";
        } else {
            $status = true;
            $message = "Đặt lại mật khẩu thành công!";
            $this->emailTokens->delete($email->id);
        }
        return $status ? redirect()->route('client.alert', [
            'type' => 'success',
            'message' => $message,
            'link' => route('client.auth.login'),
            'text' => 'Đăng nhập'
        ]) : redirect()->back()->withErrors($errors)->with('error', $message);
    }
}
