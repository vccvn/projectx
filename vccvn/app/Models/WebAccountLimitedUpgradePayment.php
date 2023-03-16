<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

class WebAccountLimitedUpgradePayment extends Model
{
    public $table = 'web_account_limited_upgrade_payments';
    public $fillable = ['branch_id', 'package_id', 'account_total', 'type', 'amount', 'code', 'note', 'status'];
    
    /**
     * Get the package that owns the WebAccountLimitedUpgradePayment
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function package(): BelongsTo
    {
        return $this->belongsTo(WebAccountPackage::class, 'package_id', 'id');
    }

    /**
     * Get the user that owns the WebAccountLimitedUpgradePayment
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'branch_id', 'id');
    }

}
