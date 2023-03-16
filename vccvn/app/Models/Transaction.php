<?php

namespace App\Models;

class Transaction extends Model
{
    public $table = 'transactions';
    public $fillable = ['owner_id', 'created_id', 'customer_id', 'approved_id', 'type', 'ref', 'ref_id', 'code', 'amount', 'note', 'time', 'status', 'deleted'];

    
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
        return $this->belongsTo(User::class, 'created_id', 'id')->select('name', 'email', 'avatar');
    }

    /**
     * nguoi tao giao dich
     */
    public function apprevedBy()
    {
        return $this->belongsTo(User::class, 'appreved_id', 'id')->select('name', 'email', 'avatar');
    }

    /**
     * nguoi tao giao dich
     */
    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id', 'id')->select('name', 'email');
    }

    /**
     * nguoi tao giao dich
     */
    public function userCustomer()
    {
        return $this->belongsTo(User::class, 'customer_id', 'id')->select('id', 'name', 'email');
    }


    public function bills()
    {
        return $this->hasMany(File::class, 'ref_id', 'id')->where('ref', 'transaction');
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
