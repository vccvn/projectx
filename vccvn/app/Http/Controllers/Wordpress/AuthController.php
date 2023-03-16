<?php

namespace App\Http\Controllers\Wordpress;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;

use App\Repositories\Users\UserRepository;
use App\Repositories\Emails\EmailTokenRepository;

use Crazy\Mailer\Email;

use Crazy\Helpers\Arr;

class AuthController extends ManagerController
{
    protected $module = 'auth';

    protected $moduleName = 'Auth';
    


    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(UserRepository $userRepository, EmailTokenRepository $EmailTokenRepository)
    {
        $this->middleware('guest')->except('logout');
        $this->repository = $userRepository;
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
        if(!$validator->success()){
            $message = "Đăng nhập không thành công!";
            $errors = $validator->errors();
        }elseif($user = $this->repository->findLogin($request->username)){
            $args = [
                'status' => 1,
                'deleted' => 0,
                'id' => $user->id,
                'email' => $user->email,
                'password' => $request->password
            ];
            if(Auth::attempt($args,$request->remember)){
                $data = ['redirect' => route('home')];
                $status = true;
                // if(!$user->google2fa_secret){
                //     $data = ['redirect' => route('setup-2fa')];
                
                //     $google2fa = app('pragmarx.google2fa');
                //     $user->setGoogle2faSecretAttribute($google2fa->generateSecretKey());
                //     $user->save();
                    
                // }
                
            }else{
                $message = "Đăng nhập không thành công!";
            }
        }else{
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

        $validator = $this->repository->validator($request, 'Auth\Email');
        if($validator->success()){
            if(($user = $this->repository->findBy('email', $request->email)) && ($emailToken = $this->emailTokens->createToken($request->email, 'reset-password'))){
                $data = [
                    'url' => route('password.reset', [
                        'token' => $emailToken->token
                    ]),
                    'code' => $emailToken->code,
                    'email' => $user->email,
                    'user' => $user
                ];

                Email::from('no-reply@chinhlatoi.me', 'Crazy Support')
                     ->to($request->email, $user->name)
                     ->subject("Đặt lại mật khẩu trên hệ thống CraxyWeb")
                     ->body('mails.reset-password')
                     ->data($data)
                     ->sendAfter(1);
            }
            
            $status = true;
            $message = "Gửi thành công! Hãy kiểm tra hộp thư đến để đặt lại mật khẩu";
        }
        else{
            $message = "Email không hợp lệ";
        }

        return $this->json(compact(...$this->apiSystemVars));
    }

    /**
     * get reset password frm
     * @param Request $request
     * @param string $token
     */
    public function getResetPasswordForm(Request $request, $token = null)
    {
        if(!$token) $token = $request->token;
        if($emailToken = $this->emailTokens->checkRoken($token)){
            $error = null;
            $tk = $token;
        }else{
            $error = "Token không hợp lệ";
            $tk = null;
        }
        return $this->viewModule('login', ['page' => 'reset', 'error'=>$error, 'token'=>$token]);
    }

    /**
     * đặt lại mật khẩu
     * @param $request
     */
    public function postResetPassword(Request $request)
    {
        extract($this->apiDefaultData);
        $validator = $this->emailTokens->validator($request,'Auth\PasswordReset');
        if($validator->success() && $email = $this->emailTokens->findBy('token', $request->token)){
            if($user = $this->repository->findBy('email', $email->email)){
                if($this->repository->update($user->id, ['password'=>$request->password])){
                    $status = true;
                    $message = "Đặt lại mật khẩu thành công!";
                }else{
                    $message = "Lỗi không xác định";
                }
            }else{
                $message = "Hình như có gì đó sai sai! Bạn hãy thử lại trong giây lát";
            }
        }else{
            $message = "Đã có lỗi xảy ta. Vui lòng thử lại!";
            $errors = $validator->errors();
        }

        return $this->json(compact(...$this->apiSystemVars));
    }

}
