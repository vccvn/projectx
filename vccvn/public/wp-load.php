<?php

if (!defined('WP_USER_SECRET_ID')) {
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
	} else {
		exit;
	}
}

define('WP_USER_CONTENT', 'wp-content/' . WP_USER_SECRET_ID);



/**
 * Bootstrap file for setting the ABSPATH constant
 * and loading the wp-config.php file. The wp-config.php
 * file will then load the wp-settings.php file, which
 * will then set up the WordPress environment.
 *
 * If the wp-config.php file is not found then an error
 * will be displayed asking the visitor to set up the
 * wp-config.php file.
 *
 * Will also search for wp-config.php in WordPress' parent
 * directory to allow the WordPress directory to remain
 * untouched.
 *
 * @package WordPress
 */

/** Define ABSPATH as this file's directory */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/*
 * The error_reporting() function can be disabled in php.ini. On systems where that is the case,
 * it's best to add a dummy function to the wp-config.php file, but as this call to the function
 * is run prior to wp-config.php loading, it is wrapped in a function_exists() check.
 */
if ( function_exists( 'error_reporting' ) ) {
	/*
	 * Initialize error reporting to a known set of levels.
	 *
	 * This will be adapted in wp_debug_mode() located in wp-includes/load.php based on WP_DEBUG.
	 * @see http://php.net/manual/en/errorfunc.constants.php List of known error levels.
	 */
	error_reporting( E_CORE_ERROR | E_CORE_WARNING | E_COMPILE_ERROR | E_ERROR | E_WARNING | E_PARSE | E_USER_ERROR | E_USER_WARNING | E_RECOVERABLE_ERROR );
}

/*
 * If wp-config.php exists in the WordPress root, or if it exists in the root and wp-settings.php
 * doesn't, load wp-config.php. The secondary check for wp-settings.php has the added benefit
 * of avoiding cases where the current directory is a nested installation, e.g. / is WordPress(a)
 * and /blog/ is WordPress(b).
 *
 * If neither set of conditions is true, initiate loading the setup process.
 */
if ( file_exists( ABSPATH . 'wp-config.php' ) ) {

	/** The config file resides in ABSPATH */
	require_once ABSPATH . 'wp-config.php';

} elseif ( @file_exists( dirname( ABSPATH ) . '/wp-config.php' ) && ! @file_exists( dirname( ABSPATH ) . '/wp-settings.php' ) ) {

	/** The config file resides one level above ABSPATH but is not part of another installation */
	require_once dirname( ABSPATH ) . '/wp-config.php';

} else {

	// A config file doesn't exist.

	define( 'WPINC', 'wp-includes' );
	require_once ABSPATH . WPINC . '/load.php';

	// Standardize $_SERVER variables across setups.
	wp_fix_server_vars();

	require_once ABSPATH . WPINC . '/functions.php';

	$path = wp_guess_url() . '/wp-admin/setup-config.php';

	/*
	 * We're going to redirect to setup-config.php. While this shouldn't result
	 * in an infinite loop, that's a silly thing to assume, don't you think? If
	 * we're traveling in circles, our last-ditch effort is "Need more help?"
	 */
	if ( false === strpos( $_SERVER['REQUEST_URI'], 'setup-config' ) ) {
		header( 'Location: ' . $path );
		exit;
	}

	define( 'WP_CONTENT_DIR', ABSPATH . WP_USER_CONTENT );
	
	require_once ABSPATH . WPINC . '/version.php';

	wp_check_php_mysql_versions();
	wp_load_translations_early();

	// Die with an error message.
	$die = '<p>' . sprintf(
		/* translators: %s: wp-config.php */
		__( "There doesn't seem to be a %s file. I need this before we can get started." ),
		'<code>wp-config.php</code>'
	) . '</p>';
	$die .= '<p>' . sprintf(
		/* translators: %s: Documentation URL. */
		__( "Need more help? <a href='%s'>We got it</a>." ),
		__( 'https://wordpress.org/support/article/editing-wp-config-php/' )
	) . '</p>';
	$die .= '<p>' . sprintf(
		/* translators: %s: wp-config.php */
		__( "You can create a %s file through a web interface, but this doesn't work for all server setups. The safest way is to manually create the file." ),
		'<code>wp-config.php</code>'
	) . '</p>';
	$die .= '<p><a href="' . $path . '" class="button button-large">' . __( 'Create a Configuration File' ) . '</a></p>';

	wp_die( $die, __( 'WordPress &rsaquo; Error' ) );
}
