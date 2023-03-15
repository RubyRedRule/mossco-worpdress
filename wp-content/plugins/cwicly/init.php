<?php

/**
 * Blocks Initializer
 *
 * Enqueue CSS/JS of all the blocks.
 *
 * @since     0.1
 * @package Cwicly
 */

// Exit if accessed directly.
if (!defined('ABSPATH')) {
    exit;
}

function cc_add_editor_styles()
{
    add_editor_style(CWICLY_DIR_URL . 'build/style-index.css');
    add_editor_style(CWICLY_DIR_URL . 'core/assets/css/editor-wrapper.css');

    $normaliser = apply_filters('cc_normaliser_editor', CWICLY_DIR_URL . 'core/assets/css/base.css');
    add_editor_style($normaliser);

    add_editor_style(CWICLY_DIR_URL . '/assets/css/hover-animation.css');
    add_editor_style(CWICLY_DIR_URL . '/assets/css/gallery.css');
    add_editor_style(CWICLY_DIR_URL . '/assets/css/splide.css');

    $optimisation = get_option('cwicly_optimise');
    if (isset($optimisation['flexOptimisation']) && $optimisation['flexOptimisation'] === 'true') {
        add_editor_style(CWICLY_DIR_URL . '/core/assets/css/thirdparty.css');
    }
}
add_action('after_setup_theme', 'cc_add_editor_styles');

function register_cwicly_category($block_categories, $post)
{
    array_unshift(
        $block_categories,
        array(
            'slug' => 'cwicly',
            'title' => __('Cwicly Blocks', 'cwicly'),
        )
    );
    return $block_categories;
}
add_filter('block_categories_all', 'register_cwicly_category', 10, 2);
