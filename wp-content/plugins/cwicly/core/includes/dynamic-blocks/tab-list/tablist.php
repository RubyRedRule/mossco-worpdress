<?php
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

function cwicly_tablist_register()
{
    register_block_type(__DIR__, array(
        'render_callback' => 'cc_tablist_render_callback',
    ));
}
add_action('init', 'cwicly_tablist_register');

function cc_tablist_render_callback($attributes, $content, $block)
{
    if (isset($attributes['effectsTiltControl']) && $attributes['effectsTiltControl']) {
        wp_enqueue_script('cc-tilter', CWICLY_DIR_URL . 'assets/js/tilter.js', null, CWICLY_VERSION, true);
    }
    if (!is_admin()) {
        wp_enqueue_script('cc-tab', CWICLY_DIR_URL . 'assets/js/cc-tab.min.js', null, CWICLY_VERSION, true);
    }

    $hideLoggedin = cc_hide_logged_in($attributes);
    $hideGuest = cc_hide_guest($attributes);

    if ($hideGuest && $hideLoggedin && cc_conditions_maker($attributes, $block)) {
        return cc_render($content, $attributes, $block);
    }
}
