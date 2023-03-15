<?php
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

function cwicly_styler_register()
{
    register_block_type(__DIR__, array(
        'render_callback' => 'cc_styler_render_callback',
    ));
}
add_action('init', 'cwicly_styler_register');

function cc_styler_render_callback($attributes, $content, $block)
{
    return null;
}
