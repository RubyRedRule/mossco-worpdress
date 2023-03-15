<?php
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

register_block_type(__DIR__, array(
    'render_callback' => 'cc_fragment_render_callback',
));

function cc_fragment_render_callback($attributes, $content, $block)
{
    $hideLoggedin = cc_hide_logged_in($attributes);
    $hideGuest = cc_hide_guest($attributes);

    if ($hideGuest && $hideLoggedin && cc_conditions_maker($attributes, $block)) {
        ob_start();
        if (isset($attributes['fragment']) && $attributes['fragment']) {
            $containers = Cwicly\Themer::get_fragment($attributes['fragment']);
            if (isset($containers) && is_array($containers)) {
                foreach ($containers as $templates) {
                    foreach ($templates as $template) {
                        if (isset($template->slug) && isset($template->theme)) {
                            Cwicly\Themer::add_template_styles($template->theme, $template->slug, 'tp');
                        }
                        echo do_blocks($template->content);
                    }
                }
            }
        }
        return ob_get_clean();
    }
}