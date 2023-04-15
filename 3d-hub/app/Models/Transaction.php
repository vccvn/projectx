<?php

namespace App\Models;

class Transaction extends Model
{
    public $table = 'transactions';
    public $fillable = ['created_id', 'customer_id', 'approved_id', 'type', 'ref', 'ref_id', 'code', 'amount', 'note', 'metadata', 'time', 'status', 'deleted'];
    protected $casts = [
        'metadata' => 'array'
    ];

    
    /**
     * lay du lieu form
     * @return array
     */
    public function toFormData()
    {
        $data = $this->toArray();
        return $data;
    }

    /**
     * nguoi tao giao dich
     */
    public function createdBy()
    {
        return $this->belongsTo('App\Models\User', 'created_id', 'id')->select('id', 'name', 'email', 'avatar');
    }

    /**
     * nguoi tao giao dich
     */
    public function apprevedBy()
    {
        return $this->belongsTo('App\Models\User', 'appreved_id', 'id')->select('id', 'name', 'email', 'avatar');
    }

    /**
     * nguoi tao giao dich
     */
    public function customer()
    {
        return $this->belongsTo('App\Models\Customer', 'customer_id', 'id')->select('id', 'name', 'email');
    }
    /**
     * nguoi tao giao dich
     */
    public function userCustomer()
    {
        return $this->belongsTo('App\Models\User', 'customer_id', 'id')->select('id', 'name', 'email');
    }


    public function bills()
    {
        return $this->hasMany('App\Models\File', 'ref_id', 'id')->where('ref', 'transaction');
    }

      
    /**
     * xóa dữ liệu
     */
    public function beforeDelete()
    {
        // delete bills
        if(count($this->bills)){
            foreach ($this->bills as $bill) {
                $bill->delete();
            }
        }
        
    }

    
}
