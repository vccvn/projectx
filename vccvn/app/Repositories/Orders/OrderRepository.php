<?php

namespace App\Repositories\Orders;

use App\Models\Order;
use App\Repositories\Base\BaseRepository;
use App\Repositories\Products\ProductRepository;
use Crazy\Mailer\Email;
use Illuminate\Http\Request;

/**
 * Repository của đơn hàng
 * @method Order|\App\Masks\Orders\OrderMask detail(int|array $args) lấy về chi tiết đơn hàng
 * @method Order[]|\App\Masks\Orders\OrderCollection getResults(array $args) lấy danh sách orders
 * @method Order[]|\App\Masks\Orders\OrderCollection filter(Request $requuest, array $args) lấy danh sách orders
 *
 */
class OrderRepository extends BaseRepository
{
    /**
     * class chứ các phương thức để validate dử liệu
     * @var string $validatorClass
     */
    protected $validatorClass = 'Orders\OrderValidator';
    /**
     * @var string $resource
     */
    protected $resourceClass = 'OrderResource';
    /**
     * @var string $collectionClass
     */
    protected $collectionClass = 'OrderCollection';

    protected $responseMode = 'mask';

    protected $maskClass = 'Orders\OrderMask';
    protected $maskCollectionClass = 'Orders\OrderCollection';

    /**
     * @var array $defaultSortBy Mảng key value là twen6 cộ và kiểu sắp xếp
     */
    protected $defaultSortBy = [
        'orders.id' => 'DESC'
    ];


    /**
     * danh sách trạng thái đơn hàng
     *
     * @var array
     */
    protected $statusList = [
        0   => "pending_verify",       // Đang chờ xác nhận
        100 => "verified",             // đã xác thực
        200 => "pending_payment",      // chờ thanh toán
        300 => "paid",                 // đã thanh toán
        400 => "pending",              // đang xử lý
        500 => "processing",           // đã hoàn thành
        1000 => "completed",           // đã hoàn thành
        -1  => "canceled",             // Bị hủy
    ];

    /**
     * danh sách trạng thái đơn hàng
     *
     * @var array
     */
    protected $statusLabels = [
        0   => "Đang chờ xác nhận",
        100 => "đã xác thực",
        200 => "chờ thanh toán",
        300 => "đã thanh toán ",
        400 => "Chờ xử lý",
        500 => "Đang giao hàng",
        1000 => "Đã hoàn thành",
        -1  => "Bị hủy",
    ];

    /**
     * Trạng thái chờ xử lý
     */
    const PENDING_VERIFY = 0;
    const VERIFIED = 100;
    const PENDING_PAYMENT = 200;
    const PAID = 300;
    const PENDING = 400;
    const PROCESSING = 500;
    const COMPLETED = 1000;
    const CANCELED = -1;

    const PAYMENT_COD = 'cod';
    const PAYMENT_TRANSFER = 'transfer';
    const PAYMENT_VNPAY = 'vnpay';



    protected $isJoindBilling = false;
    protected $isJoindShipping = false;

    /**
     * get model
     * @return string tên class model
     */
    public function getModel()
    {
        return \App\Models\Order::class;
    }
    public function init()
    {
        $this->addDefaultParam('type', 'type', 'order');
        $this->addDefaultValue('type', 'order');
    }

    public function withData()
    {
        return $this->with(['details', 'billing', 'shipping', 'paymentMethod']);
    }


    public function withFullData()
    {
        return $this->with([
            'details',
            'billing' => function ($query) {
                $query->with(['region', 'district', 'ward']);
            },
            'shipping' => function ($query) {
                $query->with(['region', 'district', 'ward']);
            }
        ]);
    }

    public function joinBilling()
    {
        $this->isJoindBilling = true;
        return $this->join('order_address as billings', function ($join) {
            $join->on('billings.order_id', '=', 'orders.id');
            $join->where('billings.type', '=', 'billing');
        });
    }

    public function joinShipping()
    {
        $this->isJoindShipping = true;
        return $this->join('order_address as shippings', function ($join) {
            $join->on('shippings.order_id', '=', 'orders.id');
            $join->where('shippings.type', '=', 'shipping');
        });
    }


    /**
     * lười nghĩ tên hàm
     *
     * @return void
     */
    public function setupX()
    {
        $columns = [
            'billing_name'                        => 'billings.name',
            'billing_email'                       => 'billings.email',
            'billing_phone_number'                => 'billings.phone_number',
            'billing_address'                     => 'billings.address',
            'billing_region_id'                   => 'billings.region_id',
            'billing_district_id'                 => 'billings.district_id',
            'billing_ward_id'                     => 'billings.ward_id',

            'shipping_name'                       => 'shippings.name',
            'shipping_email'                      => 'shippings.email',
            'shipping_phone_number'               => 'shippings.phone_number',
            'shipping_address'                    => 'shippings.address',
            'shipping_region_id'                  => 'shippings.region_id',
            'shipping_district_id'                => 'shippings.district_id',
            'shipping_ward_id'                    => 'shippings.ward_id',
        ];
        $this->joinBilling()->joinShipping();
        $this->setWhereable($columns)->setSearchable($columns);
        $this->setSelectable(array_merge(['orders.*'], $columns));
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
            $this->whereDate('orders.created_at', '>=', "$from[year]-$from[month]-$from[day]");
            $this->whereDate('orders.created_at', '<=', "$to[year]-$to[month]-$to[day]");
        }

        $this->setupX();
    }


    public function beforeGetFormData($args = [])
    {
        $this->setupX();
    }

    /**
     * lấy thông tin đơn hàng nằng thông tin đặt hàng
     * @param string $contact
     * @param int $order_id
     * @return Order
     */

    public function checkOrderByContact($contact, $order_id = 0)
    {
        $this->joinBilling()
            ->where(function ($query) use ($contact) {
                $query->where('billings.email', $contact)->orWhere('billings.phone_number', $contact);
            });
        if ($order_id) {
            $this->where('orders.id', $order_id);
        }
        $this->where('status', 200);
        return $this->select('orders.*')->withData()->first();
    }


    /**
     * get Product option
     * @param Request $request
     * @param array $args
     * @return array
     */
    public function getSelectOptions($request, array $args = [])
    {
        if ($request->ignore && is_array($request->ignore)) {
            $this->whereNotIn('orders.id', $request->ignore);
        }
        $data = [];
        if ($list = $this->getFilter($request, $args)) {
            foreach ($list as $item) {
                $data[$item->id] = 'Đơn hàng #' . $item->id;
            }
        }
        return $data;
    }


    /**
     * cập nhật trạng thái
     *
     * @param integer $id
     * @param integer $statusUpdate
     * @param integer $statusFind
     * @return \App\Models\Order|null
     */
    public function updateStatus($id, int $statusUpdate = 0, $statusFind = null)
    {
        if (!array_key_exists($statusUpdate, $this->statusList)) {
            return null;
        }
        $args = ['id' => $id];
        if (!is_null($statusFind)) {
            $args['status'] = $statusFind;
        }
        if ($id && $this->count($args) && $detail = $this->update($id, ['status' => $statusUpdate])) {
            return $detail;
        }
        return null;
    }


    /**
     * cập nhật trạng thái
     *
     * @param integer $id
     * @param integer $status
     * @return \App\Models\Order|null
     */
    public function updateStatusOnly($id, int $status = 0)
    {
        if (!array_key_exists($status, $this->statusList)) {
            return null;
        }
        if ($id && $detail = $this->update($id, ['status' => $status])) {
            return $detail;
        }
        return null;
    }
    /**
     * Xác thực đơn hàng
     * @param integer $id
     * @return \App\Models\Order|null
     */
    public function verify($id)
    {
        if ($order = $this->updateStatus($id, static::VERIFIED, static::PENDING_VERIFY)) {
            if ($order->paymentMethod->method == self::PAYMENT_COD) {
                return $this->updateStatusOnly($id, static::PENDING);
            } else {
                return $this->updateStatusOnly($id, static::PENDING_PAYMENT);
            }
        }
        return null;
    }

    /**
     * Đã thanh toán
     * @param integer $id
     * @return \App\Models\Order|null
     */
    public function pay($id)
    {
        if ($order = $this->where('status', '>', self::PENDING_VERIFY)->where('status', '<', static::COMPLETED)->findBy('id', $id)) {
            if ($order->paymentMethod->method == self::PAYMENT_COD) {
                return $this->updateStatusOnly($id, static::COMPLETED);
            } else {
                return $this->updateStatusOnly($id, static::PENDING);
            }
        }
        return null;
    }

    /**
     * Đã hoàn thành
     * @param integer $id
     * @return \App\Models\Order|null
     */
    public function compleate($id)
    {
        if ($this->where('status', '>', static::PENDING_VERIFY)->countBy('id', $id)) {
            return $this->updateStatusOnly($id, static::COMPLETED);
        }
        return null;
    }

    /**
     * Hủy
     * @param integer $id
     * @return \App\Models\Order|null
     */
    public function cancel($id)
    {
        if ($this->countBy('id', $id)) {
            return $this->updateStatusOnly($id, static::CANCELED);
        }
        return null;
    }

    /**
     * chưa thanh toan
     * @param integer $id
     * @return \App\Models\Order|null
     */
    public function unpay($id)
    {
        if ($order = $this->where('status', '>=', static::PAID)->where('status', '<', static::PROCESSING)->withData()->findBy('id', $id)) {
            if ($order->paymentMethod->method == 'cod') {
                return $this->updateStatusOnly($id, static::PROCESSING);
            } else {
                return $this->updateStatusOnly($id, static::PAID);
            }
        }
        return null;
    }



    public function sendMailAlertOrderStatus($id)
    {
        if ($order = $this->withData()->findBy('id', $id)) {

            $sent = false;
            if ($order->status == static::COMPLETED && $order->details) {
                $productIDs = [];
                foreach ($order->details as $orderProduct) {
                    if ($orderProduct->product_type == 'digital') {
                        $productIDs[] = $orderProduct->product_id;
                    }
                }

                if (count($productIDs)) {
                    $products = (new ProductRepository())->with('metadatas')->get(['id' => $productIDs]);
                    if (count($products)) {
                        $downloads = [];
                        foreach ($products as $product) {
                            $product->applyMeta();
                            if ($product->download_url) {
                                $downloads[] = $product;
                            }
                        }
                        if (count($downloads)) {
                            Email::to($order->billing->email)
                                ->subject(siteinfo('site_name', get_domain()) . ": Trạng thái đơn hàng #" . $order->id)
                                ->body('mails.order-status')
                                ->data([
                                    'order' => $order,
                                    'name' => $order->billing->name,
                                    'content' => "Đơn hàng $order->id của bạn đã được chuyển sang trạng thái: " . $this->statusLabels[$order->status],
                                    'downloads' => $downloads
                                ])
                                ->send();
                            $sent = true;
                        }
                    }
                }
            }
            if (!$sent) {
                Email::to($order->billing->email)
                    ->subject(siteinfo('site_name', get_domain()) . " Thông báo trạng thái đơn hàng #" . $order->id)
                    ->body('mails.simple-alert')
                    ->data([
                        'name' => $order->billing->name,
                        'content' => "Đơn hàng $order->id của bạn đã được chuyển sang trạng thái: " . $this->statusLabels[$order->status]
                    ])
                    ->send();
            }
        }
    }




    /**
     * lấy thông tin customer order
     *
     * @param integer $customer_id
     * @param integer $user_id
     * @return OrderRepository
     */
    public function getCustomerOrderQuery($customer_id = 0, $user_id = 0)
    {
        $this->where(function ($query) use ($customer_id, $user_id) {
            if ($customer_id) {
                $query->where('customer_id', $customer_id);
                if ($user_id) {
                    $query->orWhere('user_id', $user_id);
                }
            } else {
                $query->where('user_id', $user_id);
            }
        });
        return $this;
    }


    /**
     * lấy thông tin customer order
     *
     * @param integer $customer_id
     * @param integer $user_id
     * @param array $args
     * @return \App\Models\Order|null
     */
    public function getCustomerOrders($customer_id = 0, $user_id = 0, $args = [])
    {
        $this->getCustomerOrderQuery($customer_id, $user_id)->withData()->withCount('items')->orderBy('id', 'DESC');
        return $this->getData($args);
    }


    /**
     * lấy thông tin customer order
     *
     * @param integer $customer_id
     * @param integer $user_id
     * @param array $args
     * @return \App\Models\Order|null
     */
    public function getCustomerOrderDetail($customer_id = 0, $user_id = 0, $args = [])
    {
        $this->getCustomerOrderQuery($customer_id, $user_id)->withData();
        return $this->detail($args);
    }

    /**
     * kiểm tra user đã mua hàng hay chưa theo mã sản phẩm và thông tin user hiện tại
     *
     * @param int $product_id
     * @param array $customer_info
     * @return bool
     */
    public function checkProductBoughtCustomer($product_id, $customer_info = [])
    {
        if (!is_array($customer_info) || (!isset($customer_info['user_id']) && !!isset($customer_info['customer_id']))) {
            return false;
        }
        $args = [];
        if (isset($customer_info['user_id']) && !isset($customer_info['customer_id'])) {
            $this->where(function ($query) use ($customer_info) {
                $query->where('orders.user_id', $customer_info['user_id']);
                if (is_array($customer_info['customer_id'])) {
                    $query->orWhereIn('orders.customer_id', $customer_info['customer_id']);
                } else {
                    $query->orWhere('orders.customer_id', $customer_info['customer_id']);
                }
            });
        } else {
            foreach ($customer_info as $key => $value) {
                if (in_array($key, ['name', 'phone_number', 'email'])) {
                    if (!$this->isJoindBilling) {
                        $this->joinBilling();
                    }
                    $args['billings.' . $key] = $value;
                } else {
                    $args[$key] = $value;
                }
            }
        }
        $this->join('order_items', 'prder_items.order_id', '=', 'orders.id')->where('order_items.product_id', $product_id);
        $args['status'] = self::COMPLETED;
        return $this->count($args) > 0;
    }
}
