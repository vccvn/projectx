<?php

namespace App\Models;

class Warehouse extends Model
{
    public $table = 'warehouse';
    public $fillable = ['owner_id', 'product_id', 'staff_id', 'type', 'total', 'note'];

    /**
     * lay du lieu form
     * @return array
     */
    public function toFormData()
    {
        $data = $this->toArray();
        $data['total'] = abs($this->total);
        return $data;
    }
}
