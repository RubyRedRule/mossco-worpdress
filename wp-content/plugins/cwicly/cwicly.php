<?php
/*
 * Plugin Name:       Cwicly
 * Plugin URI:        https://cwicly.com/
 * Description:       Take Gutenberg by WordPress to the next level. Design & create professional responsive websites in minutes.
 * Version:           1.2.9.5.4
 * Author:            Cwicly
 * Author URI: https://cwicly.com/
 * Text Domain:       cwicly
 * Requires at least: 5.8
 * Tested up to:       6.1.1
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 */

// Exit if accessed directly.
if (!defined('ABSPATH')) {
    exit;
}

// Define Version
define('CWICLY_VERSION', '1.2.9.5.4');

// Define WordPress
define('WORDPRESS_VERSION', get_bloginfo('version'));

// Define Version
define('CWICLY_THEME_VERSION', '1.0.3');

// Define Beta
define('CWICLY_BETA', false);

// Define Directory URL
define('CWICLY_DIR_URL', plugin_dir_url(__FILE__));

// Define Physical Path
define('CWICLY_DIR_PATH', plugin_dir_path(__FILE__));

define('CWICLY_URL', plugin_dir_url(__FILE__) . '');

define('CWICLY_FILE', __FILE__);

define('CWICLY_LICENSE_PAGE', 'cwicly');

define('CWICLY_ITEM_NAME', 'Cwicly');

define('CC_STORE_URL', 'https://cwicly.com');

define('CC_PLUGIN_ID', 73);

define('CC_THEME_ID', 71);

define('CC_CLASSES', get_option('cwicly_classes_add'));

define('CC_UPLOAD_URL', cc_fix_ssl_upload_url());

function cc_fix_ssl_upload_url()
{
    $url = wp_upload_dir()['baseurl'];
    if (is_ssl()) {
        $url = str_replace('http://', 'https://', $url);
    }
    return $url;
}

// Test to see if WooCommerce is active (including network activated).
$plugin_path = trailingslashit(WP_PLUGIN_DIR) . 'woocommerce/woocommerce.php';

if (
    in_array($plugin_path, wp_get_active_and_valid_plugins())
) {
    define('CC_WOOCOMMERCE', true);
} else {
    define('CC_WOOCOMMERCE', false);
}

function cwicly_set_script_translations()
{
    load_plugin_textdomain('cwicly', false, dirname(plugin_basename(__FILE__)) . '/languages');
    wp_register_script('cwicly_editor_blocks', CWICLY_DIR_URL . 'build/index.js', array('wp-i18n', 'wp-blocks', 'wp-i18n', 'wp-element', 'wp-edit-post', 'wp-editor', 'wp-api', 'wp-data', 'wp-block-editor', 'wp-core-data'), CWICLY_VERSION, true);
    wp_set_script_translations('cwicly_editor_blocks', 'cwicly', plugin_dir_path(__FILE__) . 'languages');
}
add_action('init', 'cwicly_set_script_translations');

if (!class_exists('Cwicly_Plugin_Updater')) {
    include CWICLY_DIR_PATH . '/core/includes/plugin_updater.php';
}

// Define path and URL to the ACF plugin.
define('MY_ACF_PATH', plugin_dir_path(__FILE__) . 'core/includes/acf/');
define('MY_ACF_URL', plugin_dir_url(__FILE__) . 'core/includes/acf/');

// Include Notices File
require_once CWICLY_DIR_PATH . 'core/initial-start.php'; // Initial Cwicly Data

// Version Check & Include Core
if (!version_compare(PHP_VERSION, '5.4', '>=')) {
    add_action('admin_notices', array('CWICLY_INITIAL_START', 'php_error_notice')); // PHP Version Check
} elseif (!version_compare(get_bloginfo('version'), '5.6', '>=')) {
    add_action('admin_notices', array('CWICLY_INITIAL_START', 'wordpress_error_notice')); // WordPress Version Check
} else {
    require_once CWICLY_DIR_PATH . 'core/includes/dynamic-blocks/maker.php'; // Load Cwicly Blocks
    require_once CWICLY_DIR_PATH . 'core/includes/cc-ground.php'; // Main Cwicly Driver
    if (file_exists(CWICLY_DIR_PATH . 'license-data.php')) {
        require_once CWICLY_DIR_PATH . 'license-data.php'; // Load Cwicly License DATA
    }
    require_once CWICLY_DIR_PATH . 'core/includes/acf.php'; // Load ACF Options
    require_once CWICLY_DIR_PATH . 'core/includes/cc-settings.php'; // Load Cwicly Settings
    require_once CWICLY_DIR_PATH . 'core/includes/theme-maker.php'; // Load Cwicly Themer
    require_once CWICLY_DIR_PATH . 'core/includes/dynamic/maker.php'; // Load Cwicly Blocks
    require_once CWICLY_DIR_PATH . 'core/includes/maker.php'; // Load Cwicly Maker
}

/**
 * Version check.
 */
function cc_update_db_check()
{
    if (get_option('cwicly_db_version') != CWICLY_VERSION) {
        $regenerateHTML = get_option('cwicly_regenerate_html');

        if ($regenerateHTML !== 'true') {
            update_option('cwicly_regenerate_html', 'true');
            $regenerateHTML = 'true';
        }

        if (version_compare(get_option('cwicly_db_version'), '1.2.9.5', '<') && $regenerateHTML !== 'true') {
            update_option('cwicly_regenerate_html', 'true');
        }

        update_option('cwicly_db_version', CWICLY_VERSION);
    }
}
add_action('plugins_loaded', 'cc_update_db_check');
