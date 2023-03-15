<?php
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

function cwicly_repeater_register()
{
    register_block_type(__DIR__, array(
        'render_callback' => 'cc_repeater_render_callback',
    ));
}
add_action('init', 'cwicly_repeater_register');

function cc_repeater_render_callback($attributes, $content, $block)
{
    $hideLoggedin = cc_hide_logged_in($attributes);
    $hideGuest = cc_hide_guest($attributes);

    if (isset($attributes['effectsTiltControl']) && $attributes['effectsTiltControl']) {
        wp_enqueue_script('cc-tilter', CWICLY_DIR_URL . 'assets/js/tilter.js', null, CWICLY_VERSION, true);
    }
    if (isset($attributes['repeaterSlider']) && $attributes['repeaterSlider']) {
        wp_enqueue_script('cc-splide', CWICLY_DIR_URL . 'assets/js/splide.min.js', null, CWICLY_VERSION, true);
        wp_enqueue_script('cc-slider-nav', CWICLY_DIR_URL . 'assets/js/cc-slider-nav.min.js', null, CWICLY_VERSION, true);
        wp_enqueue_style('cc-splide', CWICLY_DIR_URL . '/assets/css/splide.css', array(), filemtime(CWICLY_DIR_PATH . 'assets/css/splide.css'));
    }

    if ($hideGuest && $hideLoggedin && cc_conditions_maker($attributes, $block)) {
        return cc_render($content, $attributes, $block);
    }
}
