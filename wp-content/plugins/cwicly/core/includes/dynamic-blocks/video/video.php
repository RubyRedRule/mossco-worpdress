<?php
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

function cwicly_video_register()
{
    register_block_type(__DIR__, array(
        'render_callback' => 'cc_video_render_callback',
    ));
}
add_action('init', 'cwicly_video_register');

function cc_video_render_callback($attributes, $content, $block)
{
    $hideLoggedin = cc_hide_logged_in($attributes);
    $hideGuest = cc_hide_guest($attributes);

    if (!is_admin()) {
        wp_enqueue_script('cc-video', CWICLY_DIR_URL . 'assets/js/cc-video.min.js', null, CWICLY_VERSION, true);
    }

    if (isset($attributes['effectsTiltControl']) && $attributes['effectsTiltControl']) {
        wp_enqueue_script('cc-tilter', CWICLY_DIR_URL . 'assets/js/tilter.js', null, CWICLY_VERSION, true);
    }

    if ($hideGuest && $hideLoggedin && cc_conditions_maker($attributes, $block)) {
        return cc_render($content, $attributes, $block);
    }
}
