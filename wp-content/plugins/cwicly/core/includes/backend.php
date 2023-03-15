<?php
namespace Cwicly;

if (!defined('ABSPATH')) {
    exit;
}
// Exit if accessed directly

class Backend
{
    public function __construct()
    {
        add_action('enqueue_block_editor_assets', array($this, 'enqueue_block_editor_assets'));
    }

    public static function enqueue_block_editor_assets()
    {
        // LOAD CWICLY JS BLOCKS
        wp_enqueue_script('cwicly_editor_blocks', CWICLY_DIR_URL . 'build/index.js', array('wp-i18n', 'wp-blocks', 'wp-core-data', 'wp-i18n', 'wp-element', 'wp-editor', 'wp-api'), CWICLY_VERSION, true);
        // LOAD CWICLY JS BLOCKS

        // LOAD CWICLY CSS BLOCKS
        wp_enqueue_style('cwicly_blocks_editor', CWICLY_DIR_URL . 'build/index.css', array(), filemtime(CWICLY_DIR_PATH . 'build/index.css'));
        // LOAD CWICLY CSS BLOCKS

        // LOAD CWICLY NORMALISER BLOCKS
        $url = apply_filters('cc_normaliser_frontend', CWICLY_DIR_URL . 'assets/css/base.css');
        wp_enqueue_style('CCnorm', $url, array(), CWICLY_VERSION);
        // LOAD CWICLY NORMALISER BLOCKS

        wp_enqueue_code_editor(array('type' => 'text/html'));

        // LOAD CSS FOR CODE EDITOR
        wp_enqueue_style('material', CWICLY_DIR_URL . 'core/assets/css/material.css');
        // LOAD CSS FOR CODE EDITOR

        // LOAD JQUERY FOR REMAINING JQUERY
        wp_enqueue_script('jquery');
        wp_enqueue_script('jquery-ui-resizable', false, array('jquery'));
        wp_enqueue_script("jquery-ui-draggable", false, array('jquery'));
        // LOAD JQUERY FOR REMAINING JQUERY

        $cwiclyOptimise = get_option('cwicly_optimise');
        $cwiclyDefaults = 'false';
        if (isset($cwiclyOptimise['cwiclyDefaults']) && $cwiclyOptimise['cwiclyDefaults'] === 'true') {
            $cwiclyDefaults = 'true';
        }
        $removeIDsClasses = 'false';
        if (isset($cwiclyOptimise['removeIDsClasses']) && $cwiclyOptimise['removeIDsClasses'] === 'true') {
            $removeIDsClasses = 'true';
        }

        wp_localize_script(
            'cwicly_editor_blocks',
            'cwicly_info',
            array(
                'plugin' => CWICLY_DIR_URL,
                'url' => get_home_url(),
                'uploads' => CC_UPLOAD_URL,
                'admin' => get_admin_url(),
                'version' => CWICLY_VERSION,
                'wordpress' => WORDPRESS_VERSION,
                'woocommerce' => CC_WOOCOMMERCE,
                'scss' => get_option("cwicly_scss_compiler"),
                'currentuser' => get_current_user_id(),
                'userrole' => Helpers::get_current_user_roles(),
                'usereditor' => get_option("cwicly_role_editor"),
                'cwiclyDefaults' => $cwiclyDefaults,
                'restBase' => untrailingslashit(rest_url()),
                'nonce' => wp_create_nonce('wp_rest'),
                'removeIDsClasses' => $removeIDsClasses,
                'theme' => get_stylesheet(),
            )
        );

        // LOAD GOOGLE MAPS WHEN API KEY
        $api_key = get_option('cwicly_gmap');
        if ($api_key) {
            wp_enqueue_script('cc-gmap-places', 'https://maps.googleapis.com/maps/api/js?key=' . $api_key . '&libraries=places&callback=Function.prototype', null, CWICLY_VERSION);
        }
        // LOAD GOOGLE MAPS WHEN API KEY
    }
}
