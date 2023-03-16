<?php

namespace App\Repositories\Contacts;

use App\Repositories\Base\BaseRepository;
use Crazy\Mailer\Email;

class ContactRepository extends BaseRepository
{
    /**
     * class chứ các phương thức để validate dử liệu
     * @var string $validatorClass 
     */
    protected $validatorClass = 'App\Validators\Contacts\ContactValidator';
    /**
     * @var string $resourceClass
     */
    protected $resourceClass = 'ContactResource';
    /**
     * @var string $collectionClass
     */
    protected $collectionClass = 'ContactCollection';

    /**
     * @var string $system
     */
    protected $system = 'both';

    

    /**
     * get model
     * @return string
     */
    public function getModel()
    {
        return \App\Models\Contact::class;
    }

    public function init()
    {
        $this->defaultSortBy = [
            'contacts.id' => 'DESC'
        ];
    }

    /**
     * gửi email thông báo vừa trả lời liên hệ
     *
     * @param integer $contact_id
     * @param string $reply_message
     * @return void
     */
    public function sendReplyMail(int $contact_id, $reply_message = null, $user = null)
    {
        if($contact = $this->first(['id' => $contact_id])){
            $admin = $user?$user->name:'admin';
            $name = $contact->name;
            $email = Email::to($contact->email, $contact->name)
                            ->subject("trả lời ".($contact->subject??'Liên hệ'))
                            ->body('mails.contact-reply')
                            ->data(compact('admin','name', 'reply_message'));

            // gửi sau 2 phút
            $email->sendAfter(2);
            
        }
    }

}