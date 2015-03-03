<?php
/**
 * The base configurations of the WordPress.
 *
 * This file has the following configurations: MySQL settings, Table Prefix,
 * Secret Keys, WordPress Language, and ABSPATH. You can find more information
 * by visiting {@link http://codex.wordpress.org/Editing_wp-config.php Editing
 * wp-config.php} Codex page. You can get the MySQL settings from your web host.
 *
 * This file is used by the wp-config.php creation script during the
 * installation. You don't have to use the web site, you can just copy this file
 * to "wp-config.php" and fill in the values.
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME',       'blogs'                             );
define('DB_USER',       @ini_get('mysql.default_user')      );
define('DB_PASSWORD',   @ini_get('mysql.default_password')  );
define('DB_HOST',       @ini_get('mysql.default_host')      );
define('DB_CHARSET',    'utf8'                              );
define('DB_COLLATE',    ''                                  );


/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */

define('AUTH_KEY',          '<A({u+#FjizP4V[]Bo7$O9dL^au>51jj/6Tm7XyOx{r-i|NQ{-,Xzzb@ )2*Dz,f');
define('AUTH_SALT',         'ZR2/bE2a0vG;b*:A-#[1{&q%BJVJ+:El*8*zQY}8=^2;zwm4]=nZ%]yH.a|c<jpJ');
define('LOGGED_IN_KEY',     'T?P+V_zPIY4|uONE3<)(`:6[P6~sPBmO^S0|)=ank}+8G0LHF.meicZGf:3#-LM!');
define('LOGGED_IN_SALT',    'dcH QH1np|FSB3e;tEe]muS$B+g5rX=/sg$T &_|OBpsH~g $F60to<-Dml0##V+');
define('NONCE_KEY',         '/zDUw_s ^6RJUIhbW&~[.1P#rve@Li:uO<Ai[=Z8isSgoWb+1x}woXb)HWE<Jt}x');
define('NONCE_SALT',        ')fr&Y!(ZnLQZ,-SaK?Ui-@-l)%I4r8.JAEPPTLd`SU0Z(.H~@H9i%7!h])H1z2(u');
define('SECURE_AUTH_KEY',   ',`_$)R &B+V&;IdM=W}Wg$p|]^phz>qYdGr-(;O$<<+V}glL`hCC^b|-;/n?m%x#');
define('SECURE_AUTH_SALT',  'zPJninTiFt-[mNBwi}Vj<`+nPR;,jnH-7=!^0~!R#).(1x@ W<LIW44|%b5YCI?%');

define('WP_ALLOW_REPAIR', true);
/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each a unique
 * prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 */
define('WP_DEBUG', false);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
