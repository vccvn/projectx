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
        if($setting->send_mail_notification && $setting->mail_notification){
            $to = [];
            if(count($lines = nl2array($setting->mail_notification))){
                foreach ($lines as $line) {
                    $emails = array_filter(array_map('trim', explode(',', $setting->mail_notification)), function($email){
                        return strlen($email) > 0 && filter_var($email, FILTER_VALIDATE_EMAIL);
                    });
                    foreach ($emails as $email) {
                        $to[] = $email;
                    }
                }
            }
            
            if($to){
                $mailFrom = $siteinfo->email('no-reply@' . get_non_www_domain());
                $company = $siteinfo->company($siteinfo->site_name('VCC Corp'));
                Email::from($mailFrom, $company)
                    ->to($to)
                    ->subject($subject)
                    ->body('mails.simple-alert')
                    ->data(['content' => $content])
                    ->sendAfter(1);
            }
        }
            
    }
}