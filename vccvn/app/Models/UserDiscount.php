<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserDiscount extends Model
{
    public $table = 'user_discounts';
    public $fillable = ['user_id', 'discount_id', 'is_linited', 'total', 'usage'];

    public $timestamps = false;

    /**
     * Get the user that owns the UserDiscount
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    /**
     * Get the discount that owns the UserDiscount
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function discount(): BelongsTo
    {
        return $this->belongsTo(Promo::class, 'discount_id', 'id')->where('scope', 'user');
    }

}
