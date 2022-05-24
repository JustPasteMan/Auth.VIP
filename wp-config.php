<?php
define( 'WP_CACHE', true );







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

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'authfldd_wp888' );

/** Database username */
define( 'DB_USER', 'authfldd_wp888' );

/** Database password */
define( 'DB_PASSWORD', 'CSo-2m.81BAp-)' );

/** Database hostname */
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
define( 'AUTH_KEY',         'lyjx5jjjovpvegdjtbkrxzwz8sbulid3wq4bw64lvgybbpqb1g6blhocoaeb5und' );
define( 'SECURE_AUTH_KEY',  'in0zax0elf4gis0k5umhxucjbzhlh0c9j50xt6w8j8adcwzmmqdtus3t3ah33o1j' );
define( 'LOGGED_IN_KEY',    '1hwc2uidovyb6h8xgjn64uyr6uattbteugsxhqstvykzysl6d3evjcypkskcdjiw' );
define( 'NONCE_KEY',        'yvdzxtazsvueqx0e07z238cipmrehftwzljg0lakpzrgzq4g5olx4oacioc0f1nb' );
define( 'AUTH_SALT',        'tyxgxo0jzdipt3qzujd23mvc09dne7ti8ywewikqslrf7csbwxj8vd9qzhi2ve3j' );
define( 'SECURE_AUTH_SALT', 'skqeoj9lwbteerq1r6hqsmxh1sec31keeiayienoa5z7co6bdghsgnroi2atavd0' );
define( 'LOGGED_IN_SALT',   'tbhq83dtuvdpm0aflpsuursmhycg4lt1qpkpfdx1xg73i8rfwjxekf04f75v93zu' );
define( 'NONCE_SALT',       'm54opcayvrjksjshhujxvowr2oih2lnyzsiahjyvhpnsieteva1j4y3zqanblhlb' );

/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wpjp_';

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



/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
