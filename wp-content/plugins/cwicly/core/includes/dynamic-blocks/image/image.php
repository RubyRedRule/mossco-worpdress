<?php
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

function cwicly_image_register()
{
    register_block_type(__DIR__, array(
        'render_callback' => 'image_render_callback',
    ));
}
add_action('init', 'cwicly_image_register');

function image_render_callback($attributes, $content, $block)
{
    if (isset($attributes['imageAnimation']) && $attributes['imageAnimation']) {
        wp_enqueue_style('cc-hover-animation', CWICLY_DIR_URL . 'assets/css/hover-animation.css');
    }
    if (isset($attributes['effectsTiltControl']) && $attributes['effectsTiltControl']) {
        wp_enqueue_script('cc-tilter', CWICLY_DIR_URL . 'assets/js/tilter.js', null, CWICLY_VERSION, true);
    }
    if (isset($attributes['imageLightbox']) && $attributes['imageLightbox']) {
        wp_enqueue_style('cc-lightbox', CWICLY_DIR_URL . 'assets/css/lightbox.css');
        wp_enqueue_script('cc-lightbox', CWICLY_DIR_URL . 'assets/js/lightbox.js', null, CWICLY_VERSION, true);
    }

    $hideLoggedin = cc_hide_logged_in($attributes);
    $hideGuest = cc_hide_guest($attributes);

    if ($hideGuest && $hideLoggedin && cc_conditions_maker($attributes, $block)) {
        return cc_render($content, $attributes, $block);
    }
}
