<?php

namespace App\Models;

use Illuminate\Support\Str;

class Payment extends Model
{
    public $table = 'payments';
    public $fillable = ['user_id', 'ref', 'ref_id', 'type', 'amount', 'note', 'status', 'approved_at', 'approved_by'];


    const PAYMENT_TYPE_BUY = 1;

    const STATUS_PENDING_CODE = 0;
    const STATUS_APPROVED_CODE = 200;
    const STATUS_CANCELED_CODE = -1;
    const STATUS_DECLINED_CODE = -2;
    

    protected $statusList = [
        0 => 'Chờ duyệt',
        200 => 'Đã duyệt',
        '-1' => 'Đã hủy',
        '-2' => 'Bị từ chối',
    ];

    public static function getTypeMap()
    {
        $type = [
            'buy'   => static::PAYMENT_TYPE_BUY,
        ];
        return $type;
    }

    

    public static function getTypeLabelList()
    {
        $labels = [
            static::PAYMENT_TYPE_BUY               => 'Mua / Thanh toán dịch vụ'
        ];
        return $labels;
    }


    public static function getTypeCode($str = null)
    {
        $s = Str::snake($str);
        $list = static::getTypeMap();
        foreach ($list as $key => $value) {
            if ($key == $s || $value == $s) {
                return $value;
            }
        }
        return 0;
    }

    
    public static function checkType($type = null, $value = 0)
    {
        return (($val = static::getTypeCode($type)) != 0 && $val == static::getTypeCode($val));

    }

    
    /**
     * lấy hệ số
     *
     * @param string $type
     * @return int
     */
    public static function getCoefficient($type)
    {
        $code = static::getTypeCode($type);
        $c = 0;
        switch ($code) {
            case static::PAYMENT_TYPE_BUY:
                $c = 1;
                break;
            default:
                # code...
                break;
        }
        return $c;
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id', 'id');
    }

    public function isApproved()
    {
        return $this->status == static::STATUS_APPROVED_CODE;
    }
    public function isDeclined()
    {
        return $this->status == static::STATUS_DECLINED_CODE;
    }
    public function isCanceled()
    {
        return $this->status == static::STATUS_CANCELED_CODE;
    }
    
    public function isPending()
    {
        return $this->status == static::STATUS_PENDING_CODE;
    }

    public function getTypeText()
    {
        $labels = static::getTypeLabelList();

        return $labels[$this->type] ?? $this->type;
    }

    public function getTypeStr()
    {
        $map = static::getTypeMap();
        $type = $this->type;
        foreach ($map as $key => $value) {
            if($type == $value) return $key;
        }
        return $type;
    }

    public function getAmountText()
    {
        return ($this->amount < 0 ? '' : '+') . $this->amount;
    }

    public function isType($type = 'buy')
    {
        return static::checkType($type, $this->type);
    }
    
}
