<?php

namespace App\Repositories\Transactions;

use App\Models\Transaction;
use App\Repositories\Base\BaseRepository;
use App\Repositories\Customers\CustomerRepository;
use App\Repositories\Orders\OrderRepository;
use Crazy\Mailer\Email;

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
     * tên class mặt nạ. Thược có tiền tố [tên thư mục] + \ vá hậu tố Mask
     *
     * @var string
     */
    protected $maskClass = 'Transactions\TransactionMask';

    /**
     * tên collection mặt nạ
     *
     * @var string
     */
    protected $maskCollectionClass = 'Transactions\TransactionCollection';

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
        return Transaction::class;
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
        $this->setWith('bills');
    }

    /**
     * @param array $data
     * @return array $data
     */
    public function beforeSave($data)
    {
        if (array_key_exists('order_id', $data)) {
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
        if ($request->daterange && $date = get_date_range($request->daterange)) {
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
     * @param integer $status
     * @param integer $statusFind
     * @param boolean $sendMail
     * @return void
     */
    public function updateStatus($id, int $status = 1, $statusFind = null, $sendMail = false)
    {
        $args = ['id' => $id];
        if (!is_null($statusFind)) {
            $args['status'] = $statusFind;
        }
        if ($id && $transaction = $this->detail($args)) {

            if ($transaction->status != $status && ($detail = $this->update($id, ['status' => $status]))) {
                $customerRepository = new CustomerRepository();
                $orderRepository = new OrderRepository();

                $order = $transaction->ref == 'order' ? $orderRepository->findBy('id', $transaction->ref_id) : null;
                $customer = $customerRepository->find($transaction->customer_id);
                $balance = $customer->balance;
                $orderUpdate = null;
                // nếu đã dược duyệt
                if ($status == 1) {
                    // nếu có đơn hàng
                    if ($order) {
                        // nếu số tiền trong phien giao dịch + số dư lớn hơn hoặc bàng giá trị đơn hàng
                        if ($transaction->amount + $balance >= $order->total_money) {
                            // cộng hoặc trừ tiền vào phần dư
                            $balance += ($transaction->amount - $order->total_money);
                            // báo đơn hàng đã được thanh toán
                            $orderUpdate = $orderRepository->pay($order->id);
                        } else {
                            // nếu cả số du và số tiền chuyển khoản không dủ để thanh toán đơn hàng thì cộng vào số dư
                            $balance += $transaction->amount;
                        }
                    } else {
                        // nếu không có đơn hàng thì +  vào số dư
                        $balance += $transaction->amount;
                    }
                } elseif ($transaction->status == 1) {
                    // nếu undo từ đã phê duyệt sang bị hủy hoặc chờ thì số tiền sẽ bụi trừ ngược lại
                    // trường hợp có đơn hàng
                    if ($order && $order->status > OrderRepository::PENDING_PAYMENT) {
                        $orderUpdate = $orderRepository->unpay($order->id);
                        $balance -= ($transaction->amount - $order->total_money);
                    } else {
                        $balance -= $transaction->amount;
                    }
                }
                if($sendMail){
                    $this->sendMailAlertStatus($transaction->id);
                    if ($orderUpdate) {
                        $orderRepository->sendMailAlertOrderStatus($orderUpdate->id);
                    }
                }

                return $detail;
            }
        }
        return null;
    }
    /**
     * duyệt giao dịch
     * @param integer $id
     * @param boolean $sendMail có gửi mail thông báo hay không
     * @return Transaction|null
     */
    public function approve($id, $sendMail = false)
    {
        return $this->updateStatus($id, 1, 0, $sendMail);
    }

    /**
     * hoàn tác duyệt giao dịch
     * @param integer $id
     * @param boolean $sendMail có gửi mail thông báo hay không
     * @return Transaction|null
     */
    public function unApprove($id, $sendMail = false)
    {
        return $this->updateStatus($id, 0, 1, $sendMail = false);
    }

    /**
     * từ chối duyệt giao dịch
     * @param integer $id
     * @param boolean $sendMail có gửi mail thông báo hay không
     * @return Transaction|null
     */
    public function decline($id, $sendMail = false)
    {
        return $this->updateStatus($id, -1, null, $sendMail);
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

        return $this->updateStatus($id, $status, null, true);
    }




    /**
     * gửi mail thông báo trạng thái giao dịch
     *
     * @param int|Transaction $id
     * @return void
     */
    public function sendMailAlertStatus($id)
    {
        $transaction = null;
        if (is_object($id)) {
            if (is_a($id, Transaction::class)) $transaction = $id;
        } elseif (is_numeric($id) && $trans = $this->detail($id)) {
            $transaction = $trans;
        }
        if ($transaction) {
            $customer = $transaction->customer;
            // thông báo email hoặc làm gì đó
            $subject = 'Thông báo về trạng thái giao dịch';

            $messages = [
                0 => 'được chuyển về trạng thái chờ',
                1 => 'đã được xác nhận',
                -1 => 'bị từ chối'
            ];

            $message = 'Giao dịch của bạn ' . $messages[$transaction->status];
            $data = [
                'name' => $customer->name,
                'content' => $message
            ];

            Email::to($customer->email)->subject($subject)->body('mails.simple-alert')->data($data)->send();
        }
    }
}
