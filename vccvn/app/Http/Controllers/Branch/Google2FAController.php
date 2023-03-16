<?php

namespace App\Http\Controllers\Branch;

use App\Http\Controllers\Branch\ManagerController;

use Illuminate\Http\Request;
use Crazy\Helpers\Arr;

use App\Repositories\Users\UserRepository;

class Google2FAController extends ManagerController
{
    protected $module = 'google2fa';

    protected $moduleName = 'User';

    public $viewFolder = 'google2fa';

    protected $flashMode = true;

    /**
     * repository chinh
     *
     * @var UserRepository
     */
    public $repository;
    
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(UserRepository $repository)
    {
        $this->repository = $repository;
        $this->init();
    }
    public function showQr(Request $request)
    {
        // get the logged in user
        $user = $request->user();

        // initialise the 2FA class
        $google2fa = app('pragmarx.google2fa');
        
        if(!$user->google2fa_secret || $request->reauthenticating){
            $user->setGoogle2faSecretAttribute($google2fa->generateSecretKey());
            $user->save();
            
        }
        // generate the QR image
        $QR_Image = $google2fa->getQRCodeInline(
            config('app.name'),
            $user->email,
            $user->google2fa_secret
        );

        // Pass the QR barcode image to our view.
        return $this->view('qr', [
            'QR_Image' => $QR_Image, 
            'secret' => $user->google2fa_secret,
            'reauthenticating' => true
        ]);
    }

    public function check2fa(Request $request)
    {
        if($next = $request->next) $red = $next;
        else $red = URL()->previous();
        return redirect($red);
    }

}
