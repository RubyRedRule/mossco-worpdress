<?php
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

function cwicly_menu_register()
{
    register_block_type(__DIR__, array(
        'render_callback' => 'cc_menu_render_callback',
    ));
}
add_action('init', 'cwicly_menu_register');

function cc_menu_render_callback($attributes, $content, $block)
{
    $hideLoggedin = cc_hide_logged_in($attributes);
    $hideGuest = cc_hide_guest($attributes);

    if (function_exists('wp_is_block_theme') && wp_is_block_theme()) {
        $header = false;
    } else {
        $header = true;
    }

    if (isset($attributes['effectsTiltControl']) && $attributes['effectsTiltControl']) {
        wp_enqueue_script('cc-tilter', CWICLY_DIR_URL . 'assets/js/tilter.js', null, CWICLY_VERSION, true);
    }

    if (!is_admin()) {
        wp_enqueue_script('cc-menu', CWICLY_DIR_URL . 'assets/js/cc-menu-new.min.js', null, CWICLY_VERSION, $header);
    }

    if ($hideGuest && $hideLoggedin && cc_conditions_maker($attributes, $block)) {
        return cc_render($content, $attributes, $block);
    }
}
