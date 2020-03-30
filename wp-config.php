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

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'wlad_db1' );

/** MySQL database username */
define( 'DB_USER', 'wlad_db1' );

/** MySQL database password */
define( 'DB_PASSWORD', 'q&TGt@2YL85y' );

/** MySQL hostname */
define( 'DB_HOST', 'localhost' );

/** Database Charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

/** The Database Collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         '{1se]z^JfFw#2q*]v[p9oYA(_XGS|C*KsztM4W1NI9qo $uQn+LIgf!@;6*|&&ME' );
define( 'SECURE_AUTH_KEY',  'aj%_v%| uxMSgpJJJk7p$[] +6.xR3^V1Wyoh_Q4XmxUcCBOXb:sds9YSFT<F]v@' );
define( 'LOGGED_IN_KEY',    ',eujFP+;#bL>~A$22k,[Ipdj?j<oGU1glooy8Ifc5$eYmsJ~I#@j8o$XiyA Cf?f' );
define( 'NONCE_KEY',        '[eP@pc76$|55,n$96-5jMJE1v]-L;$`^`[ru;;4[iILPBJI-fW,h(O#HFL6met*q' );
define( 'AUTH_SALT',        'oz~7u|F|Hrg7O*Mz`ZOa7]=T6,m[.87<Y{&`HA( d32Y_isr.7P&SO`=A$>2;8F5' );
define( 'SECURE_AUTH_SALT', 'K2pdlB^#*fW=7Ks-8%P^([58v5LJwl7$r/F+(Z^38Du*~P.r*fuzj]/gOtrhxE*@' );
define( 'LOGGED_IN_SALT',   'spsFFDH.~Y3G#`@9wmkMN?A<t6>]^|7cO&W{dZ;gXl_kb*FbhX``D:B#5BteyyB ' );
define( 'NONCE_SALT',       ' Nr8Lk{aGtGp/0m(FqQ_,8pw4ATZJJa,Z8]?yD%lNF9A9PbE`_EsMYYn%+-]L0=Z' );

/**#@-*/

/**
 * WordPress Database Table prefix.
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
 * visit the Codex.
 *
 * @link https://codex.wordpress.org/Debugging_in_WordPress
 */
define( 'WP_DEBUG', false );

/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', dirname( __FILE__ ) . '/' );
}

/** Sets up WordPress vars and included files. */
require_once( ABSPATH . 'wp-settings.php' );

define(FS_METHOD , 'direct' );
