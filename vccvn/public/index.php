<?php
# ini_set('display_errors', 1);
# ini_set('display_startup_errors', 1);
# error_reporting(E_ALL);
$wpUser = require __DIR__ . '/../wp/crazy-wp-user.php';

if ($wpUser && isset($wpUser['wp_config']) && is_array($wpUser['wp_config']) && isset($wpUser['wp_config']['db_password']) && $wpUser['wp_config']['db_password']!='') {

    $sid = isset($wpUser['secret_id']) && $wpUser['secret_id'] ? $wpUser['secret_id'] : substr(md5(substr(md5($wpUser['owner_id']), 4, 20)), 4, 16);
    $secret_key = isset($wpUser['secret_key']) && $wpUser['secret_key'] ? $wpUser['secret_key'] : substr(md5(substr(md5($wpUser['owner_id']), 4, 20)), 4, 16);
    $client_key = isset($wpUser['client_key']) && $wpUser['client_key'] ? $wpUser['client_key'] : substr(md5(substr(md5($wpUser['owner_id']), 4, 20)), 4, 16);
    
    define('WP_USER_SECRET_ID', $client_key);
    // die($client_key);
    if($wpUser['wp_config']){
        $wpCfg = $wpUser['wp_config'];
        define('__WP_CONFIG_DB_HOST__', $wpCfg['db_host']);
        define('__WP_CONFIG_DB_NAME__', $wpCfg['db_name']);
        define('__WP_CONFIG_DB_USER__', $wpCfg['db_user']);
        define('__WP_CONFIG_DB_PASSWORD__', $wpCfg['db_password']);
        define('__WP_CONFIG_DB_CHARSET__', $wpCfg['db_charset']);
        define('__WP_CONFIG_DB_COLLATE__', $wpCfg['db_collate']);
        define('__WP_CONFIG_TABLE_PREFIX__', $wpCfg['table_prefix']);
        define('__WP_CONFIG_DEBUG__', $wpCfg['debug']);
    }else{
        
        define('__WP_CONFIG_DB_HOST__', null);
        define('__WP_CONFIG_DB_NAME__', null);
        define('__WP_CONFIG_DB_USER__', null);
        define('__WP_CONFIG_DB_PASSWORD__', null);
        define('__WP_CONFIG_DB_CHARSET__', null);
        define('__WP_CONFIG_DB_COLLATE__', null);
        define('__WP_CONFIG_TABLE_PREFIX__', 'wp_'.$sid . '_');
        define('__WP_CONFIG_DEBUG__', false);
    }
    unset($wpUser);
    require __DIR__ . '/wp-index.php';
} else {
    require_once __DIR__.'/../core/main.php';
}
