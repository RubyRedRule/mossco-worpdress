<?php
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

function cwicly_popover_register()
{
    register_block_type(__DIR__, array(
        'render_callback' => 'cc_popover_render_callback',
    ));
}
add_action('init', 'cwicly_popover_register');

function cc_popover_render_callback($attributes, $content, $block)
{
    if (isset($attributes['effectsTiltControl']) && $attributes['effectsTiltControl']) {
        wp_enqueue_script('cc-tilter', CWICLY_DIR_URL . 'assets/js/tilter.js', null, CWICLY_VERSION, true);
    }

    if (function_exists('wp_is_block_theme') && wp_is_block_theme()) {
        $header = false;
    } else {
        $header = true;
    }
    if (!is_admin()) {
        wp_enqueue_script('cc-m-floating-dom', CWICLY_DIR_URL . 'assets/js/floating-dom.min.js', array('cc-m-floating-core'), CWICLY_VERSION, $header);
        wp_enqueue_script('cc-m-floating-core', CWICLY_DIR_URL . 'assets/js/floating-core.min.js', null, CWICLY_VERSION, $header);
        wp_enqueue_script('cc-m-popover', CWICLY_DIR_URL . 'assets/js/cc-popover.min.js', array('cc-m-floating-dom'), CWICLY_VERSION, $header);
        wp_enqueue_script('cc-popover-actions', CWICLY_DIR_URL . 'assets/js/cc-popover-actions.min.js', null, CWICLY_VERSION, $header);
    }

    if (isset($attributes['popoverOptions']) && $attributes['popoverOptions'] && isset($attributes['popoverOptions']['animation']) && $attributes['popoverOptions']['animation'] && $attributes['popoverOptions']['animation'] != 'fade') {
        if (strpos($attributes['popoverOptions']['animation'], 'scale-d-') !== false) {
            wp_enqueue_style('cc-pop-scale', CWICLY_DIR_URL . 'assets/css/popover/scale-d.min.css', null, CWICLY_VERSION);
        } else {
            wp_enqueue_style('cc-pop_anim-' . $attributes['popoverOptions']['animation'] . '', CWICLY_DIR_URL . 'assets/css/popover/' . $attributes['popoverOptions']['animation'] . '.min.css', null, CWICLY_VERSION);
        }
    }

    $hideLoggedin = cc_hide_logged_in($attributes);
    $hideGuest = cc_hide_guest($attributes);

    if ($hideGuest && $hideLoggedin && cc_conditions_maker($attributes, $block)) {
        return cc_render($content, $attributes, $block);
    }
}
