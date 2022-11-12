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

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'torob' );

/** Database username */
define( 'DB_USER', 'root' );

/** Database password */
define( 'DB_PASSWORD', '' );

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
define( 'AUTH_KEY',         'cns*[J q0XO&RFd=|k![{PWLwBrJFBVcD$!pQ0>&Nn]p((1%3(]a6c6&Axy`D)e7' );
define( 'SECURE_AUTH_KEY',  '8pl}a*O)7&.Ga}|SKXvrm)~>?FYvB#Dv4[=K7fjr{0[Soq/U<G>yzgP_ge>e3MJv' );
define( 'LOGGED_IN_KEY',    'pGLuZg989#EV>6*^eACkow8W9jr2mf|g#~7c/(+U9z(H7I?:!Hq-+HC}Q9;X!P/9' );
define( 'NONCE_KEY',        '!Sr3bt^b0PqnH._m*7P;QwxAKPFG1K2XPEgFc5o 0?UQtvE5e]pGw(qr92GYA(; ' );
define( 'AUTH_SALT',        '?l?/>g0<yC];b95Z0*ydG/E ^9sSo^U>~p5KgG}>9+W4X#j$Vyk~K-6pPf&o2n51' );
define( 'SECURE_AUTH_SALT', 'C(Gz1NzAr7%br1d2>_[LzJg/pmh{G} %MOz,,}rR&==q*1 zlWb+36Sok#U7O]iv' );
define( 'LOGGED_IN_SALT',   'pe*[dI>3_wcZQNJw{K/`O9$iA$G_ n0vG2,ts&^|QCZtpyAFwe#wS5rlNRUVKmS ' );
define( 'NONCE_SALT',       '1)l]w w~)$-w#yT9#?aqTHDS_P;%+|+-V!_e^ZfC_!jVg]Qu1_/z8ow&oZ2v9/zD' );

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



/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
