<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;

use App\Repositories\Users\UserRepository;
use App\Repositories\Emails\EmailTokenRepository;

use Crazy\Mailer\Email;

use Crazy\Helpers\Arr;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;


class AuthController extends Controller
{
    protected $module = 'auth';

    protected $moduleName = 'Auth';


    /**
     * @var string $viewFolder thu muc chua view
     * khong nen thay doi lam gi
     */
    protected $viewFolder = 'admin';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(UserRepository $UserRepository, EmailTokenRepository $EmailTokenRepository)
    {
        $this->middleware('guest')->except('logout');
        $this->repository = $UserRepository;
        // $this->repository->staffQuery();
        $this->emailTokens = $EmailTokenRepository;
        $this->init();
    }

    public function getLoginForm()
    {
        return $this->viewModule('login', ['auth_page' => 'signin']);
    }


    /**
     * đăng nhập
     * @param Request
     * @return json
     */
    public function postLogin(Request $request)
    {
        extract($this->apiDefaultData);

        $validator = $this->repository->validator($request, 'Auth\Login');
        if (!$validator->success()) {
            $message = "Đăng nhập không thành công!!";
            $errors = $validator->errors();
        } elseif ($user = $this->repository->resetDefaultParams()->findLogin($request->username)) {
            $args = [
                'status' => 1,
                'deleted' => 0,
                'id' => $user->id,
                'email' => $user->email,
                'password' => $request->password
            ];
            if (Auth::attempt($args, $request->remember)) {
                // $userLogin = $this->repository->resetDefaultParams()->find($user->id);
                // $token = null;

                $a = [
                    'email' => $user->email,
                    'password' => $request->password
                ];
                if (!$token = JWTAuth::attempt($a)) {
                    $token = null;
                }
                $data = [
                    'redirect' => route('dashboard'),
                    'jwt' => [
                        'expiresIn' => 36000,
                        'accessToken' => $token,
                        'user' => [
                            'id' => $user->id,
                            'name' => $user->name
                            
                            
                        ]
                    ]
                ];
                $status = true;
            } else {
                $message = "Đăng nhập không thành công";
            }
        } else {
            $message = "Đăng nhập không thành công!";
        }
        return $this->json(compact(...$this->apiSystemVars));
    }

    /**
     * Dăng xuất
     * @return redirect
     */

    public function logout()
    {
        Auth::logout();
        return redirect('/');
    }



    /**
     * đăng nhập
     * @param Request
     * @return json
     */
    public function sendEmailResetPassword(Request $request)
    {
        extract($this->apiDefaultData);
        $code = 201;
        $validator = $this->repository->validator($request, 'Auth\Email');
        if ($validator->success()) {
            $this->repository->resetDefaultParams();
            $owner_id = $this->repository->getOwnerID();
            $user = $this->repository->findBy('email', $request->email);
            if (($user && (!$owner_id || in_array($owner_id, [$user->id, $user->owner_id]))) && ($emailToken = $this->emailTokens->createToken($request->email, 'reset-password'))) {
                $data = [
                    'url' => route('password.reset', [
                        'token' => $emailToken->token
                    ]),
                    'code' => $emailToken->code,
                    'email' => $user->email,
                    'user' => $user
                ];
                $mailer = get_mailer_setting();
                Email::from($mailer->mail_from_address(siteinfo('email', 'webhay@vcc.vn')), $mailer->mail_from_name(siteinfo('site_name', 'WebHay')))
                    ->to($request->email, $user->name)
                    ->subject("Đặt lại mật khẩu trên hệ thống " . siteinfo('site_name'))
                    ->body('mails.reset-password')
                    ->data($data)
                    ->sendAfter(1);
                $code = 200;
            }

            $status = true;
            $message = "Gửi thành công! Hãy kiểm tra hộp thư đến để đặt lại mật khẩu";
        } else {
            $message = "Email không hợp lệ";
        }

        return $this->json(compact(...$this->apiSystemVars), $code);
    }

    /**
     * get reset password frm
     * @param Request $request
     * @param string $token
     */
    public function getResetPasswordForm(Request $request, $token = null)
    {
        if (!$token) $token = $request->token;
        if ($emailToken = $this->emailTokens->checkRoken($token)) {
            $error = null;
            $tk = $token;
        } else {
            $error = "Token không hợp lệ";
            $tk = null;
        }
        return $this->viewModule('login', ['page' => 'reset', 'error' => $error, 'token' => $token]);
    }

    /**
     * đặt lại mật khẩu
     * @param $request
     */
    public function postResetPassword(Request $request)
    {
        extract($this->apiDefaultData);
        $validator = $this->emailTokens->validator($request, 'Auth\PasswordReset');
        if ($validator->success() && $email = $this->emailTokens->findBy('token', $request->token)) {
            if ($user = $this->repository->resetDefaultParams()->findBy('email', $email->email)) {
                if ($this->repository->update($user->id, ['password' => $request->password])) {
                    $status = true;
                    $message = "Đặt lại mật khẩu thành công!";
                } else {
                    $message = "Lỗi không xác định";
                }
            } else {
                $message = "Hình như có gì đó sai sai! Bạn hãy thử lại trong giây lát";
            }
        } else {
            $message = "Đã có lỗi xảy ta. Vui lòng thử lại!";
            $errors = $validator->errors();
        }

        return $this->json(compact(...$this->apiSystemVars));
    }
}
