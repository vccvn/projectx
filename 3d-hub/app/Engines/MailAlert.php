<?php
namespace App\Engines;

use Crazy\Mailer\Email;

Class MailAlert{
    # code here...
    /**
     * gửi email thong báo
     *
     * @param string|array $subject
     * @param string $content
     * @return void
     */
    public static function send($subject = null, $content = null)
    {
        if(is_array($subject)){
            $a = $subject;
            if(isset($a['content'])){
                $content = $a['content'];
            }
            if(isset($a['subject'])){
                $subject = $a['subject'];
            }else{
                $subject = "Thông báo";
            }
        }
        $setting = setting();
        $siteinfo = siteinfo();
        if($setting->send_mail_notification && is_email($setting->mail_notification)){
            $mailFrom = $siteinfo->email('no-reply@' . get_non_www_domain());
            $company = $siteinfo->company($siteinfo->site_name('Crazy Support'));
            Email::from($mailFrom, $company)
                ->to($setting->mail_notification)
                ->subject($subject)
                ->body('mails.simple-alert')
                ->data(['content' => $content])
                ->sendAfter(1);
        }
    }
}