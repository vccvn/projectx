<?php

namespace App\Engines\Payments;

use App\Engines\Helper;
use App\Exceptions\NotReportException;
use Crazy\Files\Filemanager;
use Crazy\Helpers\Arr;
use Illuminate\Http\Request;

class VNPay
{
    protected static $_config = [];
    const PAYMENT_URL = 'http://sandbox.vnpayment.vn/paymentv2/vpcpay.html';
    const VERSION = '2.0.0';

    /**
     * cấu hình
     *
     * @param array $config
     * @return $this
     */
    public static function config($config = [])
    {
        static::$_config = $config;
    }

    /**
     * tạo url thanh toám
     *
     * @param array $payment_data
     * @return string duong dan thanh toan vnpay
     */
    public static function create($payment_data = [])
    {
        $d = new Arr(array_merge(static::$_config, $payment_data));
        $vnp_TmnCode = $d->get(['vnp_TmnCode', 'TmnCode', 'tmncode', 'tmn_code']); //Mã website tại VNPAY
        $vnp_HashSecret = $d->get(['vnp_HashSecret', 'HashSecret', 'hashsecret', 'hash_secret']); //Chuỗi bí mật
        $bank = $d->get(['vnp_BankCode', 'bank', 'vnpay_bank']);

        $amount = $d->vnp_Amount((int) ($d->get(['total', 'money', 'total_money'], 0) * 100)) ;

        $order_id = $d->get(["vnp_TxnRef", 'order_id', 'orderId', 'id']);
        
        if (!$vnp_TmnCode || !$vnp_HashSecret || !$bank || !is_numeric($amount) || !$order_id) abort(402, "Thông tin thanh toán không hợp lệ");
        
        
        $vnp_Returnurl = $d->get(['vnp_Returnurl','return_url', 'returnUrl', 'returnurl'], route('client.payments.vnpay.status'));
        // dd($vnp_TmnCode, $vnp_HashSecret);
        $vnp_Url = static::PAYMENT_URL;

        $vnp_OrderInfo = $d->get(["vnp_OrderInfo", 'note'], "Thanh toan hoa don so ". $order_id);
        $vnp_OrderType = $d->get(['vnp_OrderType','order_type', 'OrderType', 'orderType'], 100000);
        $vnp_Amount = $amount;
        $vnp_IpAddr = $_SERVER['REMOTE_ADDR'];
        
        $inputData = [
            "vnp_Version" => $d->vnp_Version(self::VERSION),
            "vnp_TmnCode" => $vnp_TmnCode,
            "vnp_Amount" => $vnp_Amount,
            "vnp_Command" => $d->vnp_Command("pay"),
            "vnp_CreateDate" => $d->vnp_CreateDate(date('YmdHis')),
            "vnp_CurrCode" => strtoupper($d->get(['vnp_CurrCode', 'CurrCode', 'currency', 'currency_code', 'curr_code'], 'VND')),
            "vnp_IpAddr" => $d->vnp_IpAddr($vnp_IpAddr),
            "vnp_Locale" => $d->vnp_Locale($d->locale('vn')),
            "vnp_OrderInfo" => $vnp_OrderInfo,
            "vnp_OrderType" => $vnp_OrderType,
            "vnp_ReturnUrl" => $vnp_Returnurl,
            "vnp_TxnRef" => $order_id,
        ];
        if ($bank) {
            $inputData['vnp_BankCode'] = $bank;
        }
        
        ksort($inputData);
        $query = "";
        $i = 0;
        $hashdata = "";
        foreach ($inputData as $key => $value) {
            if ($i == 1) {
                $hashdata .= '&' . $key . "=" . $value;
            } else {
                $hashdata .= $key . "=" . $value;
                $i = 1;
            }
            $query .= urlencode($key) . "=" . urlencode($value) . '&';
        }

        $vnp_Url = $vnp_Url . "?" . $query;
        if (isset($vnp_HashSecret)) {
            // $vnpSecureHash = md5($vnp_HashSecret . $hashdata);
            $vnpSecureHash = hash('sha256', $vnp_HashSecret . $hashdata);
            $vnp_Url .= 'vnp_SecureHashType=SHA256&vnp_SecureHash=' . $vnpSecureHash;
        }

        return $vnp_Url;
    }

    /**
     * kiểm tra và xử lý giao dịch
     *
     * @param array $data
     * @param \Closure|function[$order_id,$transaction_code,$return_code]|mixed $callback
     * @return array
     */
    public static function check($data = [], $callback = null)
    {
        if (!$data) $data = request()->all();
        $config = static::$_config;
        if (!isset($config['TmnCode']) || !isset($config['HashSecret'])) abort(404);
        // code của vnpay
        $inputData = array();
        $returnData = array();
        foreach ($data as $key => $value) {
            if (substr($key, 0, 4) == "vnp_") {
                $inputData[$key] = $value;
            }
        }

        $vnp_SecureHash = $inputData['vnp_SecureHash'];
        unset($inputData['vnp_SecureHashType']);
        unset($inputData['vnp_SecureHash']);
        ksort($inputData);
        $i = 0;
        $hashData = "";
        foreach ($inputData as $key => $value) {
            if ($i == 1) {
                $hashData = $hashData . '&' . $key . "=" . $value;
            } else {
                $hashData = $hashData . $key . "=" . $value;
                $i = 1;
            }
        }
        $vnpTranId = $inputData['vnp_TransactionNo']; //Mã giao dịch tại VNPAY
        $vnp_BankCode = $inputData['vnp_BankCode']; //Ngân hàng thanh toán
        $secureHash = hash('sha256', $config['HashSecret'] . $hashData);
        $Status = 0;
        $orderId = $inputData['vnp_TxnRef'];

        // bắt đầu logic
        $orderInfo = isset($inputData['vnp_OrderInfo']) ? $inputData['vnp_OrderInfo'] : 0;
        $rspCode = '99';
        $vnMessage = [
            '00' => 'Success',
            '97' => 'Chu ky khong hop le',
            '01' => 'Order not found',
            '02' => 'Order already confirmed',
            '99' => 'Loi khong xac dinh'
        ];

        try {
            app(Filemanager::class)->append(json_encode($inputData)."\r\n", storage_path("logs/access/vnp-".date("Y-m-d").'.txt'));
            //Check Orderid
            //Kiểm tra checksum của dữ liệu
            if ($secureHash != $vnp_SecureHash) {
                $rspCode = '97';
            } else {
                if (is_callable($callback)) {
                    $rs = call_user_func_array($callback, [
                        $orderId,
                        $vnpTranId,
                        [
                            'success' => '00',
                            'exists' => '01',
                            'paid' => '02',
                            'fail' => '99',
                            'uthor' => '99'
                        ]
                    ]);

                    if (is_bool($rs)) {
                        $rspCode = $rs == true ? '00' : '99';
                    } elseif (is_numeric($rs) || is_string($rs)) {
                        if (array_key_exists($rs, $vnMessage)) {
                            $rspCode = $rs;
                        } else $rspCode = '99';
                    }
                } else {
                    $rspCode = '99';
                }
            }

            $returnData['RspCode'] = $rspCode;
            $returnData['Message'] = $vnMessage[$rspCode];
        } catch (NotReportException $e) {
            $returnData['RspCode'] = '99';
            $returnData['Message'] = 'Unknow error';
        }
        //Trả lại VNPAY theo định dạng JSON
        return $returnData;
    }

    public static function status($inputData = [])
    {
        $config = static::$_config;
        if (!isset($config['TmnCode']) || !isset($config['HashSecret'])) abort(404);

        $vnp_SecureHash = $inputData['vnp_SecureHash'] ?? 'hahaha';
        $vnp_ResponseCode = $inputData['vnp_ResponseCode'] ?? 'sai';
        unset($inputData['vnp_SecureHashType']);
        unset($inputData['vnp_SecureHash']);
        ksort($inputData);
        $i = 0;
        $hashData = "";
        foreach ($inputData as $key => $value) {
            if ($i == 1) {
                $hashData = $hashData . '&' . $key . "=" . $value;
            } else {
                $hashData = $hashData . $key . "=" . $value;
                $i = 1;
            }
        }

        $secureHash = hash('sha256', $config['HashSecret'] . $hashData);

        if ($secureHash != $vnp_SecureHash) {
            return null;
        } elseif ($vnp_ResponseCode != '00') {
            return false;
        }
        return true;
    }
}
