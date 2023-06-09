<?php
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

function cwicly_gallery_register()
{
    // wp_register_style('Gallery', CWICLY_DIR_URL . 'assets/css/gallery.css');
    register_block_type(__DIR__, array(
        'render_callback' => 'cc_gallery_render_callback',
    ));
}
add_action('init', 'cwicly_gallery_register');

function cc_gallery_render_callback($attributes, $content, $block)
{
    if (isset($attributes['linkWrapperType']) && $attributes['linkWrapperType'] === 'lightbox' && !is_admin()) {
        wp_enqueue_style('cc-lightbox', CWICLY_DIR_URL . 'assets/css/lightbox.css');
        wp_enqueue_script('cc-lightbox', CWICLY_DIR_URL . 'assets/js/lightbox.js', null, CWICLY_VERSION, true);
    }
    if (isset($attributes['effectsTiltControl']) && $attributes['effectsTiltControl']) {
        wp_enqueue_script('cc-tilter', CWICLY_DIR_URL . 'assets/js/tilter.js', null, CWICLY_VERSION, false);
    }

    if (!is_admin()) {
        wp_enqueue_style('cc-gallery', CWICLY_DIR_URL . 'assets/css/gallery.css', null, CWICLY_VERSION);
        wp_enqueue_script('cc-gallery', CWICLY_DIR_URL . 'assets/js/cc-gallery.min.js', null, CWICLY_VERSION, true);
    }

    $hideLoggedin = cc_hide_logged_in($attributes);
    $hideGuest = cc_hide_guest($attributes);

    if ($hideGuest && $hideLoggedin && cc_conditions_maker($attributes, $block)) {
        return cc_render($content, $attributes, $block);
    }
}
