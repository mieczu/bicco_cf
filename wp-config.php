<?php
/** 
 * The base configurations of the WordPress.
 *
 * This file has the following configurations: MySQL settings, Table Prefix,
 * Secret Keys, WordPress Language, and ABSPATH. You can find more information by
 * visiting {@link http://codex.wordpress.org/Editing_wp-config.php Editing
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
define('DB_NAME', 'c92aps1');

/** MySQL database username */
define('DB_USER', 'c92aps1');

/** MySQL database password */
define('DB_PASSWORD', 'E7ded7eeccd3f770');

/** MySQL hostname */
define('DB_HOST', 'localhost:3306');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8');

/** The Database Collate type. Don't change this if in doubt. */
define('DB_COLLATE', '');

/**#@+
 * Authentication Unique Keys.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link http://api.wordpress.org/secret-key/1.1/ WordPress.org secret-key service}
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         'r5R(FJ#h6zwQmgZlR1R17OPfLR@1^0x03eokxD*AK)nZ5jCwVk9TIsxE^^rn4KYk');
define('SECURE_AUTH_KEY',  'Ar8017LxW0AAMwiX473iTUDHSix3o#nzIed@!dtexFow9Mar3Y9bSP2MNzWXmp8l');
define('LOGGED_IN_KEY',    'QAQFFPH6hu%KqK5D%%C*ji#fWhStYn10M(P6ntPn8)qTxsrDP2rpeq#WVG%8vzgN');
define('NONCE_KEY',        'Uona4YLqV9$HL@)rfQnA$a&LBZeEp)ETW6(x!hT2FMY80qbiGxa9HKxu$zwW&%r*');
define('AUTH_SALT',        '@rSh8B^I3p9Ni19)v5nYB%V!LU(WoPKsynY4kgXDy9MR!aA3gJTct1D20tXEoXhA');
define('SECURE_AUTH_SALT', '!c@USgW*f3(A(Aps1SdWx1tQ5dm5U$xU#ehZFZ#1SZDS&&LtK4)n7f4DXB#XCzW6');
define('LOGGED_IN_SALT',   'Zr%3ErRxJr!mPzLvCZ!dHlG6g0!s83Yb^wYNXMDeP%!*D67jwt6leJ5Dlp!fvaqn');
define('NONCE_SALT',       'A^l)1TbyUleH$2uKzUSw1yObk9E5Tmx74A*!Tx35^%aWPF0)EhtK6n5Nuseet7gE');
/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each a unique
 * prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

/**
 * WordPress Localized Language, defaults to English.
 *
 * Change this to localize WordPress.  A corresponding MO file for the chosen
 * language must be installed to wp-content/languages. For example, install
 * de.mo to wp-content/languages and set WPLANG to 'de' to enable German
 * language support.
 */
define ('WPLANG', 'pl_PL');

define ('FS_METHOD', 'direct');

define('WP_DEBUG', true);
define( 'WP_DEBUG_LOG', true );
define( 'WP_DEBUG_DISPLAY', false );
/* That's all, stop editing! Happy blogging. */

/** WordPress absolute path to the Wordpress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');


define( 'AUTOMATIC_UPDATER_DISABLED', true );




?>
