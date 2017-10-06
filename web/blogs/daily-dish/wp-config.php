<?php
/**
 * The base configurations of the WordPress.
 *
 **************************************************************************
 * Do not try to create this file manually. Read the README.txt and run the
 * web installer.
 **************************************************************************
 *
 * This file has the following configurations: MySQL settings, Table Prefix,
 * Secret Keys, WordPress Language, and ABSPATH.
 *
 * This file is used by the wp-config.php creation script during the
 * installation.
 *
 * @package WordPress
 */

/**
 * MySQL settings
 */

/*
 * https://markjaquith.wordpress.com/2011/06/24/wordpress-local-dev-tips/
 */
if (file_exists(dirname(__FILE__) . '/local-config.php')) {
  include (dirname(__FILE__) . '/local-config.php');
}
else {
  define('DB_NAME',     'blogs'         );
  define('DB_USER',     'root'          );
  define('DB_PASSWORD', 'rd112358'      );
  define('DB_HOST',     '10.223.241.120');
}

define('DB_CHARSET',  'utf8');
define('DB_COLLATE',  '');

define('WP_HOME',   'http://www.betterrecipes.com/blogs/daily-dish');
define('WP_SITEURL','http://www.betterrecipes.com/blogs/daily-dish');


$table_prefix = 'wp_';


/**
 * Constants
 */
define('WPLANG',                ''                      );
define('DOMAIN_CURRENT_SITE',   $_SERVER['HTTP_HOST']   );
define('BLOGID_CURRENT_SITE',   '1'                     );
define('PATH_CURRENT_SITE',     '/blogs/'               );
define('WP_DEBUG',              false                   );
define('WP_ALLOW_MULTISITE',    false                    );
define('WP_USE_MULTIPLE_DB',    false                   );
define('SUBDOMAIN_INSTALL',     false                   );
$base = PATH_CURRENT_SITE;

/**
 * WP_HOME and WP_SITEURL constants are ignored with WP multisite :(
 */
// $rd_http_scheme                 = @$_SERVER['HTTPS'] ? 'https://' : 'http://';
// $rd_blog_path                   = preg_match('/(\/blogs\/[^\/]+)/', $_SERVER['REQUEST_URI'], $m) ? $m[1] : '/blogs';
// define('WP_HOME',               $rd_http_scheme . $_SERVER['HTTP_HOST'] . $rd_blog_path );
// define('WP_SITEURL',            $rd_http_scheme . (@$_SERVER['X_HTTP_FORWARDED_HOST'] ? $_SERVER['X_HTTP_FORWARDED_HOST'] : $_SERVER['HTTP_HOST']) . $rd_blog_path );


/**
 * SolveMedia
 */
if ( strpos($_SERVER['HTTP_HOST'], '.resolute.com') !== false ) {
    // Development/resolute.com Keys
    define('SOLVEMEDIA_CHAL_KEY', '-UiGuJh36qy9xacVg5VB8qBGun9ZnQ3g');
    define('SOLVEMEDIA_PRIV_KEY', 'yKKkq1jO7-fSXPFl6szWx-DdESMMvOGP');
    define('SOLVEMEDIA_HASH_KEY', '3nBAcdUnnIT6zclTwsZWC4jw0HOkkKI-');
} else {
    // Production/LHJ Keys
    define('SOLVEMEDIA_CHAL_KEY', 'tTVskhAdf7BVjtjrU9o8IrR-4nhE4yAC');
    define('SOLVEMEDIA_PRIV_KEY', '7K6MCT7xApTtvVcvp22lw0G6CzEK2cO.');
    define('SOLVEMEDIA_HASH_KEY', 'NQuwFmKod42qhW1iqQjngSYb0GQZ6W0H');
}

/**
 * Authentication Unique Keys.
 *
 * You can generate these using the {@link http://api.wordpress.org/secret-key/1.1/ WordPress.org secret-key service}
 *
 */

define('AUTH_KEY',          '<A({u+#FjizP4V[]Bo7$O9dL^au>51jj/6Tm7XyOx{r-i|NQ{-,Xzzb@ )2*Dz,f');
define('AUTH_SALT',         'ZR2/bE2a0vG;b*:A-#[1{&q%BJVJ+:El*8*zQY}8=^2;zwm4]=nZ%]yH.a|c<jpJ');
define('LOGGED_IN_KEY',     'T?P+V_zPIY4|uONE3<)(`:6[P6~sPBmO^S0|)=ank}+8G0LHF.meicZGf:3#-LM!');
define('LOGGED_IN_SALT',    'dcH QH1np|FSB3e;tEe]muS$B+g5rX=/sg$T &_|OBpsH~g $F60to<-Dml0##V+');
define('NONCE_KEY',         '/zDUw_s ^6RJUIhbW&~[.1P#rve@Li:uO<Ai[=Z8isSgoWb+1x}woXb)HWE<Jt}x');
define('NONCE_SALT',        ')fr&Y!(ZnLQZ,-SaK?Ui-@-l)%I4r8.JAEPPTLd`SU0Z(.H~@H9i%7!h])H1z2(u');
define('SECURE_AUTH_KEY',   ',`_$)R &B+V&;IdM=W}Wg$p|]^phz>qYdGr-(;O$<<+V}glL`hCC^b|-;/n?m%x#');
define('SECURE_AUTH_SALT',  'zPJninTiFt-[mNBwi}Vj<`+nPR;,jnH-7=!^0~!R#).(1x@ W<LIW44|%b5YCI?%');


/** double check $base **/
if( $base == 'BASE' )
    die( 'Problem in wp-config.php - $base is set to BASE when it should be the path like "/" or "/blogs/"! Please fix it!' );


/** WordPress absolute path to the Wordpress directory. **/
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Define the RD_LIB_PATH for require/includes **/
if ( !defined('RD_LIB_PATH') )
    define('RD_LIB_PATH', ABSPATH . 'lib/');

/** Sets up WordPress vars and included files. **/
require_once(ABSPATH . 'wp-settings.php');


