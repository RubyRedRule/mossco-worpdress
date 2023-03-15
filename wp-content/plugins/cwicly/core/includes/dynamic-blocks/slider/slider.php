<?php
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

function cwicly_slider_register()
{
    register_block_type(__DIR__, array(
        'render_callback' => 'cc_slider_render_callback',
    ));
}
add_action('init', 'cwicly_slider_register');

function cc_slider_render_callback($attributes, $content, $block)
{
    $hideLoggedin = cc_hide_logged_in($attributes);
    $hideGuest = cc_hide_guest($attributes);

    if (!is_admin()) {
        wp_enqueue_style('Swiper', CWICLY_DIR_URL . 'assets/css/swiper.css');
        wp_enqueue_script('Swiper', CWICLY_DIR_URL . 'assets/js/swiper.js', null, false, true);
        wp_enqueue_script('cc-slider', CWICLY_DIR_URL . 'assets/js/cc-slider.min.js', array('Swiper'), false, true);
        wp_enqueue_script('cc-slider-nav', CWICLY_DIR_URL . 'assets/js/cc-slider-nav.min.js', array('Swiper'), CWICLY_VERSION, true);
    }

    if (isset($attributes['effectsTiltControl']) && $attributes['effectsTiltControl']) {
        wp_enqueue_script('cc-tilter', CWICLY_DIR_URL . 'assets/js/tilter.js', null, CWICLY_VERSION, true);
    }

    if ($hideGuest && $hideLoggedin && cc_conditions_maker($attributes, $block)) {
        return cc_render($content, $attributes, $block);
    }
}
