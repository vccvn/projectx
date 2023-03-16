<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class Promo extends Model
{
    public $table = 'promos';
    public $fillable = ['owner_id', 'name', 'description','scope', 'type', 'down_price', 'limited_total', 'usage_total', 'quantity_per_user', 'code', 'started_at', 'finished_at', 'deleted'];


    const TYPE_DOWN_PRICE = 0;
    const TYPE_DOWN_PERCENT = 1;
    const TYPE_FREESHIP = 2;
    

    public function productRefs()
    {
        return $this->hasMany('App\Models\ProductRef', 'ref_id', 'id')->where('ref', 'promo');
    }
    /**
     * lay du lieu form
     * @return array
     */
    public function toFormData()
    {
        $data = $this->toArray();
        $data['times'] = substr($this->started_at, 0, 16) . ' - ' . substr($this->finished_at, 0, 16);
        $data['user_list'] = $this->getUserOptions();
        return $data;
    }

    public function promoDateFormat($format = 'H:i:s d/m/Y', $column = 'finished_at')
    {
        return date($format, strtotime($this->{in_array($c = strtolower($column), ['finished_at', 'started_at'])?$c:'finished_at'}));
    }

    public function beforeDelete()
    {
        $this->productRefs()->delete();
    }

    /**
     * Get all of the users for the Promo
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasManyThrough
     */
    public function users(): HasManyThrough
    {
        return $this->hasManyThrough(
            User::class, 
            UserDiscount::class,
            'discount_id',
            'id',
            'id',
            'user_id'
        );
    }

    /**
     * Get all of the userDiscounts for the Promo
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function userDiscounts(): HasMany
    {
        return $this->hasMany(User::class, 'discount_id', 'id');
    }

    /**
     * user optiobs
     * @return array
     */
    public function getUserOptions()
    {
        $options = [];
        if($this->users){
            foreach ($this->users as $user) {
                $options[] = [
                    'name' => $user->name,
                    'id' => $user->id
                ];
            }
        }
        return $options;
    }
    
}
