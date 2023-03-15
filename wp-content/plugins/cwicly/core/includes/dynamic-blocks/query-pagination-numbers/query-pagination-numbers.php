<?php
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

function cwicly_querypaginationnumbers_register()
{
    register_block_type(__DIR__, array(
        'render_callback' => 'cc_query_pagination_numbers_render_callback',
    ));
}
add_action('init', 'cwicly_querypaginationnumbers_register');

function cc_query_pagination_numbers_render_callback($attributes, $content, $block)
{
    $hideLoggedin = cc_hide_logged_in($attributes);
    $hideGuest = cc_hide_guest($attributes);

    if (isset($attributes['effectsTiltControl']) && $attributes['effectsTiltControl']) {
        wp_enqueue_script('cc-tilter', CWICLY_DIR_URL . 'assets/js/tilter.js', null, CWICLY_VERSION, true);
    }

    if ($hideGuest && $hideLoggedin && cc_conditions_maker($attributes, $block)) {
        return cc_render($content, $attributes, $block);
    }
}
