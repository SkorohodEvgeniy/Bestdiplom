<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the web site, you can copy this file to "wp-config.php"
 * and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * Database settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */
define( 'WP_MEMORY_LIMIT', '256M' );
// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'admin_zachete' );

/** Database username */
define( 'DB_USER', 'admin_zachete' );

/** Database password */
define( 'DB_PASSWORD', 'TMZTvusfBx' );

/** Database hostname */
define( 'DB_HOST', 'localhost' );

/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8' );

/** The database collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**#@+
 * Authentication unique keys and salts.
 *
 * Change these to different unique phrases! You can generate these using
 * the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}.
 *
 * You can change these at any point in time to invalidate all existing cookies.
 * This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         '0 r9gw-hQ- /Mx]Na%aia^R%;)De#1UJU~gaEeABgu=>*F(=;K?}SE:C6<9*gG,G');
define('SECURE_AUTH_KEY',  'HQnWXC*;d-Nc`uE|JGY*;.TMwp1ZR0B|+1VH-sRG^[__k9NsOv:]>TN(+VtJgqER');
define('LOGGED_IN_KEY',    'DHZt]|l9ZIj*YK-_{E2R][g9@c+o0=:xS0*sqQ3+NzeWQ;h5:DE[hqK)G7m}.fXj');
define('NONCE_KEY',        'E;-%^N*^uWT7aEe(t;7HMc]4jcIc)T(}N=+F.`7|M*l:(Sc2+4-sGN0-Y=UK[f{O');
define('AUTH_SALT',        '~enDLD3@7Fp+,sxp[Fw+HsWcryacqhEHv^ g .>uf `qpuV!qouEseze~R$igR| ');
define('SECURE_AUTH_SALT', 'gN]G$ckf(tU.5JxTj3Gnxca=</ <|ILGTi*B>vPewEDfDqs9Zt}+m_k_+_^[I#Z]');
define('LOGGED_IN_SALT',   '|y%jIc3B|&.a+eA?s-P[u_R`G>WRiz:?JC*%k+[&x-5|q.Y]?-p -arVkrBHk*]!');
define('NONCE_SALT',       'vKKW_|ASA=V<Z5Ht p8?7]Unnw<|7w:N,6<-9S<^lG<><~{kcZ*9^6AkZ&}[0MFD');

/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the documentation.
 *
 * @link https://wordpress.org/support/article/debugging-in-wordpress/
 */
define( 'WP_DEBUG', false );

/* Add any custom values between this line and the "stop editing" line. */
@ini_set( 'upload_max_filesize' , '128M' );
@ini_set( 'post_max_size', '128M');
@ini_set( 'memory_limit', '256M' );
@ini_set( 'max_execution_time', '300' );
@ini_set( 'max_input_time', '300' );


/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
