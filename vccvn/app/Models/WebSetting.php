<?php

namespace App\Models;

class WebSetting extends Model
{
    public $table = 'web_settings';
    public $fillable = [
        'owner_id', 'theme_id', 'web_type', 'account_type', 'expired_at', 
        'domain', 'base_domain', 'subdomain', 'alias_domain', 'ssl', "account_limited", 'account_usage',
        "storage_limited", 'storage_usage',
        'cache_time'
    ];
    public $timestamps = false;
    
    /**
     * 
     */
}
