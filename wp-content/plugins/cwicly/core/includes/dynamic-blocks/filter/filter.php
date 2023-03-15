<?php
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

register_block_type(__DIR__, array(
    'render_callback' => 'cc_filter_render_callback',
));

function cc_filter_render_callback($attributes, $content, $block)
{
    $hideLoggedin = cc_hide_logged_in($attributes);
    $hideGuest = cc_hide_guest($attributes);

    $decoded = (new CCQueryTemplater)->singleBlock($block, false)[0];

    if ($hideGuest && $hideLoggedin && cc_conditions_maker($attributes, $block)) {
        add_action('wp_head', function () use ($decoded, $attributes) {
            echo '<script id="' . $attributes['id'] . '-ft-json" type="application/json">' . json_encode($decoded, JSON_UNESCAPED_SLASHES) . '</script>';
        });
        return cc_render($content, $attributes, $block);
    }
}
