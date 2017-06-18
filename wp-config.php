<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the
 * installation. You don't have to use the web site, you can
 * copy this file to "wp-config.php" and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * MySQL settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://codex.wordpress.org/Editing_wp-config.php
 *
 * @package WordPress
 */

/**
 * Modified version of the default wp-config.php to configure the WordPress core 
 * content and plugin folder location. Ths custom configuration also will include the 
 * configure the site to use Azure database configuration if there is no wp-config-{WP_ENV}.php (see more in README)
 * 
 * @package    WordPress Starter
 * @version    0.0.1
 * @author     Seth Reid  <contact@sethreid.co.nz>
 */

// Get the WP_ENV variabl
if (getenv('WP_ENV') !== false) {
    // Filter non-alphabetical characters for security
    define('WP_ENV', preg_replace('/[^a-z]/', '', getenv('WP_ENV')));
} 

// Get hostname
if (isset($_SERVER['HTTP_X_FORWARDED_HOST']) && !empty($_SERVER['HTTP_X_FORWARDED_HOST'])) {
    $hostname = $_SERVER['HTTP_X_FORWARDED_HOST'];
} else {
    $hostname = $_SERVER['HTTP_HOST'];
}

// Get protocol
if ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') ||
    (!empty($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] === 'https')) {
    $protocol = 'https://';
} else {
    $protocol = 'http://';
}

// the base URL of the host
$hostUrl = $protocol . $hostname;

// move the content and plugins folders from outside the WordPress core folder
define('WP_CONTENT_DIR',  dirname(__FILE__) . '/content');
define('WP_CONTENT_URL', $hostUrl . '/content');
define('WP_PLUGIN_DIR', dirname(__FILE__) . '/plugins' );
define('WP_PLUGIN_URL', $hostUrl . '/plugins');

if(!defined('WP_ENV') ) {
    // If WP_ENV is not set then we assume we are in Azure
    // Below code from : https://blogs.msdn.microsoft.com/appserviceteam/2016/08/18/announcing-mysql-in-app-preview-for-web-apps/
    foreach ($_SERVER as $key => $value) {
        if (strpos($key, "MYSQLCONNSTR_localdb") !== 0) {
            continue;
        }
        
        $connectstr_dbhost = '';
        $connectstr_dbname = '';
        $connectstr_dbusername = '';
        $connectstr_dbpassword = '';
                
        $connectstr_dbhost = preg_replace("/^.*Data Source=(.+?);.*$/", "\\1", $value);
        $connectstr_dbname = preg_replace("/^.*Database=(.+?);.*$/", "\\1", $value);
        $connectstr_dbusername = preg_replace("/^.*User Id=(.+?);.*$/", "\\1", $value);
        $connectstr_dbpassword = preg_replace("/^.*Password=(.+?)$/", "\\1", $value);
    }

    // ** MySQL settings - You can get this info from your web host ** //
    /** The name of the database for WordPress */
    define('DB_NAME', $connectstr_dbname);

    /** MySQL database username */
    define('DB_USER', $connectstr_dbusername);

    /** MySQL database password */
    define('DB_PASSWORD', $connectstr_dbpassword);

    /** MySQL hostname : this contains the port number in this format host:port . Port is not 3306 when using this feature*/
    define('DB_HOST', $connectstr_dbhost);

    /** Assume production and set WP_DEBUG to false */
    define('WP_DEBUG', false);
}  else {
    // Otherwise use the config file based on the WP_ENV settings
    include dirname(__FILE__) . '/wp-config.' . WP_ENV . '.php';
}

// Common settings to all environments
include dirname(__FILE__) . '/wp-config.common.php';

/** Clean Up */
unset($hostname, $protocol, $hostUrl);

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/wp');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');