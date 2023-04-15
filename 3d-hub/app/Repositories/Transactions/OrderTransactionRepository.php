<?php

namespace App\Repositories\Transactions;

use App\Repositories\Base\BaseRepository;
use App\Repositories\Customers\CustomerRepository;
use App\Repositories\Orders\OrderRepository;
use Crazy\Helpers\Email;

class OrderTransactionRepository extends BaseRepository
{
    /**
     * class chứ các phương thức để validate dử liệu
     * @var string $validatorClass 
     */
    protected $validatorClass = 'App\Validators\Transactions\OrderTransactionValidator';
    /**
     * @var string $resource
     */
    protected $resourceClass = 'App\Http\Resources\OrderTransactionResource';
    /**
     * @var string $collectionClass
     */
    protected $collectionClass = 'App\Http\Resources\OrderTransactionCollection';


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

    
    /**
     * @var array $defaultSortBy Mảng key value là twen6 cộ và kiểu sắp xếp
     */
    protected $defaultSortBy = [
        'transactions.id' => 'DESC'
    ];

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
            'ref' => 'order'
        ]);
        $this->addDefaultParam('ref', 'ref', 'order');

        $this->setJoinable([
            ['join', 'customers', 'customers.id', '=', 'transactions.customer_id']
        ]);
        $columns = [
            'code' => 'transactions.code',
            'ref_id' => 'transactions.ref_id',
            'customer_name' => 'customers.name',
            'customer_email' => 'customers.email'
        ];
        $this->setSearchable($columns);
        $this->setSortable(array_merge($columns, ['time' => 'transactions.time']));
        
        $this->setSelectable(array_merge(['transactions.*'], [
            'customer_name' => 'customers.name',
            'customer_email' => 'customers.email',
        ]));
    }

    /**
     * @param array $data
     * @return array $data
     */
    public function beforeSave($data)
    {
        if(array_key_exists('order_id', $data)){
            $data['ref_id'] = $data['order_id'];
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
     * @return void
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
        if($transaction && $transaction->status != $status && ($detail = $this->updateStatus($id, $status))){
            $customerRepository = new CustomerRepository();
            $orderRepository = new OrderRepository();

            $order = $transaction->ref == 'order' ? $orderRepository->findBy('id', $transaction->ref_id) : null;
            $customer = $customerRepository->find($transaction->customer_id);
            $balance = $customer->balance;
            $orderUpdate = null;
            // nếu đã dược duyệt
            if($status == 1){
                // nếu có đơn hàng
                if($order){
                    // nếu số tiền trong phien giao dịch + số dư lớn hơn hoặc bàng giá trị đơn hàng
                    if ($transaction->amount + $balance >= $order->total_money) {
                        // cộng hoặc trừ tiền vào phần dư
                        $balance += ($transaction->amount - $order->total_money);
                        // báo đơn hàng đã được thanh toán
                        $orderUpdate = $orderRepository->pay($order->id);
                    }
                    else{
                        // nếu cả số du và số tiền chuyển khoản không dủ để thanh toán đơn hàng thì cộng vào số dư
                        $balance += $transaction->amount;
                    }
                }else{
                    // nếu không có đơn hàng thì +  vào số dư
                    $balance += $transaction->amount;
                }
            }
            elseif($transaction->status == 1){
                // nếu undo từ đã phê duyệt sang bị hủy hoặc chờ thì số tiền sẽ bụi trừ ngược lại
                // trường hợp có đơn hàng
                if($order && $order->status > 200){
                    $orderUpdate = $orderRepository->unpay($order->id);
                    $balance -= ($transaction->amount - $order->total_money);
                }else{
                    $balance -= $transaction->amount;

                }

            }
            $this->sendMailAlertStatus($transaction->id);
            if($orderUpdate){
                $orderRepository->sendMailAlertOrderStatus($orderUpdate->id);
            }
            return $detail;
        }
    }


    

    public function sendMailAlertStatus($id)
    {
        if($transaction = $this->find($id)){
            $customer = $transaction->customer;
            // thông báo email hoặc làm gì đó
            $subject = 'Thông báo về trạng thái giao dịch';

            $messages = [
                0 => 'được chuyển về trạng thái chờ',
                1 => 'đã được xác nhận',
                -1=>'bị từ chối'
            ];

            $message = 'Giao dịch của bạn '.$messages[$transaction->status];
            $data = [
                'name' =>$customer->name,
                'content' => $message
            ];

            Email::to($customer->email)->subject($subject)->body('mails.simple-alert')->data($data)->send();
        }
    }

}