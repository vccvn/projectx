<?php

namespace App\Http\Controllers\Clients;

use App\Http\Controllers\Clients\ClientController;
use App\Models\Subcribe;
use Illuminate\Http\Request;
use Crazy\Helpers\Arr;

use App\Repositories\Subcribes\SubcribeRepository;
use Crazy\Mailer\Email;

class SubcribeController extends ClientController
{
    protected $module = 'subcribes';

    protected $moduleName = 'Subcribe';

    protected $flashMode = true;

    /**
     * repository chinh
     *
     * @var SubcribeRepository
     */
    public $repository;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(SubcribeRepository $repository)
    {
        $this->repository = $repository;


        $this->setting = setting();
        $this->siteinfo = siteinfo();

        $this->init();
    }

    public function afterSave(Request $request, $result)
    {
        $this->redirectRoute = 'client.alert';
        $this->addRedirectData([
            'type' => 'success',
            'message' => 'Đăng ký theo dõi thành công!'
        ]);
    }

    public function onError(Request $request, $errors = null)
    {
        $error = (is_array($errors) && count($errors))? array_shift($errors) : "Lỗi không xác định";
        return redirect()->back()->with('popup_error', $error);
    }

    /**
     * send mail
     *
     * @param Request $request
     * @param Subcribe $result
     * @return void
     */
    public function afterAjaxSave($request, $result)
    {
        if ($this->setting->send_mail_notification) {
            $mailFrom = $this->siteinfo->email('no-reply@' . get_non_www_domain());
            $company = $this->siteinfo->company($this->siteinfo->site_name('Crazy Support'));
            $maillist = array_filter(explode(',', $this->setting->mail_notification), function ($e) {
                return is_email($e);
            });

            if ($maillist) {
                $d = Email::from($mailFrom, $company)
                    ->to($maillist)
                    ->replyTo($mailFrom, $company)
                    ->subject("Thông báo: Có người Đăng ký theo dõi ")
                    ->body('mails.simple-alert')
                    ->data(['content' => "Thông tin: \n". $result->getSubcribeInfo()])
                    ->send();
            }
        }
    }

}
