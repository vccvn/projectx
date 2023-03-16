<?php

namespace App\Repositories\Transactions;

use App\Exceptions\NotReportException;
use App\Models\Transaction;
use App\Repositories\Base\BaseRepository;
use App\Repositories\Packages\WebAccountLimitedUpgradePaymentRepository;
use Crazy\Mailer\Email;

class AccountUpgradePaymentTransactionRepository extends BaseRepository
{
    protected $validatorClass = 'Transactions\PackagePaymentValidator';
    protected $maskClass = 'Transactions\TransactionMask';
    protected $maskCollectionClass = 'Transactions\TransactionCollection';

    /**
     * @var WebAccountLimitedUpgradePaymentRepository
     */
    protected $paymentRepository;
    /**
     * Undocumented variable
     *
     * @var array
     */
    protected $statusValues = [
        'approve' => 1,
        'unapprove' => 0,
        'decline' => -1,
        'restore' => 0
    ];

    public $logs = [];

    
    /**
     * @var array $defaultSortBy Mảng key value là twen6 cộ và kiểu sắp xếp
     */
    protected $defaultSortBy = [
        'transactions.id' => 'DESC'
    ];

    
    /**
     * @var \App\Models\Transaction
     */
    static $__Model__;

    /**
     * get model
     * @return string
     */
    public function getModel()
    {
        return \App\Models\Transaction::class;
    }

    public function init()
    {
        $this->addDefaultValue([
            'ref' => 'account-package'
        ]);
        $this->addDefaultParam('ref', 'ref', 'account-package');

        $this->setJoinable([
            ['join', 'users', 'users.id', '=', 'transactions.customer_id']
        ]);
        $columns = [
            'code' => 'transactions.code',
            'ref_id' => 'transactions.ref_id',
            'customer_name' => 'users.name',
            'customer_email' => 'users.email',
            'phone_number' => 'users.phone_number'
        ];
        $this->setSearchable($columns);
        $this->setSortable(array_merge($columns, ['time' => 'transactions.time']));
        
        $this->setSelectable(array_merge(['transactions.*'], [
            'customer_name' => 'users.name',
            'customer_email' => 'users.email',
            'phone_number' => 'users.phone_number'
        ]));
        $this->setWith('bills')->setWith('userCustomer');

        $this->paymentRepository = app(WebAccountLimitedUpgradePaymentRepository::class);
    }

    /**
     * @param array $data
     * @return array $data
     */
    public function beforeSave($data)
    {
        if(array_key_exists('package_payment_id', $data)){
            $data['ref_id'] = $data['package_payment_id'];
        }
        return $data;
    }

    
    /**
     * kiểm tra daterange trước khi filter
     * @param Request $request
     */
    public function beforeFilter($request)
    {
        // nếu có date range và date range hợp lệ thì sẽ thêm vào query
        if($request->daterange && $date = get_date_range($request->daterange)){
            $from = $date['from'];
            $to = $date['to'];
            $this->whereDate('transactions.time', '>=', "$from[year]-$from[month]-$from[day]");
            $this->whereDate('transactions.time', '<=', "$to[year]-$to[month]-$to[day]");
        }
    }

    /**
     * cập nhật trạng thái
     *
     * @param integer $id
     * @param integer $statusUpdate
     * @param integer $statusFind
     * @return Transaction
     */
    public function updateStatus($id, int $statusUpdate = 1, $statusFind = null)
    {
        $args = ['id' => $id];
        if(!is_null($statusFind)){
            $args['status'] = $statusFind;
        }
        if($id && $this->count($args) && $detail = $this->update($id, ['status' => $statusUpdate])){
            return $detail;
        }
        return null;
    }
    
    /**
     * duyệt giao dịch
     * @param integer $id
     */
    public function approve($id)
    {
        return $this->updateStatus($id, 1, 0);
    }

    /**
     * hoàn tác duyệt giao dịch
     * @param integer $id
     */
    public function unApprove($id)
    {
        return $this->updateStatus($id, 0, 1);
    }

    /**
     * từ chối duyệt giao dịch
     * @param integer $id
     */
    public function decline($id)
    {
        return $this->updateStatus($id, -1);
    }

    
    /**
     * cập nhật trạng thái giao dịch và gửi mail
     *
     * @param integer $id
     * @param integer $status
     * @return void
     */
    public function updateStatusAndSendEmail($id, $status)
    {
        
        # code...
        $transaction = $this->FindBy('id', $id);
        $data = null;
        $stt = false;
        
        if($transaction && $transaction->status != $status && ($detail = $this->updateStatus($id, $status))){
            $payment = $this->paymentRepository->with([
                'package', 
                'user' => function($q){$q->with('userWebSetting');}
            ])->findBy('id', $transaction->ref_id);
            if(!$payment) return $data;
            $data = $detail;
            $package = $payment->package;
            $user = $payment->user;
            $userWebSetting = $user->userWebSetting;
            
            if($status == 1){
                $userWebSetting->account_limited += $package->user_limited;
                $userWebSetting->save();
                $payment->status = $status;
                $payment->save();
                $stt = true;
                
            }
            elseif($transaction->status == 1){
                $userWebSetting->account_limited -= $package->user_limited;
                $userWebSetting->save();
                $payment->status = $status;
                $payment->save();
                $stt = true;
            }
            if($stt){
                $this->sendMailAlertStatus($transaction->id);
            }
            
        }
        return $data;
    }


    

    public function sendMailAlertStatus($id)
    {
        if($transaction = $this->detail($id)){
            $customer = $transaction->userCustomer;
            if(!$customer) return;
            // thông báo email hoặc làm gì đó
            $subject = 'Thông báo về trạng thái giao dịch';

            $messages = [
                0 => 'được chuyển về trạng thái chờ',
                1 => 'đã được xác nhận',
                -1=>'bị từ chối'
            ];

            $message = 'Giao dịch của bạn '.$messages[$transaction->status];
            $data = [
                'name' =>$customer?$customer->name:'Quý khách',
                'content' => $message
            ];

            Email::to($customer->email)->subject($subject)->body('mails.simple-alert')->data($data)->send();
        }
    }

}