<?php
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

register_block_type(__DIR__, array(
    'render_callback' => 'cc_hook_render_callback',
));

function cc_hook_render_callback($attributes, $content, $block)
{
    $hideLoggedin = cc_hide_logged_in($attributes);
    $hideGuest = cc_hide_guest($attributes);

    if ($hideGuest && $hideLoggedin && cc_conditions_maker($attributes, $block)) {
        if (isset($attributes['hook']) && $attributes['hook']) {
            return do_action($attributes['hook']);
        }
    }
}
