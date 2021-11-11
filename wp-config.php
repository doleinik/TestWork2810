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
 * * MySQL settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'work2' );

/** MySQL database username */
define( 'DB_USER', 'root' );

/** MySQL database password */
define( 'DB_PASSWORD', '' );

/** MySQL hostname */
define( 'DB_HOST', 'localhost' );

/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

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
define( 'AUTH_KEY',         'UH^NN#]H*a(k-KM^hAN-fygfgRk(S%=o[!rDu-xsVvm{d_XlR_<m-3g#k3CkdyB?' );
define( 'SECURE_AUTH_KEY',  'Y!QxJy$-8-y(izhF[*2h#:]Y@BnwWD4|SHqGRC!5kV{S9cA6p5Q O&[-U~b)m1;^' );
define( 'LOGGED_IN_KEY',    'b p/~)q9z+K =:Fq.Rx)/;2ara~k+YHdH1eG60aXExI;~H/({G4ym[81}<w4~;+-' );
define( 'NONCE_KEY',        '0BbM<lNs+65|r !x/!$Olv_;JTe(z8Y[jMT6nwiKtRj`Rkd|/_eHUou0k5w~I=X!' );
define( 'AUTH_SALT',        '+^J(^#5M/${sGz@ijhUHp85{C91{@fH`_IBL<WO=-#g-Y{^KARkJ f&u88P,waDn' );
define( 'SECURE_AUTH_SALT', '|*-16^@v20V`Hurh`>ciJu%H~OJi$V/!k_*lN@Z`hrHD(+&|*/Le[B1l[!-#p3RO' );
define( 'LOGGED_IN_SALT',   '&.@Q3/:d=Ee[BRu7RG,<+gpU<?cb%{.oZA+ziSd]>p18&@yq!U;(3|zc[`^!5f.t' );
define( 'NONCE_SALT',       'tA :G`Wl~#eP7HJd.c`-^?1ZRlG_mHmB`mB6[%n=O&iu#(*U[@l?}Diwt0xrL o4' );

/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = '_wp';

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
define( 'WP_DEBUG', true );

/* Add any custom values between this line and the "stop editing" line. */



/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
