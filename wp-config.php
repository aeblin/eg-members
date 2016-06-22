<?php
ini_set( 'display_errors', 0 );

// ==============
// MySQL settings
// ==============
// The name of the database for WordPress
define('DB_NAME', 'wpmembers');
// MySQL database username
define('DB_USER', 'root');
// MySQL database password
define('DB_PASSWORD', 'root');
// MySQL hostname
define('DB_HOST', 'localhost');
// Database Charset to use in creating database tables
define('DB_CHARSET', 'utf8');
// The Database Collate type. Don't change this if in doubt.
define('DB_COLLATE', '');

ini_set('display_errors', E_ALL);
define('WP_DEBUG_DISPLAY', true);
define('WP_DEBUG', true);

// Auth Keys and Salts
define('AUTH_KEY',         '^2zmM?|t-a>b-e|&.e5I?q=^xg[3?m^R/>Qp,-Ia&hlT F/#&I@xkN=Eo`MI3eOI');
define('SECURE_AUTH_KEY',  '^2zmM?|t-a>b-e|&.e5I?q=^xg[3?m^R/>Qp,-Ia&hlT F/#&I@xkN=Eo`MI3eOI');
define('LOGGED_IN_KEY',    '^2zmM?|t-a>b-e|&.e5I?q=^xg[3?m^R/>Qp,-Ia&hlT F/#&I@xkN=Eo`MI3eOI');
define('NONCE_KEY',        '^2zmM?|t-a>b-e|&.e5I?q=^xg[3?m^R/>Qp,-Ia&hlT F/#&I@xkN=Eo`MI3eOI');
define('AUTH_SALT',        '^2zmM?|t-a>b-e|&.e5I?q=^xg[3?m^R/>Qp,-Ia&hlT F/#&I@xkN=Eo`MI3eOI');
define('SECURE_AUTH_SALT', '^2zmM?|t-a>b-e|&.e5I?q=^xg[3?m^R/>Qp,-Ia&hlT F/#&I@xkN=Eo`MI3eOI');
define('LOGGED_IN_SALT',   '^2zmM?|t-a>b-e|&.e5I?q=^xg[3?m^R/>Qp,-Ia&hlT F/#&I@xkN=Eo`MI3eOI');
define('NONCE_SALT',       '^2zmM?|t-a>b-e|&.e5I?q=^xg[3?m^R/>Qp,-Ia&hlT F/#&I@xkN=Eo`MI3eOI');

// ========================
// Custom Content Directory
// ========================
define( 'WP_CONTENT_DIR', dirname( __FILE__ ) . '/content' );
define( 'WP_CONTENT_URL', 'http://' . $_SERVER['HTTP_HOST'] . '/content' );

// ================================================
// You almost certainly do not want to change these
// ================================================
define( 'DB_CHARSET', 'utf8' );
define( 'DB_COLLATE', '' );

// ================================
// Language
// Leave blank for American English
// ================================
define( 'WPLANG', '' );

// ======================
// Hide errors by default
// ======================
define( 'WP_DEBUG_DISPLAY', false );
define( 'WP_DEBUG', false );

// =========================
// Disable automatic updates
// =========================
define( 'AUTOMATIC_UPDATER_DISABLED', false );

// =======================
// Load Wordpress Settings
// =======================
$table_prefix = 'wp_';

// ===================
// Bootstrap WordPress
// ===================
if ( ! defined ( 'ABSPATH' ) ) {
	define ( 'ABSPATH', dirname( __FILE__ ) . '/wp/' );
}
require_once( ABSPATH . 'wp-settings.php' );