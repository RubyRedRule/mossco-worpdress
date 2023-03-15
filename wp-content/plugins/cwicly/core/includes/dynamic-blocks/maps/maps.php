<?php
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

function cwicly_maps_register()
{
    // wp_register_script('Maps', CWICLY_DIR_URL . 'assets/js/maps.js', null, false, false);
    register_block_type(__DIR__, array(
        'render_callback' => 'cc_maps_render_callback',
    ));
}
add_action('init', 'cwicly_maps_register');

function cc_maps_render_callback($attributes, $content, $block)
{
    $api_key = get_option('cwicly_gmap');
    if ($api_key && !is_admin()) {
        wp_enqueue_script('Maps', CWICLY_DIR_URL . 'assets/js/maps.js', null, false, false);
        wp_enqueue_script('CCgmap', 'https://maps.googleapis.com/maps/api/js?key=' . $api_key . '&callback=Function.prototype', null, false, false);
    }
    if (isset($attributes['effectsTiltControl']) && $attributes['effectsTiltControl']) {
        wp_enqueue_script('cc-tilter', CWICLY_DIR_URL . 'assets/js/tilter.js', null, CWICLY_VERSION, true);
    }

    $hideLoggedin = cc_hide_logged_in($attributes);
    $hideGuest = cc_hide_guest($attributes);

    if ($hideGuest && $hideLoggedin && cc_conditions_maker($attributes, $block)) {
        return cc_render($content, $attributes, $block);
    }
}
